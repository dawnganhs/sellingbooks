<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\User;
use Closure;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Auth;

class ProtectedAdminLoginMiddleware extends APIBaseController
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
        if (User::where('id', Auth::guard('api')->id())->where('role', 1)->first()) {
            return $next($request);
        } elseif (User::where('id', Auth::guard('api')->id())->where('role', 0)->first()) {
            return $this->sendError('Sorry! You have no permission to do this !');
        } else {
            return $this->sendError('You must login before you do anything !', 401);
        }
    }
}
