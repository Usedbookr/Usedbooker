<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderitem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'order_items';
    
    public function FetchOrder(){
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
    
    public function FetchBook(){
        return $this->hasOne(Book::class, 'id', 'book_id');
    }

}
