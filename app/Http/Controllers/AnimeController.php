<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
class AnimeController extends Controller
{
    public function index(): View
    {
        return view('anime');
    }

    public function search(Request $request): View
    {
        $query = $request->get('q');

        if (empty($query)) {
            return redirect()->route('anime.index')->with('error', 'Masukkan kata kunci pencarian!');
        }

        $animes = []; // Fallback kosong
        $error = null;

        try {
            $response = Http::timeout(10)->get('https://api.jikan.moe/v4/anime', [
                'q' => $query,
                'limit' => 10,
                'page' => 1,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $animes = $data['data'] ?? [];
            } else {
                $error = 'API error: ' . $response->status();
            }
        } catch (\Exception $e) {
            $error = 'Gagal fetch data: ' . $e->getMessage();
        }

        return view('anime', compact('animes', 'query', 'error'));
    }
}
