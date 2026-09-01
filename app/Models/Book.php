<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookVarient;
class Book extends Model
{
    use HasFactory;
    protected $appends = ['avg_rating','rating_count'];

    public function categories()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }

    public function subcategories()
    {
        return $this->hasOne(Category::class,'id','subcategory_id');
    }

    public function childcategories()
    {
        return $this->hasOne(Category::class,'id','childcategory_id');
    }

    public function author()
    {
        return $this->hasOne(Author::class,'id','author_id');
    }
    
    public function varients()
    {
        return $this->hasMany(BookVarient::class,'book_id','id');
    }
    public function binding()
    {
        return $this->hasMany(BookVarient::class,'book_id','id');
    }
    
    public function getRatingCountAttribute()
    {
        return \App\Models\Ratingreview::where('book_id', $this->id)->Where('status','Active')->count('rating');
    }
    
    public function getAvgRatingAttribute()
    {
        return \App\Models\Ratingreview::where('book_id', $this->id)->Where('status','Active')->avg('rating');
    }

    public function review()
    {
        return $this->hasMany(Ratingreview::class,'book_id','id');
    }
    
}
