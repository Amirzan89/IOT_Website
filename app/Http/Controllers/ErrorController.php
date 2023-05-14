<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
Use Closure;
class ErrorController extends Controller
{
    public function handling(Request $request,Response $response){
        $data = [
            
        ];
        return response()->json(['data'=>"Carbon::create(PasswordReset::select('created_at')->where('email',email)->limit(1)->get())"]);
    }
}
?> 