<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('author')->latest()->paginate(15);
        return view('admin.artikel.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.artikel.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'required|string',
            'media_url'    => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        $validated['author_id']    = auth()->id();
        $validated['slug']         = Str::slug($validated['title']) . '-' . Str::random(4);
        $validated['is_published'] = $request->has('is_published');
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        Article::create($validated);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $artikel)
    {
        return view('admin.artikel.form', ['article' => $artikel]);
    }

    public function update(Request $request, Article $artikel)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'category'     => 'required|string|max:100',
            'excerpt'      => 'nullable|string|max:500',
            'content'      => 'required|string',
            'media_url'    => 'nullable|url',
            'is_published' => 'boolean',
        ]);

        $isPublished = $request->has('is_published');
        $validated['is_published'] = $isPublished;
        if ($isPublished && !$artikel->published_at) {
            $validated['published_at'] = now();
        }

        if ($artikel->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(4);
        }

        $artikel->update($validated);

        return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $artikel)
    {
        $artikel->delete();
        return redirect()->route('admin.artikel.index')->with('success', 'Artikel telah dihapus.');
    }
}
