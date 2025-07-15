<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if ($request->has('lang')) {
            Session::put('locale', $request->get('lang'));
        }

        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }

        if ($request->is('admin/*')) {
    return $next($request); // skip locale setting
}


        return $next($request);
    }
 

    
}
