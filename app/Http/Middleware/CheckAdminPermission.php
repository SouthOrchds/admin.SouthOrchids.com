<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use App\Models\Admin_permission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('admin.login');
        }

        $currentRouteName = $request->route()->getName();

        $hasPermission = Admin_permission::where('admin_id', $admin->id)
                                        ->where('permissions', $currentRouteName)
                                        ->exists();

        if (!$hasPermission) {
            abort(403, 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}
