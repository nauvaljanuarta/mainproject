<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisUsers extends Model
{
    use HasFactory;

    protected $table = 'jenis_users';

    protected $fillable = [
        'jenis_user',
        'create_by',
        'delete_mark',
        'update_by'
    ];


    public function users()
    {
        return $this->hasMany(User::class, 'id_jenis_user');
    }
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'setting_menu_users', 'id_jenis_user', 'menu_id')
        ->withTimestamps();
    }
    public function settingMenuUsers()
    {
        return $this->hasMany(SettingMenuUser::class, 'id_jenis_user', 'id');
    }

    
}

