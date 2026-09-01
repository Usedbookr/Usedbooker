<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function FetchCountry(){
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function FetchState(){
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    
}
