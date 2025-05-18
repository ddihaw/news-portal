<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->get();
        return view('backend.content.news.list', compact('news'));
    }

    public function adding()
    {
        $categories = Category::all();
        return view('backend.content.news.addingForm', compact('categories'));
    }

    /*public function addingProcess(Request $request)
    {
        $request->validate([
            'newsTitle' => 'required',
            'newsContent' => 'required',
            'newsImage' => 'required',
            'idCategory' => 'required'
        ]);

        $request->file('newsImage')->store('public/images/news/');
        $newsImage = $request->file('newsImage')->hashName();

        $news = new News();
        $news->newsTitle = $request->newsTitle;
        $news->newsContent = $request->newsContent;
        $news->newsImage = $newsImage;
        $news->idCategory = $request->idCategory;


        try {
            $news->save();
            return redirect(route('news.index'))->with('pesan', ['success', 'Berita berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect(route('news.index'))->with('pesan', ['danger', 'Berita gagal disimpan']);
        }
    }*/

    public function addingProcess(Request $request)
    {
        $request->validate([
            'newsTitle' => 'required',
            'newsContent' => 'required',
            'newsImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'idCategory' => 'required'
        ]);

        if (!$request->hasFile('newsImage')) {
            return back()->withErrors(['newsImage' => 'File tidak ditemukan di request']);
        }

        $file = $request->file('newsImage');

        if (!$file->isValid()) {
            return back()->withErrors(['newsImage' => 'File tidak valid']);
        }

        $path = $file->store('images/news', 'public');

        $news = new News();
        $news->newsTitle = $request->newsTitle;
        $news->newsContent = $request->newsContent;
        $news->newsImage = $path;
        $news->idCategory = $request->idCategory;

        try {
            $news->save();
            return redirect(route('news.index'))->with('pesan', ['success', 'Berita berhasil disimpan']);
        } catch (\Exception $e) {
            return back()->withErrors(['db' => 'Gagal menyimpan ke database: ' . $e->getMessage()]);
        }
    }


    public function modify($id)
    {
        $news = News::findOrFail($id);
        return view('backend.content.news.modifyForm', compact('news'));
    }

    public function modifyProcess(Request $request)
    {
        //
    }

    public function delete($id)
    {
        $news = News::findOrFail($id);

        try {
            $news->delete();
            return redirect(route('news.index'))->with('pesan', ['success', 'Berita berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect(route('news.index'))->with('pesan', ['danger', 'Berita gagal dihapus']);
        }
    }
}
