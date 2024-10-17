<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuLevels;
use App\Models\User;
use App\Models\JenisUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class MenuController extends Controller
{

    public function index()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $subMenus = Menu::whereNotNull('parent_id')->notDeleted()->get();
        $levels = MenuLevels::all();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        return view('admin.menu', ['menus'=>$menus, 'users'=>$users, 'jenisusers' => $jenisusers, 'subMenus' => $subMenus, 'levels'=> $levels , 'selectedMenus'=>$selectedMenus]);
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        Menu::create([
            'id_level'  => $request->input('id_level'),
            'menu_name' => $request->input('menu_name'),
            'menu_link' => $request->input('menu_link'),
            'menu_icon' => $request->input('menu_icon') ?? ' ',
            'parent_id' => $request->input('parent_id') ?? null,
            'create_by' => Auth::user()->username,
            'update_by' => Auth::user()->username,
            'delete_mark' => 'N'
        ]);

        return redirect()->back()->with('success', 'Add menu successful.');
    }

    public function show(Menu $menu)
    {
        //
    }


    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $levels = MenuLevels::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $subMenus = Menu::whereNotNull('parent_id')->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();

        return view('admin.menuedit', [
            'menu' => $menu,
            'levels' => $levels,
            'menus' => $menus,
            'subMenus' => $subMenus,
            'selectedMenus' => $selectedMenus
        ]);

    }


    public function update(Request $request,$id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update([
        'id_level'  => $request->input('id_level'),
        'menu_name' => $request->input('menu_name'),
        'menu_link' => $request->input('menu_link'),
        'menu_icon' => $request->input('menu_icon') ?? ' ',
        'parent_id' => $request->input('parent_id') ?? null,
        'update_by' => Auth::user()->username,
    ]);

    return redirect()->back()->with('success', 'Menu updated successfully.');
    }

    public function destroy(Request $request)
    {
        $menuId = $request->input('id');
        $menu = Menu::findOrFail($menuId);

        if ($menu->users()->exists()) { 
            return redirect()->back()->with('error', 'Menu cannot be deleted as it is linked to users.');
        }
        $menu->delete();

        return redirect()->back()->with('success', 'Menu deleted successfully.');

    }
}
