<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
   public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        return $next($request);
    }
    return redirect('/');  // Nese nuk eshte admin, ridrejto te faqja kryesore
}
}
