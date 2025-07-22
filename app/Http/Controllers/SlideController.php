<?php

namespace App\Http\Controllers;

use App\Models\Instagram;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Slide Show',
            'list'  => ['Home', 'Data Slide Show']
        ];
        $page = (object) [
            'title' => ''
        ];
        $slides = Slide::all();
        $instagrams = Instagram::first();
        $activeMenu = 'slide';
        return view('slide.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu], compact('slides', 'instagrams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048'
        ]);

        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/slides', $filename);

        Slide::create(['filename' => $filename]);

        return back()->with('success', 'Gambar berhasil diupload.');
    }

    public function destroy($id)
    {
        $slide = Slide::findOrFail($id);
        Storage::delete('public/slides/' . $slide->filename);
        $slide->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }

    public function updateInstagrams(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'instagram_username' => 'nullable|string|max:255'
        ]);

        $instagrams = Instagram::firstOrNew([]);

        // Upload logo baru
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('public/gallery'); // disimpan di storage/app/public/gallery

            // Hapus logo lama jika ada
            if ($instagrams->logo) {
                Storage::delete('public/' . $instagrams->logo);
            }

            $instagrams->logo = str_replace('public/', '', $path); // simpan hanya bagian relative
        }

        // Simpan Instagram
        $instagrams->instagram_username = $request->instagram_username;
        $instagrams->save();

        return back()->with('success', 'Pengaturan logo berhasil diperbarui.');
    }
}
