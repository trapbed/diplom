<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NoAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user() == true) {
            if(Auth::user()->role == 'student'){
                return redirect()->route(Auth::user()->role.'_account')->with(['mess'=>'Вы не можете перейти на эту старницу.']); // Перенаправляем на страницу ошибки
            }
            else{
                return redirect()->route('main_'.Auth::user()->role)->with(['mess'=>'Вы не можете перейти на эту старницу.']); // Перенаправляем на страницу ошибки
            }
        }

        // Если всё в порядке, передаём запрос дальше
        return $next($request);
        // return $next($request);
    }
}
