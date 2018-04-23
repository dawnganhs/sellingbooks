<?php

namespace App\Http\Middleware;

use App\Http\Controllers\API\APIBaseController as APIBaseController;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (User::where('id', Auth::guard('api')->id())->first()) {
            return $next($request);
        } else {
            return $this->sendError('You must login before you do anything !');
        }
    }
}
