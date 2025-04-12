<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'webmaster') {
            return view('errors.no-access');
        }

        $admins = User::where('role', 'admin')->get();
        return view('admin.partials.user-management', compact('admins'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'webmaster') {
            abort(403);
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'status'   => 'required|in:Active,Inactive',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.user-management')->with('success', 'Admin added successfully.');
    }
}
