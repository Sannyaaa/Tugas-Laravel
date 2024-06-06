<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()){
            $query = Product::query();

            return DataTables::of($query)
            ->addColumn('action', function ($item) {
                return '
                    <a href="' . route('product.gallery.index', $item->id ) . '">
                        Gallery
                    </a>
                    <a href="' . route('product.edit', $item->id ) . '">
                        Edit
                    </a>
                    <form class="inline-block" action="'. route('product.destroy', $item->id ) .'" method="POST">
                        <button class="bg-red-500 text-black rounded-md px-2 py-1 m-2">
                            Delete
                        </button>
                    '. method_field('DELETE') . csrf_field() .'
                    </form>
                ';
            })
            ->editColumn('price', function($item){
                return number_format($item->price);
            })
            ->rawColumns(['action'])
            ->make();
            // ->addColumn('action', function ($query) {
            //     return view('pages.dashboard.product.action', compact('query'));
            // })
        }

        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Product::create($data);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product = Product::findOrFail($product->id);
        return view('pages.dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index');
    }
}
