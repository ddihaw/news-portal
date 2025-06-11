<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Hash;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('redirect') && Str::startsWith($request->redirect, url('/'))) {
            session(['url.intended' => $request->redirect]);
        }

        return view('auth.login');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('user')->user();

            $defaultRedirect = match ($user->role) {
                'admin' => '/admin',
                'editor' => '/editor',
                'author' => '/author',
                default => '/',
            };

            return redirect()->intended($defaultRedirect);
        } else {
            return redirect(route('auth.index'))->with('pesan', ['danger', 'Email dan Password salah!']);
        }
    }

    public function signup()
    {
        return view('auth.signup');
    }

    public function signupProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|min:8|same:password',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password_confirmation);
            $user->email_verified_at = now();
            $user->remember_token = Str::random(10);
            $user->save();

            return redirect()->route('auth.index')->with('pesan', ['success', 'Selamat! Akun Anda berhasil dibuat. Silakan login.']);
        } catch (\Exception $e) {
            return redirect()->route('auth.signup')->with('pesan', ['danger', 'Pendaftaran akun gagal. Periksa kembali data Anda.']);
        }
    }

    public function logout()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        }

        return redirect(route('auth.index'));
    }
}
