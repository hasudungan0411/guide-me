<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\favorit;
use App\Models\galeri;

class FavoritController extends Controller
{
    public function index()
    {
        $user = auth('wisatawan')->user();

        $destinations = $user->favorit()->paginate(6);
        $galleries = galeri::all();

        return view('wisatawan.favorit', compact('destinations', 'galleries'));
    }
    public function toggleFavorit(Request $request, $id)
    {
        if (!Auth::guard('wisatawan')->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $status = $request->input('status');
        $wisatawan_id = Auth::guard('wisatawan')->id();

        if ($status) {
            favorit::firstOrCreate([
                'wisatawan_id' => $wisatawan_id,
                'destination_id' => $id
            ]);
        } else {
            favorit::where('wisatawan_id', $wisatawan_id)
                ->where('destination_id', $id)
                ->delete();
        }

        return response()->json(['success' => true]);
    }
}
