<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category() {
        return $this->belongsTo(Category::class, "category_id");
    }

    public function orders() {
        return $this->belongsToMany(Order::class, "orders");
    }

    public function orderHistories() {
        return $this->hasMany(Order_history::class);
    }

    public function inventory() {
        return $this->hasMany(Inventory::class);
    }
}
