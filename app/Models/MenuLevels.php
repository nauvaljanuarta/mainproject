<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLevels extends Model
{
    use HasFactory;

    // Define the table name if it's not plural by default (optional)
    protected $table = 'menu_levels';

    // Define fillable fields
    protected $fillable = [
        'level',
        'create_by',
        'update_by',
        'delete_mark',
    ];

    /**
     * Define a one-to-many relationship with the Menu model.
     * A menu level can have many menus.
     */
    public function menus()
    {
        return $this->hasMany(Menu::class, 'id_level');
    }
}
