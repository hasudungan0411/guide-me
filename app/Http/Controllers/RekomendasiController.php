<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Destination;

class RekomendasiController extends Controller
{
    public function rekomendasiTopK()
    {
        $ratings = DB::table('ulasan')
            ->select('wisatawan_id', 'destinations_id', 'rating')
            ->get();

        // matriks user-item
        $matrix = [];
        foreach ($ratings as $rating) {
            $matrix[$rating->wisatawan_id][$rating->destinations_id] = $rating->rating;
        }

        // vektor item
        $itemVectors = [];
        foreach ($matrix as $userId => $userRatings) {
            foreach ($userRatings as $itemId => $rating) {
                $itemVectors[$itemId][$userId] = $rating;
            }
        }

        // similarity antar item
        $similarityMatrix = [];
        foreach ($itemVectors as $itemA => $ratingsA) {
            foreach ($itemVectors as $itemB => $ratingsB) {
                if ($itemA == $itemB) continue;
                $similarityMatrix[$itemA][$itemB] = $this->cosineSimilarity($ratingsA, $ratingsB);
            }
        }

        $userId = Auth::id();
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
        $topK = array_slice($predictions, 0, 3, true); // Top-5 item

        $recommendedItems = Destination::whereIn('id', array_keys($topK))->get();

        return view('wisatawan.rekomen', compact('recommendedItems'));
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
