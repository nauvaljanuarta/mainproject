<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'menu_name',
        'menu_link',
        'menu_icon',
        'id_level',
        'parent_id',
        'create_by',
        'update_by',
        'delete_mark'
    ];
    public function scopeNotDeleted($query)
    {
        return $query->where('delete_mark', 'N');
    }

    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function parentMenu()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function jenisUsers()
    {
        return $this->belongsToMany(JenisUsers::class, 'setting_menu_users', 'menu_id', 'id_jenis_user')
        ->withTimestamps();
    }

        public function users()
    {
        return $this->belongsToMany(User::class, 'setting_menu_users', 'menu_id', 'id_jenis_user'); // Assuming you have a pivot table
    }
}
