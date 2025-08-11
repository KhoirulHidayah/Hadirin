<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profil
     */
    public function edit()
    {
        $breadcrumb = (object) [
            'title' => 'Manage Profile',
            'list' => ['Home', 'Manage Profile']
        ];
        $page = (object) [
            'title' => ''
        ];
    $activeMenu = 'profile';
    $user = Auth::user();
    return view('profile.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu], compact('user'));
    }

    /**
     * Update username, email, dan avatar
     */
    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:6|max:50', // Diperbarui: minimal 6 karakter
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->username = $request->username;
        $user->email = $request->email;

        // Update avatar jika ada
        if ($request->hasFile('avatar')) {
            // Hapus avatar lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Simpan avatar baru ke public storage
            $path = $request->file('avatar')->store('avatar', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password
     */
   public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        // Validasi password baru
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

}
