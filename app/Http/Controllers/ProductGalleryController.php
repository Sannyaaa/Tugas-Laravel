<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        if(request()->ajax()){
            $query = ProductGallery::where('products_id', $product->id);

            return DataTables::of($query)
            ->addColumn('action', function ($item) {
                return '
                    <form class="inline-block" action="'. route('gallery.destroy', $item->id ) .'" method="POST">
                        <button class="bg-red-500 text-black rounded-md px-2 py-1 m-2">
                            Delete
                        </button>
                    '. method_field('DELETE') . csrf_field() .'
                    </form>
                ';
            })
            ->editColumn('url', function($item){
                return '<img style="max-width: 150px;" src="'. Storage::url($item->url) .'">';
            })
            ->editColumn('is_featured', function($item){
                return $item->is_featured ? 'Yes' : 'No';
            })
            ->rawColumns(['action','url'])
            ->make();
            // ->addColumn('action', function ($query) {
            //     return view('pages.dashboard.product.action', compact('query'));
            // })
        }

        return view('pages.dashboard.gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        return view('pages.dashboard.gallery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductGalleryRequest $request, Product $product)
    {
        $files = $request->file('files');

        if($request->hasFile('files')){
            foreach($files as $file){
                $path = $file->store('public/gallery');

                ProductGallery::create([
                    'products_id' => $product->id,
                    'url' => $path,
                    // 'is_featured' => $request->is_featured,
                ]);
            }
        }

        return redirect()->route('product.gallery.index', $product->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(ProductGallery $gallery)
    {
        $gallery->delete();
        Storage::delete($gallery->url);
        return redirect()->route('product.gallery.index', $gallery->products_id);
    }
}
