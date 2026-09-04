<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.galleries.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'required|string|max:100',
            'image_url'   => 'required|url',
            'description' => 'nullable|string',
            'event_date'  => 'nullable|date',
        ]);

        Gallery::create([
            'title'       => $request->title,
            'category'    => $request->category,
            'image_url'   => $request->image_url,
            'description' => $request->description,
            'event_date'  => $request->event_date ?? now(),
            'is_featured' => true,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto Galeri Kegiatan berhasil ditambahkan!');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('admin.galleries.index')->with('success', 'Foto Galeri berhasil dihapus!');
    }
}
