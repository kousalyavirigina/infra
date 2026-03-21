<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('role','!=','admin')->get();
        return view('admin.users-list', compact('users'));
    }

    public function create()
    {
        return view('admin.create-user');
        
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/admin/users')->with('success','User Created');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role,
        ]);

        if ($request->password) {
            $user->update([
                'password'=>Hash::make($request->password)
            ]);
        }

        return redirect('/admin/users')->with('success','User Updated');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect('/admin/users')->with('success','User Deleted');
    }
}
