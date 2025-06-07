<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\News;
use Hash;

class EditorDashboardController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('news')->get();

        $categoryNames = $categories->pluck('nameCategory')->toArray();
        $categoryNewsCounts = $categories->pluck('news_count')->toArray();
        $latestNews = News::with('category')->orderBy('updated_at', 'desc')->take(5)->get();

        return view('backend.content.dashboard.editorDashboard', [
            'categoriesTotal' => $categories->count(),
            'newsTotal' => News::count(),
            'usersTotal' => User::count(),
            'categoryNames' => $categoryNames,
            'categoryNewsCounts' => $categoryNewsCounts,
            'latestNews' => $latestNews,
        ]);
    }



    public function profile()
    {
        $id = Auth::guard('user')->user()->id;
        $users = User::findOrFail($id);
        return view('backend.content.profile', compact('users'));
    }

    public function resetPassword()
    {
        return view('backend.content.resetPassword');
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
                return redirect(url($prefix . '/resetPassword'))->with('pesan', ['success', 'Password berhasil diubah']);
            } catch (\Exception $e) {
                return redirect(url($prefix . '/resetPassword'))->with('pesan', ['danger', 'Gagal mengubah password']);
            }
        } else {
            return redirect(url($prefix . '/resetPassword'))->with('pesan', ['danger', 'Password lama tidak sesuai']);
        }
    }
}
