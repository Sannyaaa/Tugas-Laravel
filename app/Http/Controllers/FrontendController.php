<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;

class FrontendController extends Controller
{
    public function index(){

        $products = Product::with(['galleries'])->latest()->get();
        return view('pages.frontend.index', compact('products'));
    }

    public function details(Request $request, $slug){

        $products = Product::with(['galleries'])->where('slug', $slug)->firstOrFail();
        $recomendations = Product::with(['galleries'])->inRandomOrder()->limit(4)->get();
        return view('pages.frontend.details', compact('products','recomendations'));
    }

    public function cartAdd(Request $request, $id){
        
        
        Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $id,
            // 'quantity' => 1,
            // 'price' => Product::find($id)->price,
            // 'name' => Product::find($id)->name,
            // 'image' => Product::find($id)->image,
        ]);

        return redirect()->route('cart');
    }

    public function cartDelete(Request $request, $id){

        Cart::where('id', $id)->delete();
        return redirect()->route('cart');
    }

    public function cart(Request $request){

        $carts = Cart::with(['products.galleries'])->where('user_id', Auth::user()->id)->get();
        return view('pages.frontend.cart', compact('carts'));
    }

    public function checkout(CheckoutRequest $request){
        $data = $request->all();

        // Get Carts Data
        $carts = Cart::with(['products'])->where('user_id', Auth::user()->id)->get();
                    // $total = 0;
                    // foreach($carts as $cart){
                    //     $total += $cart->products->price * $cart->quantity;
                    // }
                    // $data['user_id'] = Auth::user()->id;
                    // $data['total'] = $total;
                    // $data['status'] = 0;
                    // $order = \App\Models\Order::create($data);

        // Add to Transaction Data
        $data['users_id'] = Auth::user()->id;
        $data['total_price'] = $carts->sum('products.price');

        // Create Transaction
        $transaction = Transaction::create($data);

        // Add to Transaction Details
        foreach($carts as $cart){
            $items[] = TransactionItem::create([
                'transactions_id' => $transaction->id,
                'users_id' => $cart->user_id,
                'products_id' => $cart->product_id,
            ]);
        }

        // Delete Carts
        Cart::where('user_id', Auth::user()->id)->delete();

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Setup variable Midtrans 
        $midtrans = [
            'transaction_details' => [
                'order_id' => 'LUX-' . $transaction->id,
                'gross_amount' => (int) $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
            'enabled_payments' => ['gopay','bank_transfer'],
            'vtweb' => [],
        ];

        // Create Snap Token
        // $snapToken = Snap::getSnapToken($midtrans);

        // Payment Process
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            $transaction->payment_url = $paymentUrl;
            $transaction->save();
            
            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function success(Request $request){
        return view('pages.frontend.success');
    }
}
