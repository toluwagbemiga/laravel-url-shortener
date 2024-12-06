<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UrlController extends Controller
{
    public function index(): View
    {
        $urls = Url::latest()->paginate(10);
        return view('urls.index', compact('urls'));
    }

    public function create(): View
    {
        return view('urls.create');
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'original_url' => 'required|url|max:2048',
            'expires_at' => 'nullable|date|after:now'
        ]);

        $url = Url::create([
            'original_url' => $request->original_url,
            'short_code' => Url::generateShortCode(),
            'expires_at' => $request->expires_at
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $url->id,
                    'original_url' => $url->original_url,
                    'short_code' => $url->short_code,
                    'short_url' => url($url->short_code),
                    'clicks' => $url->clicks,
                    'expires_at' => $url->expires_at,
                    'created_at' => $url->created_at
                ]
            ], 201);
        }

        return redirect()->route('urls.index')->with('success', 'URL shortened successfully!');
    }

    public function show(string $shortCode): JsonResponse|RedirectResponse
    {
        $url = Url::where('short_code', $shortCode)->first();

        if (!$url) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'URL not found'], 404);
            }
            abort(404);
        }

        if ($url->isExpired()) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'URL has expired'], 410);
            }
            abort(410);
        }

        $url->incrementClicks();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'original_url' => $url->original_url,
                    'clicks' => $url->clicks
                ]
            ]);
        }

        return redirect($url->original_url);
    }

    public function stats(string $shortCode): JsonResponse|View
    {
        $url = Url::where('short_code', $shortCode)->first();

        if (!$url) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'URL not found'], 404);
            }
            abort(404);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $url->id,
                    'original_url' => $url->original_url,
                    'short_code' => $url->short_code,
                    'short_url' => url($url->short_code),
                    'clicks' => $url->clicks,
                    'expires_at' => $url->expires_at,
                    'created_at' => $url->created_at
                ]
            ]);
        }

        return view('urls.stats', compact('url'));
    }

    public function apiIndex(): JsonResponse
    {
        $urls = Url::latest()->paginate(10);
        return response()->json([
            'success' => true,
            'data' => $urls->items(),
            'pagination' => [
                'current_page' => $urls->currentPage(),
                'last_page' => $urls->lastPage(),
                'per_page' => $urls->perPage(),
                'total' => $urls->total()
            ]
        ]);
    }
}
