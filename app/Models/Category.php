<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function parent()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    public function cat_books()
    {
        return $this->hasMany(Book::class, 'category_id')->limit(15);
    }

    public function books()
    {
        return $this->hasMany(Book::class, 'childcategory_id');
    }

}
