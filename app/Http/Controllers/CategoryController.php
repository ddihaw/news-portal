<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('backend.content.category.list', compact('category'));
    }

    public function adding()
    {
        return view('backend.content.category.addingForm');
    }

    public function addingProcess(Request $request)
    {
        $prefix = Auth::user()->role;

        $request->validate([
            'nameCategory' => 'required|unique:category,nameCategory'
        ]);

        $category = new Category();
        $category->nameCategory = $request->nameCategory;

        try {
            $category->save();
            return redirect(url($prefix . '/category'))->with('pesan', ['success', 'Kategori berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect(url($prefix . '/category'))->with('pesan', ['danger', 'Kategori gagal ditambahkan']);
        }
    }

    public function modify($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.content.category.modifyForm', compact('category'));
    }

    public function modifyProcess(Request $request)
    {
        $request->validate([
            'idCategory' => 'required',
            'nameCategory' => 'required'
        ]);

        $prefix = Auth::user()->role;
        $category = Category::findOrFail($request->idCategory);
        $category->nameCategory = $request->nameCategory;

        try {
            $category->save();
            return redirect(url($prefix . '/category'))->with('pesan', ['success', 'Kategori berhasil diperbarui']);
        } catch (\Exception $e) {
            return redirect(url($prefix . '/category'))->with('pesan', ['danger', 'Kategori gagal diperbarui']);
        }
    }

    public function delete($id)
    {
        $prefix = Auth::user()->role;
        $category = Category::findOrFail($id);

        try {
            $category->delete();
            return redirect(url($prefix . '/category'))->with('pesan', ['success', 'Kategori berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect(url($prefix . '/category'))->with('pesan', ['danger', 'Kategori gagal dihapus']);
        }
    }

    public function export()
    {
        $category = Category::all();
        $pdf = Pdf::loadView('backend.content.category.export', compact('category'));
        return $pdf->download('category_list.pdf');
    }
}
