<?php

namespace App\Http\Controllers;

use App\Models\Instagram;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Added for logging

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
            'instagram_username' => 'nullable|string|max:255',
            // 'show_gallery' is now handled by updateGalleryVisibility
        ]);

        $instagrams = Instagram::firstOrNew([]);

        // Upload logo baru
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = $file->store('public/gallery');

            // Hapus logo lama jika ada
            if ($instagrams->logo) {
                Storage::delete('public/' . $instagrams->logo);
            }

            $instagrams->logo = str_replace('public/', '', $path);
        }

        // Simpan Instagram username
        $instagrams->instagram_username = $request->instagram_username;
        // Do NOT update show_gallery here, as it's now handled by the AJAX method.
        $instagrams->save();

        return back()->with('success', 'Pengaturan logo dan username Instagram berhasil diperbarui.');
    }

    /**
     * Update the gallery visibility via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateGalleryVisibility(Request $request)
    {
        try {
            $request->validate([
                'show_gallery' => 'required|boolean'
            ]);

            $instagrams = Instagram::firstOrNew([]);
            $instagrams->show_gallery = $request->show_gallery;
            $instagrams->save();

            $message = $request->show_gallery ? 'Galeri berhasil ditampilkan.' : 'Galeri berhasil disembunyikan.';

            return response()->json(['success' => true, 'message' => $message]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error updating gallery visibility: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Data tidak valid.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating gallery visibility: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server.'], 500);
        }
    }
}