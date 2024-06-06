<?php

namespace App\Http\Controllers\API;

use Midtrans\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function callback(){
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat instance Midtrans Notification
        $notification = new Notification();

        // Assign ke variable untuk memudahkan Coding
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_type;
        $order_id = $notification->order_id;

        // Get transaction Id
        $order = explode('-', $order_id);

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrfail($order[1]);

        //handle notification status midtrans
        if ($status == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card' && $fraud == 'challenge') {
                // TODO set payment status in merchant's database to 'Challenge by FDS'
                // TODO merchant should decide whether this transaction is authorized or not in MAP
                // echo "Transaction order_id: ". $order_id. " is challenged by FDS";

                $transaction->status == 'PENDING';

            } else {
                // TODO set payment status in merchant's database to 'Success'
                // echo "Transaction order_id: ". $order_id. " successfully captured using ". $type;

                $transaction->status == 'SUCCESS';
            }
        } else if ($status == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            // echo "Transaction order_id: ". $order_id. " successfully transfered using ". $type;

            $transaction->status == 'SUCCESS';
            
        } else if ($status == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            // echo "Waiting customer to finish transaction order_id: ". $order_id. " using ". $type;

            $transaction->status == 'PENDING';

        } else if ($status == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using ". $type. " for transaction order_id: ". $order_id. " is denied.";

            $transaction->status == 'PENDING';

        } else if ($status == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            // echo "Payment using ". $type. " for transaction order_id: ". $order_id. " is expired.";

            $transaction->status == 'CANCELLED';

        } else if ($status == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using ". $type. " for transaction order_id: ". $order_id. " is canceled.";

            $transaction->status == 'CANCELLED';

        } else {
            // TODO set payment status in merchant's database to 'Failed'
            echo "Payment using ". $type. " for transaction order_id: ". $order_id. " is failed.";

            $transaction->status == 'CANCELLED';

        }

        // Simpan transaksi 
        $transaction->save();

        // Return response untuk midtrans
        return response()->json([

            'meta' => [
                'code' => 200,
                'message' => 'Midtrans Notification Success'
            ]

        //    'status' => $status,
        //     'type' => $type,
        //     'fraud' => $fraud,
        //     'order_id' => $order_id,
        ]);


    }
}
