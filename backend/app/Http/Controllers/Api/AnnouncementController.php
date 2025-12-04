<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AnnouncementController extends Controller
{
    /**
     * Get announcements list
     */
    public function index(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $employee = $user->employee;
            
            $announcements = Announcement::where('institution_id', $employee->institution_id)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>=', now());
                })
                ->orderBy('created_at', 'desc')
                ->paginate($request->input('per_page', 10));
            
            return response()->json([
                'success' => true,
                'data' => $announcements,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil pengumuman',
            ], 500);
        }
    }
}
