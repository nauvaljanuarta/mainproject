<?php

namespace App\Http\Controllers;

use App\Models\JenisUsers;
use App\Models\Menu;
use App\Models\User;
use App\Models\SettingMenuUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SettingMenuUserController extends Controller
{

    public function index()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::with('subMenus')->where('parent_id', null)->notDeleted()->get();
        return view('admin.setting', ['jenisusers' => $jenisusers, 'menus'=>$menus, 'users'=>$users]);
    }

    public function toggleMenu(Request $request)
    {
        $roleId = $request->input('role_id');
        $menuId = $request->input('menu_id');

        $setting = SettingMenuUser::where('id_jenis_user', $roleId)
            ->where('menu_id', $menuId)
            ->first();

        if ($setting) {
            $setting->delete();
            return redirect()->back()->with('success', 'unactivated');
        } else {
            SettingMenuUser::create([
                'id_jenis_user' => $roleId,
                'menu_id' => $menuId,
                'create_by' => Auth::user()->name,
                'delete_by' => '0',
                'update_by' => Auth::user()->name,
            ]);
            return redirect()->back()->with('success', 'activated');
        }
    }
}
