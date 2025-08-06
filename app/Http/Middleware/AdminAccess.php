<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        // Check if user has admin panel access permission
        if (!auth()->user()->can('access_admin_panel')) {
            abort(403, 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}