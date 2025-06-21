<?php

namespace App\Http\Controllers;

use App\Models\MotorPrice;
use Illuminate\Http\Request;

class MotorPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePrices(Request $request)
    {
        // İsteği doğrulama
        $validated = $request->validate([
            'data' => 'required|array',
        ]);

        // Örneğin loglama veya veritabanına kaydetme
        foreach ($validated['data'] as $item) {
            //\Log::info('Model: ' . $item['model'] . ' | Price: ' . $item['price']);
        }

        return response()->json(['message' => 'Fiyatlar başarıyla alındı.']);
    }


    /**
     * Display the specified resource.
     */
    public function show(MotorPrice $motorPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MotorPrice $motorPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MotorPrice $motorPrice)
    {
        //
    }
}
