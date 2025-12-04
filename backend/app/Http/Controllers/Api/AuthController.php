<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Login user with username/email and password
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('username', 'email', 'password');
        
        // Determine login field (username or email)
        $loginField = filter_var($request->input('username') ?? $request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $loginValue = $request->input($loginField);
        
        // Find user
        $user = User::where($loginField, $loginValue)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Username/email atau password salah',
            ], 401);
        }
        
        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda tidak aktif',
            ], 403);
        }
        
        // Generate JWT token
        $token = JWTAuth::fromUser($user);
        
        // Update last login
        $user->update(['last_login_at' => now()]);
        
        // Create session record
        UserSession::create([
            'user_id' => $user->id,
            'token' => $token,
            'device_type' => $request->input('device_type', 'mobile'),
            'device_name' => $request->input('device_name'),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'last_activity_at' => now(),
            'expires_at' => now()->addMinutes(config('jwt.ttl')),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'employee' => $user->employee,
                ],
            ],
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            $token = JWTAuth::getToken();
            JWTAuth::invalidate($token);
            
            // Delete session record
            $user = JWTAuth::parseToken()->authenticate();
            UserSession::where('user_id', $user->id)
                ->where('token', $token->get())
                ->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout gagal',
            ], 500);
        }
    }

    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        try {
            $newToken = JWTAuth::refresh();
            
            return response()->json([
                'success' => true,
                'message' => 'Token berhasil diperbarui',
                'data' => [
                    'token' => $newToken,
                    'token_type' => 'bearer',
                    'expires_in' => config('jwt.ttl') * 60,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak dapat diperbarui',
            ], 401);
        }
    }

    /**
     * Request password reset
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);
        
        // TODO: Implement password reset token and email sending
        
        return response()->json([
            'success' => true,
            'message' => 'Link reset password telah dikirim ke email Anda',
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
        
        // TODO: Implement password reset logic
        
        return response()->json([
            'success' => true,
            'message' => 'Password berhasil direset',
        ]);
    }
}
