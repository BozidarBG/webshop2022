<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    //category cannot be deleted if it has some products

    public $timestamps=false;

    //protected $primaryKey = 'slug';

    public function products(){
        return $this->hasMany(Product::class);
    }
}