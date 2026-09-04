<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Campaign;
use App\Models\ContentManager;
use App\Models\Gallery;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index()
    {
        $content   = ContentManager::all()->pluck('value', 'key');
        $articles  = Article::published()->latest()->limit(3)->get();
        $campaigns = Campaign::where('is_active', true)->latest()->get();
        $galleries = Gallery::where('is_featured', true)->latest()->get();

        return view('public.index', compact('content', 'articles', 'campaigns', 'galleries'));
    }

    public function lokasi()
    {
        return view('public.lokasi');
    }

    public function kontak()
    {
        return view('public.kontak');
    }

    public function struktur()
    {
        return view('public.struktur');
    }

    public function galeri()
    {
        $galleries = Gallery::latest()->get();
        return view('public.galeri', compact('galleries'));
    }

    public function campaignDetail(string $slug)
    {
        $campaign  = Campaign::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $related   = Campaign::where('is_active', true)->where('id', '!=', $campaign->id)->limit(3)->get();
        return view('public.campaign-detail', compact('campaign', 'related'));
    }

    public function artikel()
    {
        $articles = Article::published()->paginate(9);
        return view('public.artikel', compact('articles'));
    }

    public function artikelDetail(string $slug)
    {
        $article  = Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $related  = Article::published()->where('id', '!=', $article->id)->limit(3)->get();
        return view('public.artikel-detail', compact('article', 'related'));
    }

    public function apiArticles()
    {
        $articles = Article::published()->latest()->get()->map(function($a) {
            $thumbnail = null;
            if ($a->image_url) {
                $thumbnail = $a->image_url;
            } elseif ($a->media_url) {
                if (str_contains($a->media_url, 'youtu')) {
                    preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $a->media_url, $matches);
                    $ytId = $matches[1] ?? null;
                    if ($ytId) {
                        $thumbnail = "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg";
                    }
                } else {
                    $thumbnail = $a->media_url;
                }
            }
            return [
                'id'          => $a->id,
                'title'       => $a->title,
                'slug'        => $a->slug,
                'category'    => $a->category ?? 'Kegiatan',
                'excerpt'     => $a->excerpt ?? Str::limit(strip_tags($a->content), 100),
                'thumbnail'   => $thumbnail,
                'date'        => $a->created_at->format('d M Y'),
                'detail_url'  => route('artikel.detail', $a->slug),
            ];
        });

        return response()->json($articles);
    }
}
