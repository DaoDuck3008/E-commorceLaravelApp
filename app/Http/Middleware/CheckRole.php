<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Nếu chưa đăng nhập thì đưa về login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Lấy role từ DB (cột Role)
        $userRole = Auth::user()->Role;

        // Nếu role của user nằm trong danh sách roles được phép
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Ngược lại thì đưa về trang chủ
        return redirect('/')->with('error', 'Bạn không có quyền truy cập.');
    }
}
