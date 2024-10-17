<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


     protected $table = 'users';
     protected $fillable = [
        'nama_user',
        'username',
        'email',
        'password',
        'no_hp',
        'id_jenis_user',
        'status_user',
        'delete_mark',
        'create_by',
        'update_by'

    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_user', 'user_id', 'menu_id'); // 'menu_user' is the pivot table
    }
    public function jenisuser()
    {
        return $this->belongsTo(JenisUsers::class, 'id_jenis_user');
    }

    public function postings()
    {
        return $this->hasMany(Posting::class, 'user_id');
    }
    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }
    
}
