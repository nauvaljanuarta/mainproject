<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'categories';

    // The attributes that are mass assignable.
    protected $fillable = ['category_name'];

    /**
     * Get the books for the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books()
    {
        return $this->hasMany(Books::class);
    }
}
