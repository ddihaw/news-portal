<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    public function index()
    {
        $page = Page::all();
        return view('backend.content.page.list', compact('page'));
    }

    public function adding()
    {
        return view('backend.content.page.addingForm');
    }

    public function addingProcess(Request $request)
    {
        $request->validate([
            'pageTitle' => 'required',
            'pageContent' => 'required',
        ]);

        $page = new Page();
        $page->pageTitle = $request->pageTitle;
        $page->pageContent = $request->pageContent;
        $page->isActive = 1;

        try {
            $page->save();
            return redirect(route('page.index'))->with('pesan', ['success', 'Halaman berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect(route('page.index'))->with('pesan', ['danger', 'Halaman gagal ditambahkan']);
        }
    }

    public function modify($id)
    {
        $page = Page::findOrFail($id);
        return view('backend.content.page.modifyForm', compact('page'));
    }

    public function modifyProcess(Request $request)
    {
        $request->validate([
            'idPage' => 'required',
            'pageTitle' => 'required',
            'pageContent' => 'required',
            'isActive' => 'required|boolean',
        ]);

        $page = Page::findOrFail($request->idPage);
        $page->pageTitle = $request->pageTitle;
        $page->pageContent = $request->pageContent;
        $page->isActive = $request->isActive ? 1 : 0;

        try {
            $page->save();
            return redirect(route('page.index'))->with('pesan', ['success', 'Halaman berhasil diperbarui']);
        } catch (\Exception $e) {
            return redirect(route('page.index'))->with('pesan', ['danger', 'Halaman gagal diperbarui']);
        }
    }

    public function delete($id)
    {
        $page = Page::findOrFail($id);

        try {
            $page->delete();
            return redirect(route('page.index'))->with('pesan', ['success', 'Halaman berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect(route('page.index'))->with('pesan', ['danger', 'Halaman gagal dihapus']);
        }
    }
}
