<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    public function author_details()
    {
        return $this->hasOne(BlogAuthor::class,'id','author_id');
    }

    public function category_details()
    {
        return $this->hasOne(BlogCategory::class,'id','category_id');
    }

    public function comments_details()
    {
        return $this->hasMany(BlogComment::class,'blog_id','id')->where('status', 'Approve');
    }


}
