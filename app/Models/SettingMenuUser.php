<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingMenuUser extends Model
{
    use HasFactory;
    protected $table = 'setting_menu_users';


    protected $fillable = ['id_jenis_user', 'menu_id', 'create_by', 'delete_by', 'update_by'];

    public function jenisUser()
    {
        return $this->belongsTo(JenisUsers::class, 'id_jenis_user');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
