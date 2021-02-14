<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasMagazaCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $aUser = Auth::user();
        $user = User::where('id',$aUser->id)->with('magaza')->first();
        if (!$user->magaza) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        return $next($request);
    }
}
