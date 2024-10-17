<?php

namespace App\Http\Controllers;

use App\Models\JenisUsers;
use App\Models\User;
use App\Models\Menu;
use App\Models\SettingMenuUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::with('subMenus')->whereNull('parent_id')->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        return view('admin.role', ['users'=>$users, 'jenisusers' => $jenisusers, 'menus'=> $menus, 'selectedMenus'=> $selectedMenus]);
    }

    public function store(Request $request)
    {

        JenisUsers::create([
            'jenis_user' => $request->input('jenis_user'),
            'create_by' => Auth::user()->username,
            'delete_mark' => 'N',
            'update_by' => Auth::user()->username,
        ]);

        return redirect()->back()->with('success', 'Role added successfully');
    }

    public function edit($id)
    {
        $users = User::all();
        $jenisusers = JenisUsers::findOrFail($id);
        $menus = Menu::with('subMenus')->where('parent_id', null)->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $selectedMenusRole = $jenisusers->menus->pluck('id')->toArray();

        return view('admin.roleedit', [
            'users' => $users,
            'jenisusers' => $jenisusers,
            'menus' => $menus,
            'selectedMenus' => $selectedMenus,
            'selectedMenusRole' => $selectedMenusRole,
        ]);
    }

    public function update(Request $request, $id)
    {
        $jenisuser = JenisUsers::findOrFail($id);
        $jenisuser->update([
            'jenis_user' => $request->input('jenis_user'),
            'update_by' => Auth::user()->username,
        ]);
        $menus = $request->input('menus', []);

        $menuData = [];
        foreach ($menus as $menuId) {
            $menuData[$menuId] = [
                'create_by' => Auth::user()->username,
                'delete_by' => 'N',
                'updated_at' => now(),
                'update_by' => Auth::user()->username
            ];
        }


        $jenisuser->menus()->sync($menuData);

        return redirect()->back()->with('success', 'Role and menu assignments updated successfully');
    }


    public function destroy($id)
    {
        $jenisusers = JenisUsers::findOrFail($id);
        $jenisusers->delete();

        return redirect()->back()->with('success', 'Role deleted successfully');
    }
}

