<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;


    protected $table = 'categories';


    protected $fillable = ['category_name'];


    public function books()
    {
        return $this->hasMany(Books::class);
    }
}
