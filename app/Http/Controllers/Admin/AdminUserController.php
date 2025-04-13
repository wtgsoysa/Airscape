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

        $data = $request->only(['name', 'email', 'password', 'status']);
        $data['role'] = 'admin';
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.user-management')->with('success', 'Admin added successfully.');
    }

    public function update(Request $request, $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $id,
            'status' => 'required|in:Active,Inactive',
        ]);

        $admin->update($request->only(['name', 'email', 'status']));

        return redirect()->route('admin.user-management')->with('success', 'Admin updated successfully.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'webmaster') {
            abort(403);
        }
    
        $admin = User::where('role', 'admin')->findOrFail($id);
        $admin->delete();
    
        return redirect()->route('admin.user-management')->with('success', 'Admin deleted successfully.');
    }
    
}
