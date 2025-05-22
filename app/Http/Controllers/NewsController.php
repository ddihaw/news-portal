<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\News;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with('category')->orderBy('updated_at', 'desc')->get();
        return view('backend.content.news.list', compact('news'));
    }

    public function adding()
    {
        $categories = Category::all();
        return view('backend.content.news.addingForm', compact('categories'));
    }

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
        $categories = Category::all();
        if (!$news) {
            return redirect(route('news.index'))->with('pesan', ['danger', 'Berita tidak ditemukan']);
        }
        return view('backend.content.news.modifyForm', compact('news', 'categories'));
    }

    public function modifyProcess(Request $request)
    {
        $request->validate([
            'newsTitle' => 'required',
            'newsContent' => 'required',
            'idCategory' => 'required'
        ]);

        $news = News::findOrFail(id: $request->idNews);

        $news->newsTitle = $request->newsTitle;
        $news->newsContent = $request->newsContent;
        $news->idCategory = $request->idCategory;

        if ($request->hasFile('newsImage')) {
            $request->validate([
                'newsImage' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $file = $request->file('newsImage');

            if (!$file->isValid()) {
                return back()->withErrors(['newsImage' => 'File tidak valid']);
            }

            if ($news->newsImage && Storage::disk('public')->exists($news->newsImage)) {
                Storage::disk('public')->delete($news->newsImage);
            }

            $path = $file->store('images/news', 'public');
            $news->newsImage = $path;
        }

        try {
            $news->save();
            return redirect(route('news.index'))->with('pesan', ['success', 'Berita berhasil disimpan']);
        } catch (\Exception $e) {
            return back()->withErrors(['db' => 'Gagal menyimpan ke database: ' . $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $news = News::findOrFail($id);

        if ($news->newsImage && Storage::disk('public')->exists($news->newsImage)) {
            Storage::disk('public')->delete($news->newsImage);
        }

        try {
            $news->delete();
            return redirect(route('news.index'))->with('pesan', ['success', 'Berita berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect(route('news.index'))->with('pesan', ['danger', 'Berita gagal dihapus']);
        }
    }

    public function export()
    {
        $news = News::all();
        $pdf = Pdf::loadView('backend.content.news.export', compact('news'));
        return $pdf->download('articles_list.pdf');
    }
}
