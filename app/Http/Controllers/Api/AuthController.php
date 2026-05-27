<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\OtpVerification;
use App\Models\LoginStamp;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $sms;

    public function __construct(SmsService $sms)
    {
        $this->sms = $sms;
    }

    // REGISTER - Kirim OTP
    public function sendRegisterOtp(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20|unique:users',
            'address' => 'required|string',
        ]);
        if ($v->fails()) return response()->json(['success' => false, 'errors' => $v->errors()], 422);

        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::where('phone', $request->phone)->where('type', 'register')->delete();
        OtpVerification::create([
            'phone' => $request->phone,
            'token' => $token,
            'type' => 'register',
            'expires_at' => now()->addMinutes(2)
        ]);

        cache()->put('register_' . $request->phone, [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address
        ], 600);

        $this->sms->sendOtp($request->phone, $token);

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP dikirim ke ' . $this->maskPhone($request->phone) . '. Berlaku 2 menit.',
            'debug_token' => config('app.debug') ? $token : null,
            'expires_in' => 120
        ]);
    }

    // REGISTER - Verifikasi OTP
    public function verifyRegisterOtp(Request $request)
    {
        $v = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'otp' => 'required|string|size:6'
        ]);
        if ($v->fails()) return response()->json(['success' => false, 'errors' => $v->errors()], 422);

        $otp = OtpVerification::where('phone', $request->phone)->where('type', 'register')
            ->where('token', $request->otp)->first();

        if (!$otp) return response()->json(['success' => false, 'message' => 'Kode OTP tidak valid'], 400);
        if ($otp->isExpired()) return response()->json(['success' => false, 'message' => 'Kode OTP kadaluarsa (2 menit)'], 400);

        $userData = cache()->get('register_' . $request->phone);
        if (!$userData) return response()->json(['success' => false, 'message' => 'Sesi pendaftaran kadaluarsa'], 400);

        $otp->update(['is_verified' => true, 'verified_at' => now()]);

        $user = User::create($userData + ['role' => 'user', 'phone_verified_at' => now(), 'is_first_login' => true]);
        cache()->forget('register_' . $request->phone);

        $token = $user->createToken('auth_token')->plainTextToken;
        $this->recordLogin($user, $request, true);

        return response()->json(['success' => true, 'message' => 'Registrasi berhasil!', 'user' => $user, 'token' => $token], 201);
    }

    // LOGIN
    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'login' => 'required|string', // bisa username, email, atau phone
            'password' => 'required'
        ]);

        if ($v->fails()) return response()->json(['success' => false, 'errors' => $v->errors()], 422);

        $user = User::where('username', $request->login)
            ->orWhere('email', $request->login)
            ->orWhere('phone', $request->login)
            ->with('permissions')  // ← TAMBAH INI
            ->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Login gagal'], 401);
        }

        // SKIP OTP - LANGSUNG LOGIN (untuk testing)
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->recordLogin($user, $request);
        $user->update(['is_first_login' => false]);

        return response()->json([
            'success' => true,
            'require_otp' => false,
            'message' => 'Login berhasil',
            'user' => $user->load('permissions'),
            'token' => $token
        ]);
    }

    // Verifikasi OTP Login
    public function verifyLoginOtp(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|string|size:6'
        ]);
        if ($v->fails()) return response()->json(['success' => false, 'errors' => $v->errors()], 422);

        $user = User::findOrFail($request->user_id);
        $otp = OtpVerification::where('phone', $user->phone)->where('type', 'login')
            ->where('token', $request->otp)->first();

        if (!$otp) return response()->json(['success' => false, 'message' => 'Kode OTP tidak valid'], 400);
        if ($otp->isExpired()) return response()->json(['success' => false, 'message' => 'Kode OTP kadaluarsa (2 menit)'], 400);

        $otp->update(['is_verified' => true, 'verified_at' => now()]);

        $token = $user->createToken('auth_token')->plainTextToken;
        $this->recordLogin($user, $request, true);
        if ($user->is_first_login) $user->update(['is_first_login' => false]);

        return response()->json(['success' => true, 'message' => 'Login berhasil! Perangkat diverifikasi.', 'user' => $user, 'token' => $token]);
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $v = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'type' => 'required|in:register,login'
        ]);
        if ($v->fails()) return response()->json(['success' => false, 'errors' => $v->errors()], 422);

        OtpVerification::where('phone', $request->phone)->where('type', $request->type)->delete();

        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        OtpVerification::create([
            'phone' => $request->phone,
            'token' => $token,
            'type' => $request->type,
            'expires_at' => now()->addMinutes(2)
        ]);
        $this->sms->sendOtp($request->phone, $token);

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP baru dikirim. Berlaku 2 menit.',
            'debug_token' => config('app.debug') ? $token : null,
            'expires_in' => 120
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $last = LoginStamp::where('user_id', $request->user()->id)->latest()->first();
        if ($last) $last->update(['logout_at' => now()]);

        return response()->json(['success' => true, 'message' => 'Logout berhasil']);
    }

    // Profile
    public function profile(Request $request)
    {
        return response()->json(['success' => true, 'user' => $request->user()]);
    }

    // Helpers
    private function recordLogin($user, $request, $verifyDevice = false)
    {
        LoginStamp::create(['user_id' => $user->id, 'ip_address' => $request->ip(), 'user_agent' => $request->userAgent()]);

        if ($verifyDevice) {
            $deviceId = UserDevice::generateDeviceId($request);
            UserDevice::updateOrCreate(
                ['user_id' => $user->id, 'device_id' => $deviceId],
                [
                    'device_name' => $request->device_name ?? $request->userAgent(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'is_verified' => true,
                    'verified_at' => now()
                ]
            );
        }
    }

    private function maskPhone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $len = strlen($phone);
        if ($len <= 4) return $phone;
        return substr($phone, 0, 4) . str_repeat('*', $len - 7) . substr($phone, -3);
    }
}
