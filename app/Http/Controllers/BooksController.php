<?php

namespace App\Http\Controllers;

use App\Models\books;
use App\Models\Categories;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Books::all();
        $categories = Categories::all();
        return view('halaman.book', ['books'=>$books],['categories'=>$categories]);
    }


    public function store(Request $request)
    {
        Books::create([
            'book_judul' => $request->input('book_judul'),
            'book_pengarang' => $request->input('book_pengarang'),
            'book_kode' => $request->input('book_kode'),
            'category_id' => $request->input('category_id'),
            ]);

            return redirect()->back()->with('buku berhasil ditambahkan');
    }
    public function destroy($id)
    {
        $book = Books::findOrFail($id);
        $book->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
