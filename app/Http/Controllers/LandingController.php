<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\News;
use App\Models\Page;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hash;

class LandingController extends Controller
{
    public function index()
    {
        $menus = $this->getMenu();

        $latestNews = News::with('category')
            ->orderBy('created_at', 'desc')
            ->where('status', 'Terpublikasi')
            ->take(8)
            ->get();

        $popularNews = News::with('category')
            ->orderByDesc('totalViews')
            ->where('status', 'Terpublikasi')
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

        $comments = Comment::with(['user', 'replies.user'])
            ->where('idNews', $news->idNews)
            ->whereNull('parent_id') // hanya komentar utama
            ->latest()
            ->get();

        return view('frontend.content.article', compact('menus', 'news', 'comments'));
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

        $latestNews = News::with('category')
            ->orderBy('created_at', 'desc')
            ->where('status', 'Terpublikasi')
            ->get();

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

    public function account($id)
    {
        $menus = $this->getMenu();
        $users = User::findOrFail($id);
        return view('frontend.content.account', compact('users', 'menus'));
    }

    public function accountSave(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required'
        ]);

        $users = User::findOrFail($request->id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->role = $request->role;

        try {
            $users->save();
            return redirect(route('user.account', $request->id))->with('pesan', ['success', 'Data berhasil diperbarui']);
        } catch (\Exception $e) {
            return redirect(route('user.account', $request->id))->with('pesan', ['danger', 'Data gagal diperbarui']);
        }
    }

    public function resetPassword()
    {
        $menus = $this->getMenu();
        return view('frontend.content.resetPassword', compact('menus'));
    }

    public function resetPasswordProcess(Request $request)
    {
        $request->validate([
            'oldPassword' => 'required|min:8',
            'newPassword' => 'required|min:8',
            'confirmNewPassword' => 'required_with:newPassword|same:newPassword|min:8',
        ]);

        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;

        $id = Auth::guard('user')->user()->id;
        $user = User::findOrFail($id);
        $prefix = Auth::guard('user')->user()->role;

        if (Hash::check($oldPassword, $user->password)) {
            $user->password = bcrypt($newPassword);

            try {
                $user->save();
                return redirect(route('user.resetPassword'))->with('pesan', ['success', 'Password berhasil diubah']);
            } catch (\Exception $e) {
                return redirect(route('user.resetPassword'))->with('pesan', ['danger', 'Gagal mengubah password']);
            }
        } else {
            return redirect(route('user.resetPassword'))->with('pesan', ['danger', 'Password lama tidak sesuai']);
        }
    }
}