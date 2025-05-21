<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $request->validate([
            'nameCategory' => 'required|unique:category,nameCategory'
        ]);

        $category = new Category();
        $category->nameCategory = $request->nameCategory;

        try {
            $category->save();
            return redirect(route('category.index'))->with('pesan', ['success', 'Kategori berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect(route('category.index'))->with('pesan', ['danger', 'Kategori gagal ditambahkan']);
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

        $category = Category::findOrFail($request->idCategory);
        $category->nameCategory = $request->nameCategory;

        try {
            $category->save();
            return redirect(route('category.index'))->with('pesan', ['success', 'Kategori berhasil diperbarui']);
        } catch (\Exception $e) {
            return redirect(route('category.index'))->with('pesan', ['danger', 'Kategori gagal diperbarui']);
        }
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        try {
            $category->delete();
            return redirect(route('category.index'))->with('pesan', ['success', 'Kategori berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect(route('category.index'))->with('pesan', ['danger', 'Kategori gagal dihapus']);
        }
    }

    public function export()
    {
        $category = Category::all();
        $pdf = Pdf::loadView('backend.content.category.export', compact('category'));
        return $pdf->download('category_list.pdf');
    }
}
