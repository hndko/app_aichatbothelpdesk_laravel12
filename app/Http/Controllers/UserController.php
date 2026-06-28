<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Daftar pengguna sistem (Admin only).
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $data['title'] = 'Kelola User';
        $data['users'] = $query->latest()->paginate(10)->withQueryString();

        return view('backend.users.index', $data);
    }

    /**
     * Tampilkan form tambah pengguna baru.
     */
    public function create()
    {
        $data['title']      = 'Tambah User Baru';
        $data['categories'] = Category::all();

        return view('backend.users.create', $data);
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role'            => ['required', 'in:admin,service_desk,helpdesk,user'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'password'        => ['required', 'string', 'min:6'],
            'specializations' => ['nullable', 'array'],
            'specializations.*' => ['exists:categories,id'],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.unique'      => 'Alamat email ini sudah terdaftar.',
            'role.required'     => 'Peran akses (role) wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'role'     => $validated['role'],
            'phone'    => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        if (in_array($user->role, ['admin', 'service_desk', 'helpdesk']) && !empty($request->specializations)) {
            $user->specializations()->sync($request->specializations);
        }

        return redirect()->route('users.index')
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit pengguna.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        $data['title']      = 'Edit Data User';
        $data['user']       = $user;
        $data['categories'] = Category::all();
        $data['userSpecs']  = $user->specializations->pluck('id')->toArray();

        return view('backend.users.edit', $data);
    }

    /**
     * Perbarui data pengguna yang sudah ada.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'            => ['required', 'in:admin,service_desk,helpdesk,user'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'password'        => ['nullable', 'string', 'min:6'],
            'specializations' => ['nullable', 'array'],
            'specializations.*' => ['exists:categories,id'],
        ], [
            'name.required'  => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique'   => 'Alamat email ini sudah terpakai pengguna lain.',
            'role.required'  => 'Peran akses (role) wajib dipilih.',
            'password.min'   => 'Password minimal 6 karakter.',
        ]);

        $updateData = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'role'  => $validated['role'],
            'phone' => $validated['phone'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        if (in_array($user->role, ['admin', 'service_desk', 'helpdesk'])) {
            $user->specializations()->sync($request->specializations ?? []);
        } else {
            $user->specializations()->detach();
        }

        return redirect()->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Hapus pengguna dari sistem.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus dari sistem.');
    }

    /**
     * Reset password cepat ke default = "password".
     */
    public function resetPassword(string $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'password' => Hash::make('password'),
        ]);

        return redirect()->route('users.index')
            ->with('success', "Password untuk pengguna {$user->name} berhasil direset menjadi: password");
    }
}
