<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        return view('halaman.categories', ['categories'=>$categories]);
    }

    public function store(Request $request)
    {

        Categories::create([
        'category_name' => $request->input('category_name'),
        ]);

        return redirect('/categories')->with('kategori berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

}
