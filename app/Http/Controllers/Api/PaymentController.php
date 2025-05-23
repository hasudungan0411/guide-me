<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class PaymentController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ID_Tiket' => 'required',
            'ID_Wisata' => 'required',
            'Status' => 'required',
            'total_harga' => 'required',
            'Jumlah_Tiket' => 'required',
            'Tanggal_Transaksi' => 'required',
        ]);
        if ($validator->failed()) {
            return response()->json(data: $validator->errors(), status: 400);
        }

        $transaksi = Transaksi::create([
            'ID_Tiket' => $request->ID_Tiket,
            'ID_Wisata' => $request->ID_Wisata,
            'Status' => $request->Status,
            'total_harga' => $request->total_harga,
            'Jumlah_Tiket' => $request->Jumlah_Tiket,
            'Tanggal_Transaksi' => $request->Tanggal_Transaksi,
        ]); 

        $resp = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->withBasicAuth('SB-Mid-server-1sIhLPtkH6TkkDBk_09acxTw','')
            ->post('https://api.sandbox.midtrans.com/v2/charge', [
                'payment_type' => 'gopay',
                'transaction_details' => [
                    'order_id' => $transaksi->ID_Transaksi,
                    'gross_amount' => $transaksi->total_harga
                ]
            ]);
        if($resp->status() == 201){
            $actions = $resp->json('actions');
            if (empty($actions)){
                return response()->json(['message' => $resp['status_message']], 500);
            }
            $actionMap = [];
            foreach ($actions as $action){
                $actionMap[$action['name']] = $action['url'];
            }

            return response()->json(['qr' => $actionMap['generate-qr-code']]);
        }  
        return response()->json(['message' => $resp->body()], 500);
    }
    
}
