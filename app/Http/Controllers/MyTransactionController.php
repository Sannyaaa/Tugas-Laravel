<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MyTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $query = Transaction::with(['users'])->where('users_id', Auth::user()->id);

            return DataTables::of($query)
            ->addColumn('action', function ($item) {
                return '
                    <a href="' . route('my-transaction.show', $item->id ) . '">
                        Show
                    </a>
                ';
            })
            ->editColumn('total_price', function($item){
                return number_format($item->total_price);
            })
            ->rawColumns(['action'])
            ->make();
            // ->addColumn('action', function ($query) {
            //     return view('pages.dashboard.product.action', compact('query'));
            // })
        }

        return view('pages.dashboard.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $myTransaction)
    {
        if(request()->ajax()){
            $query = TransactionItem::with(['products'])->where('transactions_id', $myTransaction->id);

            return DataTables::of($query)
            ->editColumn('product.price', function($item){
                return number_format($item->products->price);
            })
            ->rawColumns(['action'])
            ->make();
            // ->addColumn('action', function ($query) {
            //     return view('pages.dashboard.product.action', compact('query'));
            // })
        }

        $transaction = $myTransaction;

        return view('pages.dashboard.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}