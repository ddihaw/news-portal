<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\News;
use App\Models\Page;

class LandingController extends Controller
{
    public function index()
    {
        $menus = $this->getMenu();
        $latestNews = News::with('category')->orderBy('created_at', 'desc')->take(8)->get();
        $popularNews = News::with('category')
            ->orderByDesc('totalViews')
            ->get()
            ->take(5);
        return view('frontend.content.home', compact('menus', 'latestNews', 'popularNews'));
    }
    public function articlePage($id)
    {
        $menus = $this->getMenu();
        $news = News::findOrFail($id);

        $news->increment('totalViews');
        $news->save();
        return view('frontend.content.article', compact('menus', 'news'));
    }

    public function detailPage($id)
    {
        $menus = $this->getMenu();
        $page = Page::findOrFail($id);
        return view('frontend.content.page', compact('menus', 'page'));
    }

    public function allArticles()
    {
        $menus = $this->getMenu();
        $latestNews = News::with('category')->orderBy('created_at', 'desc')->get();
        return view('frontend.content.allArticles', compact('menus', 'latestNews'));
    }

    public function getMenu()
    {
        $menu = Menu::whereNull('menuParent')
            ->with([
                'subMenus' => function ($query) {
                    $query->where('isActive', 1)
                        ->orderBy('menuOrder', 'asc');
                }
            ])
            ->where('isActive', 1)
            ->orderBy('menuOrder', 'asc')
            ->get();

        $menus = [];
        foreach ($menu as $data) {
            $menuType = $data->menuType;
            $menuUrl = "";

            if ($menuType == 'url') {
                $menuUrl = $data->menuUrl;
            } else {
                $menuUrl = route('landing.detailPage', $data->menuUrl);
            }

            $items = [];
            foreach ($data->subMenus as $subMenu) {
                $subMenuType = $subMenu->menuType;
                $subMenuUrl = "";

                if ($subMenuType == 'url') {
                    $subMenuUrl = $subMenu->menuUrl;
                } else {
                    $subMenuUrl = route('landing.detailPage', $subMenu->menuUrl);
                }

                $items[] = [
                    'subMenuName' => $subMenu->menuName,
                    'subMenuTarget' => $subMenu->menuTarget,
                    'subMenuUrl' => $subMenuUrl,
                ];

            }

            $menus[] = [
                'menuName' => $data->menuName,
                'menuTarget' => $data->menuTarget,
                'menuUrl' => $menuUrl,
                'subMenus' => $items,
            ];
        }
        return $menus;
    }
}