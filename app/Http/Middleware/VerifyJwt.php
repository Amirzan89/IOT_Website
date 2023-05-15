<?php
namespace App\Http\Middleware;

use app\Model\RefreshToken;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Closure;
use JWTAuth;
class VerifyJwt {
    protected $response;
    public function __construct(Response $response){
        $this->response = $response;
    }
    public function handle(Request $request, Closure $next){
        try{
            $email = $request->input('email');
            $tokenReq = $request->input('token');
            if(empty($email) || is_null($email)){
                return response()->json('email empty',401);
            }
            if(empty($tokenReq) || is_null($tokenReq)){
                return response()->json('token empty',401);
            }
            JWTAuth::setToken($tokenReq);
            $data = JWTAuth::getPayload()->toArray([],env('JWT_SECRET'));
            $next($data);
        }catch(JWTException $ex){
            return response()->json(['error'=>'Failed token', 'message'=>$ex->getMessage()],401);
        }
    }
}
