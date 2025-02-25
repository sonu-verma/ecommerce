<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function items() {
        return $this->hasMany(OrderItem::class, 'id_order');
    }

    public function transaction(){
        return $this->hasOne(Transaction::class,'id_order');
    }
}
