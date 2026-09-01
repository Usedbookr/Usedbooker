<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    public function varients()
    {
        return $this->hasMany(BookVarient::class,'book_id','id');
    }
    public function binding()
    {
        return $this->hasMany(BookVarient::class,'book_id','id');
    }
    
    public function categories()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
    
    public function category()
    {
        return $this->hasOne(Category::class,'id','childcategory_id');
    }

    public function review()
    {
        return $this->hasMany(Ratingreview::class,'book_id','id');
    }

    public function product_category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function product_sub_category()
    {
        return $this->hasOne(Category::class,'id','subcategory_id');
    }

    public function product_child_category()
    {
        return $this->hasOne(Category::class,'id','childcategory_id');
    }
}