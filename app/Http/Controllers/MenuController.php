<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Page;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::whereNull('menuParent')->with([
            'subMenus' => function ($query) {
                $query->orderBy('menuOrder', 'asc');
            }
        ])->orderBy('menuOrder', 'asc')->get();

        return view('backend.content.menu.list', compact('menu'));
    }

    public function order($id, $idSwap)
    {
        $menu = Menu::find($id);
        $menuSwap = Menu::find($idSwap);

        if ($menu && $menuSwap) {
            $tempOrder = $menu->menuOrder;
            $menu->menuOrder = $menuSwap->menuOrder;
            $menuSwap->menuOrder = $tempOrder;

            try {
                $menu->save();
                $menuSwap->save();
                return redirect()->back()->with('pesan', ['success', 'Urutan menu berhasil diperbarui']);
            } catch (\Exception $e) {
                return redirect()->back()->with('pesan', ['danger', 'urutan menu gagal diperbarui']);
            }
        }
    }

    public function adding()
    {
        $page = Page::where('isActive', 1)->get();
        $parent = Menu::whereNull('menuParent')->where('isActive', 1)->get();

        return view('backend.content.menu.addingForm', compact('page', 'parent'));
    }

    public function addingProcess(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'menuName' => 'required',
            'menuType' => 'required',
            'menuTarget' => 'required',
        ]);

        $menuParent = $request->menuParent;
        if ($menuParent == null) {
            $menuOrder = $this->getMenuOrder();
        } else {
            $menuOrder = $this->getMenuOrder($menuParent);
        }

        $menuUrl = "";
        if ($request->menuType == 'url') {
            $menuUrl = $request->url;
        } else {
            $menuUrl = $request->page;
        }

        $menu = new Menu();
        $menu->menuName = $request->menuName;
        $menu->menuType = $request->menuType;
        $menu->menuUrl = $menuUrl;
        $menu->menuTarget = $request->menuTarget;
        $menu->menuOrder = $menuOrder;
        $menu->menuParent = $menuParent;

        try {
            $menu->save();
            return redirect()->route('menu.index')->with('pesan', ['success', 'Menu berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect()->route('menu.index')->with('pesan', ['danger', 'Menu gagal ditambahkan' . $e->getMessage()]);
        }

    }

    public function modify($id)
    {
        $page = Page::where('isActive', 1)->get();
        $parent = Menu::whereNull('menuParent')->where('isActive', 1)->get();
        $menu = Menu::findOrFail($id);

        return view('backend.content.menu.modifyForm', compact('page', 'parent', 'menu'));
    }

    public function modifyProcess(Request $request)
    {
        $request->validate([
            'idMenu' => 'required',
            'menuName' => 'required',
            'menuType' => 'required',
            'menuTarget' => 'required',
        ]);

        $menuUrl = "";
        if ($request->menuType == 'url') {
            $menuUrl = $request->menuUrl;
        } else {
            $menuUrl = $request->menuUrl;
        }


        $menu = Menu::findOrFail($request->idMenu);
        $menu->menuName = $request->menuName;
        $menu->menuType = $request->menuType;
        $menu->menuUrl = $menuUrl;
        $menu->menuTarget = $request->menuTarget;
        $menu->menuParent = $request->menuParent;
        $menu->isActive = $request->isActive;

        try {
            $menu->save();
            return redirect()->route('menu.index')->with('pesan', ['success', 'Menu berhasil diperbarui']);
        } catch (\Exception $e) {
            return redirect()->route('menu.index')->with('pesan', ['danger', 'Menu gagal diperbarui']);
        }
    }

    public function delete($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            try {
                $menu->delete();
                return redirect()->route('menu.index')->with('pesan', ['success', 'Menu berhasil dihapus']);
            } catch (\Exception $e) {
                return redirect()->route('menu.index')->with('pesan', ['danger', 'Menu gagal dihapus']);
            }
        } else {
            return redirect()->route('menu.index')->with('pesan', ['danger', 'Menu tidak ditemukan:']);
        }
    }

    private function getMenuOrder($parent = null)
    {
        if ($parent == null) {
            $menuOrderNumber = null;
            $order = Menu::select('menuOrder')->whereNull('menuParent')->orderBy('menuOrder', 'desc')->first();
            if ($order == null) {
                $menuOrderNumber = 1;
            } else {
                $menuOrderNumber = $order->menuOrder + 1;
            }
            return $menuOrderNumber;
        } else {
            $subMenuOrderNumber = null;
            $subMenuOrder = Menu::select('menuOrder')->whereNotNull('menuParent')->where('menuParent', '=', $parent)->orderBy('menuOrder', 'desc')->first();
            if ($subMenuOrder == null) {
                $subMenuOrderNumber = 1;
            } else {
                $subMenuOrderNumber = $subMenuOrder->menuOrder + 1;
            }
            return $subMenuOrderNumber;
        }
    }
}
