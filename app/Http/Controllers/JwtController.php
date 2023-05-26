<?php
namespace App\Http\Controllers;
use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
Use Closure;
class JwtController extends Controller
{
    public function get(Request $request,Response $response){
        $email = $request->input('email');
        if(empty($email) || is_null($email)){
            return response()->json('email empty',404);
        }else{
            $Itoken = RefreshToken::select('refresh_token')->where('email','=',$email)->limit(1)->get();
            $token = json_decode(json_encode($Itoken));
            if(is_null($token)){
                return response()->json('email not found',404);
            }else{
                return response()->json($token);
            }
        }
    }
    public function save(Request $request, RefreshToken $refreshToken){
        $email = $request->input('email');
        $token = $request->input('refresh_token');
        if(empty($email) || is_null($email)){
            return response()->json('email empty',404);
        }
        if(empty($token) || is_null($token)){
            return response()->json('token empty',404);
        }
        $refreshToken->email = $email;
        $refreshToken->token= $token;
        if($refreshToken->save()){
            return response()->json('saving token success1');
        }else{
            return response()->json('error saving token1',401);
        }
    }
    public function create(Request $request, RefreshToken $refreshToken){
        $email = $request->input('email');
        if(empty($email) || is_null($email)){
            return response()->json('email empty',401);
        }else{
            if(User::select("email")->where('email','=',$email)->limit(1)->exists()){
                $dataDb = User::select()->where('email','=',$email)->limit(1)->get();
                $data = json_decode(json_encode($dataDb));
                $token = JWTAuth::attempt(
                    $data,
                    [
                        'exp'=>Carbon::now()->addMinutes(2)->timestamp,
                        'secret'=>env('JWT_SECRET')
                    ]
                );
                $Rtoken = JWTAuth::attempt(
                    $data,
                    [
                        'exp'=>Carbon::now()->addDays(1)->timestamp,
                        'secret'=>env('JWT_SECRET')
                    ]
                );
                $refreshToken->email = $email;
                $refreshToken->token= $Rtoken;
                if($refreshToken->save()){
                    return response()->json(['message'=>'saving token success1','data'=>$token]);
                }else{
                    return response()->json('error saving token1',401);
                }
            }else{
                return response()->json('email not found',404);
            }
        }
    }
}
?> 