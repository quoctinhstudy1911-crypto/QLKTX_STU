<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // ==== LOGIN ====
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng!']);
        }

        $request->session()->regenerate();

        return Auth::user()->role === 'admin'
            ? redirect('/admin/dashboard')
            : redirect('/student/dashboard');
    }

    // ==== LOGOUT ====
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/')->with('success', 'Bạn đã đăng xuất.');
}

    // ==== FORGOT PASSWORD ====
    public function showForgot()
    {
        return view('auth.forgot_password');
    }

    public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', 'Đã gửi link đặt lại mật khẩu!')
        : back()->withErrors(['email' => __($status)]);
}

    // ==== RESET PASSWORD ====
    public function showReset(Request $request, $token)
    {
        return view('auth.reset_password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->password = Hash::make(request('password'));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('status', '✅ Đổi mật khẩu thành công')
            : back()->withErrors(['email' => '❌ Token không hợp lệ']);
    }

}
