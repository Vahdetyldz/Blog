<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ChatBotController extends Controller
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent";
    }

    public function ask(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string',
        ]);

        $userPrompt = $request->input('prompt');

        $instruction = <<<EOT
Sen bir blog sitesine entegre edilmiş akıllı bir sohbet botusun.

Eğer kullanıcı bu sitedeki blog içerikleri hakkında bir şey soruyorsa, bu isteği anlamlı bir laravel arama sorgusuna çevir ve şöyle yanıt ver:
SORGULA: [laravel query]

Eğer blogla ilgili değilse, sadece soruyu normal şekilde cevapla.
veri tabanındaki tablolar:
blogs
comments
users

veri tabanının adı: blog_db
Sorguları oluştururken bunları baz alarak sorgu oluştur.

Kullanıcı mesajı:
{$userPrompt}
EOT;

        // İlk API isteği
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $instruction]
                    ]
                ]
            ]
        ]);

        Log::info('Gemini API İlk Yanıtı: ' . $response->body());

        if (!$response->successful()) {
            return response()->json(['error' => 'Gemini API isteği başarısız oldu.'], 500);
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            return response()->json(['response' => 'Gemini yanıtı alınamadı.']);
        }

        // Sorgu olup olmadığını kontrol et
        $queries = [];
        preg_match_all('/SORGULA:\s*(.*?)(?=(SORGULA:|$))/s', $text, $matches);
        if (!empty($matches[1])) {
            $queries = array_map('trim', $matches[1]);
        }

        if (empty($queries)) {
            // Sorgu yoksa direkt cevabı döndür
            return response()->json([
                'response' => $text
            ]);
        }

        // Sorguları çalıştır ve sonuçları topla
        $queryResults = [];
        foreach ($queries as $query) {
            $cleanQuery = str_replace('`', '', $query);
            $results = collect(DB::select($cleanQuery));
            $queryResults[] = $results->isEmpty() 
                ? "Bu sorgu için uygun blog içeriği bulunamadı."
                : "Sorgu sonuçları:\n" . $results->toJson();
        }

        // İkinci API isteği için prompt hazırla
        $followUpPrompt = "Kullanıcı mesajı: {$userPrompt}\n\n";
        $followUpPrompt .= "İlk yanıtın:\n{$text}\n\n";
        $followUpPrompt .= "Sorgu sonuçları:\n";
        foreach ($queryResults as $index => $result) {
            $followUpPrompt .= "Sorgu " . ($index + 1) . " sonucu:\n{$result}\n\n";
        }
        $followUpPrompt .= "Yukarıdaki kullanıcı mesajı ve sorgu sonuçlarına dayanarak uygun bir nihai cevabı üret.";

        // İkinci API isteği
        $followUpResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '?key=' . $this->apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $followUpPrompt]
                    ]
                ]
            ]
        ]);

        Log::info('Gemini API İkinci Yanıtı: ' . $followUpResponse->body());

        if (!$followUpResponse->successful()) {
            return response()->json(['error' => 'Gemini API ikinci isteği başarısız oldu.'], 500);
        }

        $followUpData = $followUpResponse->json();
        $finalText = $followUpData['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$finalText) {
            return response()->json(['response' => 'Gemini nihai yanıtı alınamadı.']);
        }

        return response()->json([
            'response' => $finalText
        ]);
    }
}