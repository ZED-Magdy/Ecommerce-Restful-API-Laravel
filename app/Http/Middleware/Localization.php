<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->header('lang');

        if (!$locale) {
            $locale = \config('app.locale');
        }
        if (!\in_array($locale, \config('app.locales'))) {
            return abort(403, 'Language not supported.');
        }

        \app()->setLocale($locale);

        $response = $next($request);

        $response->headers->set('lang', $locale);

        return $response;
    }
}
