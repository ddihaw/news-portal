<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\News;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;

class NewsController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        if ($role == 'admin' || $role == 'editor') {
            $news = News::with('category')
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $news = News::with('category')
                ->orderBy('updated_at', 'desc')
                ->where('idAuthor', Auth::user()->id)
                ->get();
        }

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
        $news->idAuthor = Auth::user()->id;
        $prefix = Auth::user()->role;

        try {
            $news->save();
            return redirect(url($prefix . '/news'))->with('pesan', ['success', 'Berita berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect(url($prefix . '/news'))->with('pesan', ['danger', 'Berita gagal disimpan' . $e->getMessage()]);
            //return back()->withErrors(['db' => 'Gagal menyimpan ke database: ' . $e->getMessage()]);
        }
    }

    public function modify($id)
    {
        $news = News::findOrFail($id);
        $categories = Category::all();

        if (!$news) {
            $prefix = Auth::user()->role;
            return redirect(url($prefix . '/news'))->with('pesan', ['danger', 'Berita tidak ditemukan']);
        }

        if (Auth::user()->role == 'author' && $news->status == 'Ditolak') {
            return redirect()->back()->with('error', 'Artikel yang ditolak tidak bisa diedit.');
        } else {
            return view('backend.content.news.modifyForm', compact('news', 'categories'));
        }
    }

    public function modifyProcess(Request $request)
    {
        $request->validate([
            'newsTitle' => 'required',
            'newsContent' => 'required',
            'idCategory' => 'required'
        ]);

        $news = News::findOrFail(id: $request->idNews);
        $prefix = Auth::user()->role;

        $news->newsTitle = $request->newsTitle;
        $news->newsContent = $request->newsContent;
        $news->idCategory = $request->idCategory;
        $news->editorNotes = $request->editorNotes;

        if ($prefix == 'editor' || $prefix == 'admin') {
            $news->status = $request->status;
        }

        if ($prefix == 'author') {
            $news->revision = $news->revision + 1;
        }

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
            return redirect(url($prefix . '/news'))->with('pesan', ['success', 'Berita berhasil disimpan']);
        } catch (\Exception $e) {
            return redirect(url($prefix . '/news'))->with('pesan', ['danger', 'Berita gagal disimpan' . $e->getMessage()]);
            //return back()->withErrors(['db' => 'Gagal menyimpan ke database: ' . $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        $news = News::findOrFail($id);
        $prefix = Auth::user()->role;

        if ($news->newsImage && Storage::disk('public')->exists($news->newsImage)) {
            Storage::disk('public')->delete($news->newsImage);
        }

        try {
            $news->delete();
            return redirect(url($prefix . '/news'))->with('pesan', ['success', 'Berita berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect(url($prefix . '/news'))->with('pesan', ['danger', 'Berita gagal dihapus']);
        }
    }

    public function export()
    {
        $news = News::all();
        $pdf = Pdf::loadView('backend.content.news.export', compact('news'));
        return $pdf->download('articles_list.pdf');
    }
}
