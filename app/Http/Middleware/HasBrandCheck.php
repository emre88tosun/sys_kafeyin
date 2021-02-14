<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HasBrandCheck
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
        $user = User::where('id',$aUser->id)->with('brand')->first();
        if (!$user->brand) {
            return redirect('/yoneticipaneli/anasayfa');
        }
        return $next($request);
    }
}
