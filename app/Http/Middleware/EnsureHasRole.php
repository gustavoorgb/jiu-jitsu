<?php

namespace App\Http\Middleware;

use App\Enums\RolesEnum;
use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasRole {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response {
        $user = $request->user();

        if (!$user) {
            return redirect(Filament::getLoginUrl());
        }
        if ($user->hasRole($role)) {
            return $next($request);
        }

        foreach (RolesEnum::cases() as $role) {
            if ($user->hasRole($role->value)) {
                return redirect("/" . strtolower($role->value));
            }
        }

        return redirect('/');
    }
}
