<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'slug',
    ];

    public function carts(){
        return $this->belongsTo(Cart::class, 'product_id','id');
    }

    public function galleries(){
        return $this->hasMany(ProductGallery::class,'products_id','id');
        
    }
    //return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    //return $this->belongsToMany(Gallery::class, 'product_gallery', 'products_id', 'gallery_id');


    // public function transactionItems(){
    //     return $this->belongsTo(TransactionItem::class,'products_id','id');
    // }
}
