<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ratingreview extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'ratingreviews';
    protected $fillable = [
        'order_id',
        'book_id',
        'user_id',
        'rating',
        'review',
        'status'
    ];
    
    public function book()
    {
        return $this->belongsTo(\App\Models\Book::class, 'book_id');
    }
    
    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
