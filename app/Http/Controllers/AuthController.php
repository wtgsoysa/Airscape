<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AuthController;


class AuthController extends Controller
{
    public function showRoleSelect() {
        return view('auth.role-selection');
    }

    public function showWebmasterLogin() {
        return view('auth.webmaster-login');
    }

    public function showAdminLogin() {
        return view('auth.admin-login');
    }

    public function loginWebmaster(Request $request) {
        $user = User::where('email', $request->email)->where('role', 'webmaster')->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function loginAdmin(Request $request) {
        $user = User::where('email', $request->email)->where('role', 'admin')->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('admin.role');
    }
}
