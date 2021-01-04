<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UserToken;
use Illuminate\Support\Str;

/**
 * @group management endpoints
 */
class ManagementController extends Controller
{
    public function getApiTokenById(Request $request, $id)
    {
        $api_token = UserToken::where('user_id',$id)->get();
        if($api_token->count() > 0){
            return response()->json([
                'status' => 'success',
                'api_token'=> $api_token[0]->api_token
            ]);
        }
        return response()->json([
            'status' => 'error',
        ]);

    }

    public function generateApiTokenById(Request $request)
    {
        
        if($request->has('id')){
            $user_id = $request->input('id');
            $user_tokens = UserToken::where('user_id',$user_id)->get();
            $new_token = Str::random(32);
            if($user_tokens->count() > 0){
                $user_token = $user_tokens[0];
                $user_token->update(['api_token'=>$new_token]);
                $user_token->save();
            }else{
                UserToken::create(['user_id'=>$user_id, 'api_token'=>$new_token]);
            }
            return response()->json([
                'status' => 'success',
                'api_token'=> $new_token
            ]);


        }
        return response()->json([
            'status' => 'error',
        ]);

    }
}
