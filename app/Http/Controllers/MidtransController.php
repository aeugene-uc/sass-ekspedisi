<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Midtrans\Config;
use Midtrans\Transaction;

class MidtransController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $body = $request->json()->all();  

        $serverKey = config('midtrans.server_key');
        $orderId = $body['order_id'] ?? '';
        $statusCode = $body['status_code'] ?? '';
        $grossAmount = $body['gross_amount'] ?? '';
        $receivedSignature = $body['signature_key'] ?? '';

        $generatedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        if ($generatedSignature !== $receivedSignature) {
            \Log::warning('MIDTRANS SIGNATURE INVALID', $body);
            return response()->json(['status' => 'invalid signature'], 403);
        }

        \Log::info('MIDTRANS WEBHOOK VALIDATED', $body);

        $transaction_id = $body['transaction_id'] ?? '';

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $transactionStatus = Transaction::status($transaction_id);

        if ($transactionStatus->transaction_status == 'settlement') {
            $pesanan = Pesanan::where('midtrans_order_id', $orderId)->first();

            if ($pesanan) {
                $pesanan->status_id = 2; // Update status to 'Paid'
                $pesanan->save();
                \Log::info('MIDTRANS PAYMENT SETTLED for order_id: ' . $orderId);
            } else {
                \Log::warning('MIDTRANS PAYMENT SETTLED but Pesanan not found for order_id: ' . $orderId);
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
