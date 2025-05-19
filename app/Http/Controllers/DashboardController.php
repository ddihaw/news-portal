<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Auth;
use App\Models\User;
use Hash;

class DashboardController extends Controller
{
    public function index()
    {
        return view(view: 'backend.content.dashboard');
    }

    public function profile()
    {
        return view('backend.content.profile');
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

        if (Hash::check($oldPassword, $user->password)) {
            $user->password = bcrypt($newPassword);

            try {
                $user->save();

                return redirect(route('dashboard.resetPassword'))->with('pesan', ['success', 'Password berhasil diubah']);
            } catch (\Exception $e) {
                return redirect(route('dashboard.resetPassword'))->with('pesan', ['danger', 'Gagal mengubah password']);
            }
        } else {
            return redirect(route('dashboard.resetPassword'))->with('pesan', ['danger', 'Password lama tidak sesuai']);
        }
    }
}
