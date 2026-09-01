<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Orderitem;
class Order extends Model
{
    use HasFactory;

    public function orderitems()
    {
        return $this->hasMany(Orderitem::class,'order_id','id');
    }
    	
	public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    
}
