<?php

namespace App\Http\Middleware;

use App\Service\Visit\IpVisitService;
use Closure;
use Illuminate\Support\Facades\Auth;

class BeforeMiddleware
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
        //判断是否登录
        if (!Auth::check()) {
            return redirect("/home");
        }
        if (!$request->session()->has("login_user")) {
            //设置用户登录的session
            $user = Auth::user()->toArray();
            $sessionUser = [
                'user_id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name']
            ];
            $request->session()->put($sessionUser);
        }
        //登录用户记录访问路径
        IpVisitService::recordVisit($request);
        return $next($request);
    }
}
