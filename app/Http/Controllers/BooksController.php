<?php

namespace App\Http\Controllers;

use App\Models\books;
use App\Models\Categories;
use App\Models\Menu;
use App\Models\JenisUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with('subMenus')->whereNull('parent_id')->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        $books = Books::all();
        $categories = Categories::all();
        return view('halaman.book', ['books'=>$books,'categories'=>$categories, 'menus'=>$menus, 'selectedMenus'=>$selectedMenus]);
    }


    public function store(Request $request)
    {
        Books::create([
            'book_judul' => $request->input('book_judul'),
            'book_pengarang' => $request->input('book_pengarang'),
            'book_code' => $request->input('book_code'),
            'category_id' => $request->input('category_id'),
            'create_by' => Auth::user()->username,
            'update_by' => Auth::user()->username,
            ]);

            return redirect()->back()->with('buku berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'book_judul' => 'required|string|max:255',
            'book_pengarang' => 'required|string|max:255',
            'book_code' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
        ]);


        $book = Books::findOrFail($id);
        $book->book_judul = $request->input('book_judul');
        $book->book_pengarang = $request->input('book_pengarang');
        $book->book_code = $request->input('book_code');
        $book->category_id = $request->input('category_id');
        $book->update_by = Auth::user()->username;
        $book->save();


        return redirect()->back()->with('success', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $book = Books::findOrFail($id);
        $book->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
