<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderitems()
    {
        return $this->hasMany(Order_Item::class, 'order_id');
    }

    public function orderHistories() {
        return $this->hasMany(Order_history::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
