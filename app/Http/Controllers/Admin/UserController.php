<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 20;
        $query = User::latest();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        return response()->json($query->with('permissions')->paginate($perPage));
    }

    public function store(Request $request)
    {

        $data['permissions'] = $request->permissions;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|max:20|unique:users', // ← TAMBAH unique
            'role' => 'required|in:master,admin,kurir,user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'permissions' => $request->permissions, // ← TAMBAH
            'phone_verified_at' => now(),
            'is_first_login' => false,
        ]);

        if ($request->permissions) {
            foreach ($request->permissions as $module => $actions) {
                $user->permissions()->create([
                    'module' => $module,
                    'can_view' => $actions['view'] ?? false,
                    'can_create' => $actions['create'] ?? false,
                    'can_edit' => $actions['edit'] ?? false,
                    'can_delete' => $actions['delete'] ?? false,
                ]);
            }
        }

        return response()->json($user, 201);
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        // Log request

        $data = $request->only(['name', 'email', 'phone', 'address', 'role']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->permissions) {
            $user->permissions()->delete(); // Hapus lama
            foreach ($request->permissions as $module => $actions) {
                $user->permissions()->create([
                    'module' => $module,
                    'can_view' => $actions['view'] ?? false,
                    'can_create' => $actions['create'] ?? false,
                    'can_edit' => $actions['edit'] ?? false,
                    'can_delete' => $actions['delete'] ?? false,
                ]);
            }
        }

        return response()->json($user->fresh());
    }

    public function destroy(int $id)
    {
        // Jangan hapus diri sendiri
        $authUser = auth()->user();
        if ($id == $authUser->id) {
            return response()->json(['error' => 'Tidak bisa hapus diri sendiri'], 400);
        }
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'OK']);
    }
}
