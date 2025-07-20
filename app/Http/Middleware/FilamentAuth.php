<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Symfony\Component\HttpFoundation\Response;

class FilamentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            if ($request->user()->hasRole('admin')) {
                return $next($request);
            }
            Filament::auth()->logout();
            Notification::make()
                ->title('Akses Ditolak')
                ->body('Anda tidak memiliki izin untuk mengakses area ini.')
                ->danger()
                ->persistent()
                ->send();
        }
        
        return redirect(Filament::getLoginUrl());


        return $next($request);
    }
}
