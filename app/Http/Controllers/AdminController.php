<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\JenisUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $jenisusers = JenisUsers::with('menus.subMenus')->get();
        $menus = Menu::with('subMenus')->whereNull('parent_id')->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        return view('admin.dashboard', ['users'=>$users, 'jenisusers' => $jenisusers, 'menus'=> $menus, 'selectedMenus'=> $selectedMenus]);

    }

    public function laporan()
    {
        $users = User::all();
        $jenisusers = JenisUsers::with('menus.subMenus')->get();
        $menus = Menu::with('subMenus')->whereNull('parent_id')->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        return view('admin.laporan', ['users'=>$users, 'jenisusers' => $jenisusers, 'menus'=> $menus, 'selectedMenus'=> $selectedMenus]);

    }

    public function listpage()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::with('subMenus')->where('parent_id', null)->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        return view('admin.userlist', ['users'=>$users, 'jenisusers' => $jenisusers, 'menus'=> $menus, 'selectedMenus'=> $selectedMenus]);

    }

    public function store(request $request)
    {

        session([
            'create_by' => Auth::id(),
            'update_by' => Auth::id(),
            'status_user' => 'active',
            'delete_mark' => 'N',
        ]);


        User::create([
            'nama_user' => $request->input('nama_user'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'no_hp' => $request->input('no_hp'),
            'id_jenis_user' => $request->input('id_jenis_user'),
            'create_by' => session('create_by', 'default_user'),
            'update_by' => session('update_by', 'default_user'),
            'status_user' => session('status_user', 'inactive'),
            'delete_mark' => session('delete_mark', 'N'),
        ]);

        return redirect()->back()->with('success', 'Add user successful.');

    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        $jenisusers = JenisUsers::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $subMenus = Menu::whereNotNull('parent_id')->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        return view('admin.useredit', ['users'=>$users, 'jenisusers' => $jenisusers, 'menus' => $menus, 'subMenus' => $subMenus, 'selectedMenus'=> $selectedMenus]);
    }

    public function update(Request $request, $id)
{

    $request->validate([
        'nama_user' => 'required|string|max:60',
        'username' => 'required|string|max:60',
        'email' => 'required|email|max:200',
        'no_hp' => 'nullable|string|max:30',
        'id_jenis_user' => 'required|exists:jenis_users,id',
        'password' => 'nullable|string|min:4',
        'menus' => 'nullable|array',
    ]);


    $users = User::findOrFail($id);

    $users->nama_user = $request->input('nama_user');
    $users->username = $request->input('username');
    $users->email = $request->input('email');
    $users->no_hp = $request->input('no_hp');
    $users->id_jenis_user = $request->input('id_jenis_user');


    if ($request->filled('password')) {
        $users->password = Hash::make($request->input('password'));
    }


    $users->save();
    return redirect()->back();
    }

    public function destroy($id)
    {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->back()->with('success', 'User deleted successfully.');

    }
}



