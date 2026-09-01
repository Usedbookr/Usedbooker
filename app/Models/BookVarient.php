<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookVarient extends Model
{
    use HasFactory;
    protected $table = 'book_price';
    
    public function binding_type()
    {
        return $this->hasOne(Binding::class,'id','binding_type_id');
    }

    public function book_condition()
    {
        return $this->hasOne(BookCondition::class,'id','condition_id');
    }

    public function book()
    {
        return $this->belongsTo(\App\Models\Book::class,'id','book_id');
    }
    
    public function book_images()
    {
        return $this->hasMany(ImageUpload::class,'attribute_id','id');
    }
    
}
