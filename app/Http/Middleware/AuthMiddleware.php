<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (!Auth::check()) {
           
            return back()->with(['mess'=>'Для перехода на страницу необходимо зарегистрироваться!']);
            // return view('/', ['mess'=>'Для перехода на страницу необходимо зарегистрироваться!']);
        }

        return $next($request);
    }
}
