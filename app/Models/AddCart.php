<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddCart extends Model
{
    use HasFactory;

    public function book_details()
    {
        return $this->hasOne(Book::class,'id','book_id');
    }

    public function book_detail()
    {
        return $this->belongsTo(BookVarient::class,'book_id','book_id');
    }
}