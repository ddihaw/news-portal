<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return view('backend.content.user.list', compact('users'));
    }

    public function adding()
    {
        return view('backend.content.user.addingForm');
    }

    public function addingProcess(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = bcrypt($request->email);
        $users->email_verified_at = now();
        $users->remember_token = Str::random();

        try {
            $users->save();
            return redirect(route('user.index'))->with('pesan', ['success', 'Pengguna berhasil ditambahkan']);
        } catch (\Exception $e) {
            return redirect(route('user.index'))->with('pesan', ['danger', 'Pengguna gagal ditambahkan']);
        }
    }

    public function modify($id)
    {
        $users = User::findOrFail($id);
        return view('backend.content.user.modifyForm', compact('users'));
    }

    public function modifyProcess(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $users = User::findOrFail($request->id);
        $users->name = $request->name;
        $users->email = $request->email;

        try {
            $users->save();
            return redirect(route('user.index'))->with('pesan', ['success', 'Pengguna berhasil diperbarui']);
        } catch (\Exception $e) {
            return redirect(route('user.index'))->with('pesan', ['danger', 'Pengguna gagal diperbarui']);
        }
    }

    public function delete($id)
    {
        $users = User::findOrFail($id);

        try {
            $users->delete();
            return redirect(route('user.index'))->with('pesan', ['success', 'Pengguna berhasil dihapus']);
        } catch (\Exception $e) {
            return redirect(route('user.index'))->with('pesan', ['danger', 'Pengguna gagal dihapus']);
        }
    }
}
