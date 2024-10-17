<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/')->withErrors(['error' => 'You must be logged in to access this page.']);
        }
        if ($role === 'admin' && $user->id_jenis_user !== 1) {
            return redirect()->back()->withErrors(['error' => 'You must be an Admin to access this page.']);
        }

        if ($role === 'penerbit' && $user->id_jenis_user !== 3) {
            return redirect()->back()->withErrors(['error' => 'You must be a Penerbit to access this page.']);
        }

        if ($role === 'user' && $user->id_jenis_user !== 5) {
            return redirect()->back()->withErrors(['error' => 'You must be a User to access this page.']);
        }

        return $next($request);
    }
}
