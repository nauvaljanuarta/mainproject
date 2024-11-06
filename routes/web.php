<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SettingMenuUserController;
use App\Http\Controllers\JenisUsersController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PostingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Halaman umum
Route::get('/coba', function () {
    return view('coba.coba');
});

Route::get('/dashboard', function () {
    return view('halaman.dashboard');
});

Route::get('/c', function () {
    return view('layout.home');
});

// Rute untuk login dan register
Route::get('/', [UserController::class, 'loginview']);
Route::get('/login', [UserController::class, 'loginview']);
Route::get('/register', [UserController::class, 'registerview']);
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/login/gas', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');



Route::group(['middleware' => 'auth'], function () {

    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index']);
        Route::get('/admin/user', [AdminController::class, 'listpage']);
        Route::post('/admin/user/add', [AdminController::class, 'store'])->name('create.users');
        Route::get('/admin/user/{id}/edit', [AdminController::class, 'edit'])->name('edit.users');
        Route::put('/admin/user/{id}', [AdminController::class, 'update'])->name('update.users');
        Route::delete('/admin/user/{id}', [AdminController::class, 'destroy'])->name('delete.users');

        Route::get('/admin/role', [JenisUsersController::class, 'index']);
        Route::post('/admin/role/add', [JenisUsersController::class, 'store'])->name('create.roles');
        Route::get('/admin/role/{id}/edit', [JenisUsersController::class, 'edit'])->name('edit.roles');
        Route::put('/admin/role/{id}', [JenisUsersController::class, 'update'])->name('update.roles');
        Route::delete('/admin/role/{id}', [JenisUsersController::class, 'destroy'])->name('delete.roles');

        Route::get('/admin/menu', [MenuController::class, 'index']);
        Route::post('/admin/menu/add', [MenuController::class, 'store'])->name('create.menus');
        Route::get('/admin/menu/{id}/edit', [MenuController::class, 'edit'])->name('edit.menus');
        Route::put('/admin/menu/{id}', [MenuController::class, 'update'])->name('update.menus');
        Route::delete('/admin/menu/delete', [MenuController::class, 'destroy'])->name('delete.menus');

        Route::get('/admin/setting', [SettingMenuUserController::class, 'index']);
        Route::post('/menu-assignments/toggle', [SettingMenuUserController::class, 'toggleMenu'])->name('menu-assignments.toggle');

        Route::get('/user/dashboard', [PostingController::class, 'index']);

        // saham
        Route::get('/transaksi/summary', function () {
            $totalEmiten = DB::table('emiten')->count();
            $totalVolume = DB::table('transaksi_harian')->sum('volume');
            $totalValue = DB::table('transaksi_harian')->sum('value');
            $totalFrequency = DB::table('transaksi_harian')->sum('frequency');

            return response()->json([
                'totalEmiten' => $totalEmiten,
                'totalVolume' => $totalVolume,
                'totalValue' => $totalValue,
                'totalFrequency' => $totalFrequency
            ]);
        });
        Route::get('/top5-frequencies', function () {

            $topFrequencies = DB::table('transaksi_harian')
                ->select('stock_code', DB::raw('SUM(frequency) as total_frequency'))
                ->groupBy('stock_code')
                ->orderBy('total_frequency', 'desc')
                ->limit(5)
                ->get();

            return response()->json($topFrequencies);
        });
        Route::get('/transaksi/values', function () {

            $values = DB::table('transaksi_harian')
                ->select('stock_code', DB::raw('SUM(value) as value'))
                ->groupBy('stock_code')
                ->get();

            return response()->json($values);
        });
        Route::get('/transaksi-harian/data', function () {
            $data = DB::table('transaksi_harian')
                ->select('stock_code', 'date_transaction', 'volume', 'value', 'frequency')
                ->orderBy('date_transaction', 'desc')
                ->get();

            return response()->json($data);
        });

        //download pdf
        Route::get('/admin/report', [AdminController::class, 'laporan']);

        Route::get('/emiten/data-summary', function () {
            $emitenData = DB::table('transaksi_harian')
                ->select('stock_code',
                DB::raw('SUM(volume) as total_volume'),
                DB::raw('SUM(value) as total_value'),
                DB::raw('SUM(frequency) as total_frequency'))
                ->groupBy('stock_code')
                ->get();
            return response()->json($emitenData);
        });

    });

    // Rute untuk Penerbit
    Route::middleware('role:penerbit')->group(function () {
        Route::get('/penerbit/dashboard', [PenerbitController::class, 'index']);
    });


    Route::get('/user/dashboard', [PostingController::class, 'index']);
    Route::get('/user/mypost', [PostingController::class, 'mypost']);

    Route::get('/user/post', [PostingController::class, 'create'])->name('add.postings');
    Route::post('/user/post/add', [PostingController::class, 'store'])->name('create.postings');
    Route::get('/user/post/{id}/edit', [PostingController::class, 'edit'])->name('edit.postings');
    Route::put('/user/post/{id}', [PostingController::class, 'update'])->name('update.postings');
    Route::delete('/user/post/{id}', [PostingController::class, 'destroy'])->name('delete.postings');

    Route::post('/postings/{postingId}/like', [PostingController::class, 'addLike'])->name('postings.like');
    Route::post('/postings/{postingId}/unlike', [PostingController::class, 'disLike'])->name('postings.unlike');
    Route::post('/postings/{postingId}/comment', [PostingController::class, 'addComment'])->name('postings.comment');
    Route::delete('/postings/{postingId}/comments/{commentId}', [PostingController::class, 'discomment'])->name('postings.discomment');


    Route::get('/postings/{postingId}/likes', [PostingController::class, 'showLikes'])->name('postings.likes');


    Route::get('/categories', [CategoriesController::class, 'index']);
    Route::post('/categories/submit', [CategoriesController::class, 'store'])->name('submit.categories');
    Route::put('/categories/edit/{category_id}', [CategoriesController::class, 'update'])->name('update.categories');
    Route::delete('/categories/{category_id}', [CategoriesController::class, 'destroy'])->name('delete.categories');

    Route::get('/books', [BooksController::class, 'index']);
    Route::post('/books/submit', [BooksController::class, 'store'])->name('submit.books');
    Route::put('/books/edit/{book_id}', [BooksController::class, 'update'])->name('update.books');
    Route::delete('/books/{book_id}', [BooksController::class, 'destroy'])->name('delete.books');

    Route::get('/user/api',[PostingController::class,'api']);

});

