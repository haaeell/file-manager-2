<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::with('pegawai')->get();

        return view('userManagement.index', compact('users'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('userManagement.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'department_id' => 'required|exists:departments,id',
        ]);

        $pegawai = Pegawai::create([
            'name' => $request->input('name'),
            'department_id' => $request->input('department_id'),
            'phone_number' => $request->input('phone_number', ''),
            'address' => $request->input('address', ''),
            'position' => $request->input('position', ''),
            'no_pegawai' => $request->input('no_pegawai', ''),
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'pegawai',
            'pegawai_id' => $pegawai->id,
            'disk_space' => $request->input('disk_space'),
        ]);

        return redirect()->route('userManagement')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $user = User::with('pegawai')->findOrFail($id);
        $departments = Department::all();
        return view('userManagement.edit', compact('user', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'department_id' => 'required|exists:departments,id',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'disk_space' => $request->input('disk_space'),
        ]);

        $user->pegawai->update([
            'name' => $request->input('name'),
            'department_id' => $request->input('department_id'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address'),
            'position' => $request->input('position'),
            'no_pegawai' => $request->input('no_pegawai'),
        ]);
        return redirect()->route('userManagement')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('userManagement')->with('success', 'User deleted successfully.');
    }
}
