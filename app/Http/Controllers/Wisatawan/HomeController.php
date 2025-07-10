<?php

namespace App\Http\Controllers\wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Blog;
use App\Models\Galeri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        $blogs = Blog::orderBy('id_blog', 'desc')->limit(3)->get();
        $galery = Galeri::all();

        $recommendedItems = collect(); // default empty collection

        if (Auth::check()) {
            $userId = Auth::id();
            $userHasRating = DB::table('ulasan')
                ->where('wisatawan_id', $userId)
                ->exists();

            if ($userHasRating) {
                $ratings = DB::table('ulasan')
                    ->select('wisatawan_id', 'destinations_id', 'rating')
                    ->get();

                // Matriks user-item
                $matrix = [];
                foreach ($ratings as $rating) {
                    $matrix[$rating->wisatawan_id][$rating->destinations_id] = $rating->rating;
                }

                // Vektor item
                $itemVectors = [];
                foreach ($matrix as $userIdLoop => $userRatings) {
                    foreach ($userRatings as $itemId => $rating) {
                        $itemVectors[$itemId][$userIdLoop] = $rating;
                    }
                }

                // Similarityitem
                $similarityMatrix = [];
                foreach ($itemVectors as $itemA => $ratingsA) {
                    foreach ($itemVectors as $itemB => $ratingsB) {
                        if ($itemA == $itemB) continue;
                        $similarityMatrix[$itemA][$itemB] = $this->cosineSimilarity($ratingsA, $ratingsB);
                    }
                }

                $userRatings = $matrix[$userId] ?? [];
                $predictions = [];

                foreach ($similarityMatrix as $itemId => $similarItems) {
                    if (isset($userRatings[$itemId])) continue;

                    $score = 0;
                    $simTotal = 0;

                    foreach ($similarItems as $otherItemId => $similarity) {
                        if (isset($userRatings[$otherItemId])) {
                            $score += $similarity * $userRatings[$otherItemId];
                            $simTotal += $similarity;
                        }
                    }

                    if ($simTotal > 0) {
                        $predictions[$itemId] = $score / $simTotal;
                    }
                }

                arsort($predictions);
                $topK = array_slice($predictions, 0, 3, true);
                $recommendedItems = Destination::whereIn('id', array_keys($topK))->get();
            } else {
                $recommendedItems = $this->getTop3Popular();
            }
        } else {
            $recommendedItems = $this->getTop3Popular();
        }

        return view('wisatawan.home', compact('destinations', 'blogs', 'galery', 'recommendedItems'));
    }

    private function cosineSimilarity($vec1, $vec2)
    {
        $dot = 0; $normA = 0; $normB = 0;
        foreach ($vec1 as $key => $val) {
            $v2 = $vec2[$key] ?? 0;
            $dot += $val * $v2;
            $normA += $val * $val;
            $normB += $v2 * $v2;
        }
        return ($normA && $normB) ? ($dot / (sqrt($normA) * sqrt($normB))) : 0;
    }

    private function getTop3Popular()
    {
        $bobotPembelian = 0.5;

        return DB::table('destinations')
            ->leftJoin('ulasan', 'destinations.id', '=', 'ulasan.destinations_id')
            ->leftJoin('transaksi', function ($join) {
                $join->on('destinations.id', '=', 'transaksi.ID_Wisata')
                    ->where('transaksi.status', '=', 'paid');
            })
            ->select(
                'destinations.id',
                'destinations.nama',
                'destinations.gambar',
                'destinations.deskripsi',
                DB::raw('AVG(ulasan.rating) as avg_rating'),
                DB::raw('COUNT(DISTINCT transaksi.ID_Transaksi) as total_pembelian'),
                DB::raw('(IFNULL(AVG(ulasan.rating), 0) + COUNT(DISTINCT transaksi.ID_Transaksi) * ' . $bobotPembelian . ') as skor')
            )
            ->groupBy('destinations.id', 'destinations.nama', 'destinations.gambar', 'destinations.deskripsi')
            ->orderByDesc('skor')
            ->limit(3)
            ->get();
    }
}
