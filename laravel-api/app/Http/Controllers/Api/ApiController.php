<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserToken;
use App\User;
use Illuminate\Support\Str;

/**
 * @group management endpoints
 */
class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('ensure.token');
    }

    public function getAllUsers(Request $request)
    {
        $users = User::all();
        foreach($users as $user){
            $api_token = UserToken::where('user_id',$user->id)->get();
            if($api_token->count() > 0){
                $user->api_token = $api_token[0]->api_token;
            }
        }

        return $users->toJson();

    }

}
