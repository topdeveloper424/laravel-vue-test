<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\UserToken;

class EnsureTokenIsValid
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
        $token = $request->header('token');
        $email = $request->header('email');
        $user = User::where('email', $email)->first();
        if($user){
            $user_token = UserToken::where('user_id', $user->id)->where('api_token',$token)->first();
            if ($token && $user_token && $user){
                return $next($request);
            }
        }

        return response()->json(['status'=>'Invalid api token']);
    }
}
