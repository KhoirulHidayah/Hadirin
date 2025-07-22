<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogoFormulir;
use Illuminate\Support\Facades\Storage;

class LogoFormulirController extends Controller
{
    public function edit()
    {
        $breadcrumb = (object) [
            'title' => 'Data Tittle dan Logo',
            'list'  => ['Home', 'Data Tittle dan Logo']
        ];
        $page = (object) [
            'title' => ''
        ];
                $logoFormulir = LogoFormulir::first();
        $activeMenu = 'logo_formulir';
        return view('logo_formulir.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu], compact('logoFormulir'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'header_title' => 'required|string|max:255',
            'logo_left' => 'image|mimes:jpg,jpeg,png|max:2048',
            'logo_right' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $logoFormulir = LogoFormulir::first();

        $data = $request->only(['app_name', 'header_title']);

        // Hapus logo kiri lama jika diunggah logo baru
        if ($request->hasFile('logo_left')) {
            if ($logoFormulir->logo_left && Storage::disk('public')->exists($logoFormulir->logo_left)) {
                Storage::disk('public')->delete($logoFormulir->logo_left);
            }
            $data['logo_left'] = $request->file('logo_left')->store('logos', 'public');
        }

        // Hapus logo kanan lama jika diunggah logo baru
        if ($request->hasFile('logo_right')) {
            if ($logoFormulir->logo_right && Storage::disk('public')->exists($logoFormulir->logo_right)) {
                Storage::disk('public')->delete($logoFormulir->logo_right);
            }
            $data['logo_right'] = $request->file('logo_right')->store('logos', 'public');
        }

        $logoFormulir->update($data);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

}
