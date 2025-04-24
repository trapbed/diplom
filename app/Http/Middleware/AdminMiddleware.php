<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Validator;


use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() == false ) {
            return redirect('login')->withErrors(['auth'=>'Вам не доступна эта страница!']); // Перенаправляем на страницу ошибки
        }
        else if(Auth::user()->role == 'author'){
            return redirect(Auth::user()->role.'/courses')->withErrors(['middleware'=>'Вам не доступна эта страница!']);
        }
        else if(Auth::user()->role == 'student'){
            return redirect('courses')->withErrors(['middleware'=>'Вам не доступна эта страница!']);
        }

        // Если всё в порядке, передаём запрос дальше
        return $next($request);
    }
}
