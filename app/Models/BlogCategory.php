<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    public function blog_details()
    {
        return $this->hasMany(Blog::class,'category_id','id');
    }

}
