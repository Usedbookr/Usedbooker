<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'wishlists';
    protected $fillable = [
        'user_id',
        'book_id',
    ];
    
    
    public function product()
    {
        return $this->hasOne(Books::class,'id','book_id');
    }
    
    public function customer()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
