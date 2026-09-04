<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SqrClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'sqrClass']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        $users = $query->orderBy('name')->paginate(15);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles   = Role::all();
        $classes = SqrClass::where('is_active', true)->get();

        return view('admin.users.form', compact('roles', 'classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'gender'    => 'required|in:L,P',
            'password'  => 'required|string|min:8',
            'role'      => 'required|exists:roles,name',
            'classId'   => 'nullable|exists:classes,id',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'gender'   => $validated['gender'],
            'password' => Hash::make($validated['password']),
            'class_id' => $validated['classId'] ?? null,
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')->with('success', "Pengguna {$user->formatted_name} berhasil ditambahkan dengan role {$validated['role']}.");
    }

    public function edit(User $user)
    {
        $roles   = Role::all();
        $classes = SqrClass::where('is_active', true)->get();

        return view('admin.users.form', compact('user', 'roles', 'classes'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'gender'   => 'required|in:L,P',
            'password' => 'nullable|string|min:8',
            'role'     => 'required|exists:roles,name',
            'classId'  => 'nullable|exists:classes,id',
        ]);

        $user->name     = $validated['name'];
        $user->email    = $validated['email'];
        $user->gender   = $validated['gender'];
        $user->class_id = $validated['classId'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'Data akun pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
