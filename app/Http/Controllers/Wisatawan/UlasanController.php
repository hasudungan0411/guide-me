<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Ulasan;
use App\Models\Destination;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request, $destinationId)
    {
        // Pastikan user sudah login
        if (!Auth::guard('wisatawan')->check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu untuk mengirim ulasan!']);
        }

        // Validasi input
        $validated = $request->validate([
            'ulasan' => 'required|string|max:1000',
            'rating' => 'required|integer|between:1,5',
        ]);

        // Menemukan destinasi berdasarkan ID
        $destination = Destination::findOrFail($destinationId);

        // Mendapatkan wisatawan yang sedang login
        $wisatawan = Auth::guard('wisatawan')->user();

        // Menyimpan ulasan dan rating
        $ulasan = Ulasan::create([
            'destinations_id' => $destination->id,
            'wisatawan_id' => $wisatawan->ID_Wisatawan,
            'ulasan' => $request->ulasan,
            'rating' => $request->rating,
        ]);

        // Menghitung rata-rata rating setelah ulasan baru ditambahkan
        $averageRating = $destination->ulasan()->avg('rating');
        $ulasanCount = $destination->ulasan()->count();

        return response()->json([
            'success' => true,
            'message' => 'Ulasan berhasil ditambahkan!',
            'ulasan' => $ulasan,
            'averageRating' => number_format($averageRating, 1),
            'ulasanCount' => $ulasanCount,
        ]);
    }

    public function loadMoreUlasan(Request $request, $destinationId)
    {
        $destination = Destination::findOrFail($destinationId);

        // Ambil halaman yang diminta atau default ke halaman 1
        $page = $request->get('page', 1);

        // Ambil 3 ulasan per halaman, menyesuaikan halaman yang diminta
        $ulasan = $destination->ulasan()->paginate(3, ['*'], 'page', $page);

        // Jika tidak ada ulasan lebih lanjut, kembalikan HTML kosong
        if ($ulasan->isEmpty()) {
            return response()->json(['html' => '', 'finished' => true]);
        }

        // Generate HTML untuk ulasan baru
        $response = '';
        foreach ($ulasan as $ulasanItem) {
            $response .= '<div class="ulasan-item" id="ulasan-' . $ulasanItem->id . '">
                   <h6>' . $ulasanItem->wisatawan->Nama . '</h6>
                   <small>' . $ulasanItem->created_at->format('d M Y') . '</small>
                   <p><strong>Rating: </strong>';

            // Loop untuk bintang yang terisi
            for ($i = 1; $i <= $ulasanItem->rating; $i++) {
                $response .= '<span class="fa fa-star checked" style="margin-right: 3px;"></span>';  // Bintang terisi
            }

            // Loop untuk bintang yang kosong
            for ($i = $ulasanItem->rating + 1; $i <= 5; $i++) {
                $response .= '<span class="fa fa-star" style="margin-right: 3px;"></span>';  // Bintang kosong
            }

            $response .= '</p><p>' . $ulasanItem->ulasan . '</p><hr></div>';
        }

        // Return json response dengan HTML dan status finished
        return response()->json([
            'html' => $response,
            'finished' => !$ulasan->hasMorePages(),
        ]);
    }
}
