<?php
namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use App\Models\User;
Use Illuminate\Routing\UrlGenerator;
use Illuminate\Console\Command;
class VerifyJwt
{
    protected $response;
    public function __construct(Response $response){
        $this->response = $response;
    }
    public function handle(Request $request, Closure $next){
    }
}
