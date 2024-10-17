<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JenisUsers;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();
        $menus = Menu::where('parent_id', null)->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();

        return view('user.dashboard', ['users'=>$users, 'jenisusers' => $jenisusers, 'menus'=> $menus, 'selectedMenus'=>$selectedMenus]);

    }
    public function registerview()
    {
        $users = User::all();
        $jenisusers = JenisUsers::all();

        return view('auth.register', ['users'=>$users, 'jenisusers' => $jenisusers]);

    }

    public function register(request $request)
    {

        session([
            'create_by' => 'system',
            'update_by' => 'system',
            'status_user' => 'active',
            'delete_mark' => 'N',
        ]);


        User::create([
            'nama_user' => $request->input('nama_user'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'no_hp' => $request->input('no_hp'),
            'id_jenis_user' => $request->input('id_jenis_user', 2),
            'create_by' => session('create_by', 'default_user'),
            'update_by' => session('update_by', 'default_user'),
            'status_user' => session('status_user', 'inactive'),
            'delete_mark' => session('delete_mark', 'N'),
        ]);

        return redirect('/')->with('success', 'Registration successful. Please log in.');

    }

    public function loginview()
    {
        return view('auth.login');

    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            $user = Auth::user();

            if ($user->id_jenis_user == 1) {
                return redirect()->intended('/admin/dashboard')->with('success', 'Welcome Admin!');
            } else {
                return redirect()->intended('/user/dashboard')->with('success', 'Welcome User!');
            }
        }

        return redirect('/')->withErrors(['error' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }



}
