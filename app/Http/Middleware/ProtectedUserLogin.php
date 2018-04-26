<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\APIBaseController as APIBaseController;
class ProtectedUserLogin extends APIBaseController
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
        if (User::where('id', Auth::guard('api')->id())->first()) {
            return $next($request);
        } else {
            return $this->sendError('You must login before you do anything !', 401);
        }
    }
}
