<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'books';

    // The attributes that are mass assignable.
    protected $fillable = ['book_kode', 'book_judul', 'book_pengarang', 'category_id'];

    /**
     * Get the category that owns the book.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
