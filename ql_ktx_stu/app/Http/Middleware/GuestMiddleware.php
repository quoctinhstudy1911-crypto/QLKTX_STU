<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 public function handle($request, Closure $next)
{
    // Nếu đang đăng nhập → đẩy về dashboard tương ứng
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect('/admin/dashboard')
            : redirect('/student/dashboard');
    }

    // Nếu KHÔNG đăng nhập → cho vào trang guest bình thường
    return $next($request);
}
}
