<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Menu;
use App\Models\JenisUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categories::all();
        $menus = Menu::with('subMenus')->whereNull('parent_id')->notDeleted()->get();
        $currentUserRole = Auth::user()->id_jenis_user;
        $selectedMenus = JenisUsers::findOrFail($currentUserRole)->menus->pluck('id')->toArray();
        return view('halaman.categories', ['categories'=>$categories, 'menus'=>$menus, 'selectedMenus'=>$selectedMenus]);
    }

    public function store(Request $request)
    {

        Categories::create([
        'category_name' => $request->input('category_name'),
        ]);

        return redirect('/categories')->with('kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);


        $category = Categories::findOrFail($id);
        $category->category_name = $request->input('category_name');
        $category->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

}
