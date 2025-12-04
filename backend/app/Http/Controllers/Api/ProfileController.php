<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends Controller
{
    /**
     * Get current user profile
     */
    public function show()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'avatar' => $user->avatar ? url('storage/' . $user->avatar) : null,
                    'employee' => $user->employee ? [
                        'id' => $user->employee->id,
                        'employee_number' => $user->employee->employee_number,
                        'full_name' => $user->employee->full_name,
                        'email' => $user->employee->email,
                        'phone' => $user->employee->phone,
                        'birth_date' => $user->employee->birth_date,
                        'address' => $user->employee->address,
                        'join_date' => $user->employee->join_date,
                        'status' => $user->employee->status,
                        'institution' => $user->employee->institution,
                        'branch' => $user->employee->branch,
                        'department' => $user->employee->department,
                        'position' => $user->employee->position,
                    ] : null,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data profile',
            ], 500);
        }
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            $request->validate([
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);
            
            // Update user email if provided
            if ($request->has('email')) {
                $user->update(['email' => $request->email]);
            }
            
            // Update employee data if exists
            if ($user->employee) {
                $employeeData = $request->only(['phone', 'address']);
                $user->employee->update($employeeData);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diperbarui',
                'data' => $user->fresh(['employee']),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profile',
            ], 500);
        }
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);
            
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password lama tidak sesuai',
                ], 400);
            }
            
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Password berhasil diubah',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah password',
            ], 500);
        }
    }

    /**
     * Upload avatar
     */
    public function uploadAvatar(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Store new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            
            $user->update(['avatar' => $path]);
            
            return response()->json([
                'success' => true,
                'message' => 'Avatar berhasil diupload',
                'data' => [
                    'avatar_url' => url('storage/' . $path),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload avatar',
            ], 500);
        }
    }
}
