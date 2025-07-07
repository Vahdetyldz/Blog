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
Sen bir blog sitesine entegre edilmiş, Türkçe konuşan bir yapay zeka sohbet botusun.

Kurallar:
1. Eğer kullanıcı blog içerikleriyle ilgili bir şey sorarsa, bu isteği anlamlı ve güvenli bir Laravel SQL sorgusuna çevir. Sadece şu formatta döndür: SORGULA: [laravel query]
2. Eğer kullanıcı blog, içerik, yazı, kategori, yorum, kullanıcı veya veritabanı ile ilgili bir şey sormuyorsa, kullanıcının sorusunu doğrudan, kısa ve net şekilde cevapla. Asla "blogla ilgili değil", "üzgünüm", "veremem", "sadece blogla ilgili soruları yanıtlayabilirim" gibi uyarı, olumsuz veya kısıtlayıcı cümleler kurma. Sadece soruyu yanıtla.
3. Yanıtlarında markdown, yıldız, tire, başlık, kod bloğu, italik, kalın, tablo, satırbaşı gibi biçimlendirme veya özel karakter kullanma. Sadece düz metin döndür.
4. Gereksiz tekrar, selamlama veya açıklama ekleme. Sadece istenen bilgiyi ver.

Veritabanı tabloları:
blogs
comments
users
categories

Veritabanı adı: blog_db
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

        // Düz metin olarak döndür (Markdown veya HTML yok)
        $plainText = preg_replace('/[\*`_\-#>]/', '', $finalText); // *, `, _, -, #, > kaldır
        $plainText = preg_replace('/\n{2,}/', "\n", $plainText); // fazla boş satırı teke indir
        $plainText = trim($plainText);

        return response()->json([
            'response' => $plainText
        ]);
    }
}