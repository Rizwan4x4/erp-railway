<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class CheckSessionExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//        dd('ok');
//         //Check if the user's session has expired
//        if (empty(Session::all())) {
//        dd('ok');
//
//            return view('index', ['name' => 'index']);
//            return redirect()->back();
//            return Redirect::to('/');
//            dd('Expired');
//        }

        return $next($request);
    }
}
