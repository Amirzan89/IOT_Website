<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use app\Models\RefreshToken;
use Illuminate\Support\Facades\DB;
Use Closure;
class JwtController extends Controller
{
    public function get(Request $request,Response $response){
        $email = $request->input('email');
    }
    public function save(Request $request, Response $response, RefreshToken $refreshToken){
        $email = $request->input('email');
        $token = $request->input('refresh_token');
        
    }
}
?> 