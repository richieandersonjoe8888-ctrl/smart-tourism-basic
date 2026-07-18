<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('lang');

        if ($locale && in_array($locale, ['en', 'id'])) {
            Cookie::queue('locale', $locale, 60 * 24 * 365);
            App::setLocale($locale);
        } else {
            $cookieLocale = $request->cookie('locale');
            if ($cookieLocale && in_array($cookieLocale, ['en', 'id'])) {
                App::setLocale($cookieLocale);
            } else {
                App::setLocale('en');
            }
        }

        return $next($request);
    }
}
