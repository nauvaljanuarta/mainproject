<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JenisUsers;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class PenerbitController extends Controller
{
    public function index()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();

        return view('penerbit.dashboard', ['users'=>$users, 'jenisusers' => $jenisusers, 'menus'=> $menus, 'selectedMenus'=>$selectedMenus]);

    }
}
