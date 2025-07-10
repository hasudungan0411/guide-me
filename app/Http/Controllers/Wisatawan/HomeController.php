<?php

namespace App\Http\Controllers\wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Blog;
use App\Models\galeri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua destinasi untuk slider
        $destinations = Destination::all();

        // // Ambil 3 destinasi terpopuler berdasarkan click_count
        // $popularDestinations = Destination::orderBy('click_count', 'desc')->limit(3)->get();

        // ambil blog nya 
        $blogs = Blog::orderBy('id_blog', 'desc')->limit(3)->get();

        // ambil galerinya 
        $galery = Galeri::all();

        // rekomendasi top 3 dan top k
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

                // Kesamaan antar item
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
                $bobotPembelian = 0.5;
                $recommendedItems = DB::table('destinations')
                    ->leftJoin('ulasan', 'destinations.id', '=', 'ulasan.destinations_id')
                    ->leftJoin('transaksi', function ($join) {
                        $join->on('destinations.id', '=', 'transaksi.ID_Wisata')
                            ->where('transaksi.status', '=', 'paid');
                    })
                    ->select(
                        'destinations.id',
                        'destinations.tujuan',
                        'destinations.gambar',
                        'destinations.desk',
                        DB::raw('AVG(ulasan.rating) as avg_rating'),
                        DB::raw('COUNT(DISTINCT transaksi.ID_Transaksi) as total_pembelian'),
                        DB::raw('(IFNULL(AVG(ulasan.rating), 0) + COUNT(DISTINCT transaksi.ID_Transaksi) * ' . $bobotPembelian . ') as skor')
                    )
                    ->groupBy('destinations.id', 'destinations.tujuan', 'destinations.gambar', 'destinations.desk')
                    ->orderByDesc('skor')
                    ->limit(3)
                    ->get();
            }

            return view('wisatawan.home', compact('destinations', 'blogs', 'galery', 'recommendedItems'));
        }


        
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
}
 