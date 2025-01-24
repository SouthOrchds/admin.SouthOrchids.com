<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['image_url'];
    
    public function getImageUrlAttribute()
    {
        return $this->product_image 
            ? asset($this->product_image) 
            : null;
    }

    public function category() {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function ordersItems() {
        return $this->belongsToMany(Order_Item::class, 'product_id');
    }

    public function orderHistories() {
        return $this->hasMany(Order_history::class);
    }

    public function inventory() {
        return $this->hasMany(Inventory::class);
    }
}
