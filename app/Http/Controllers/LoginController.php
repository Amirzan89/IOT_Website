<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Exception;
class LoginController extends Controller
{
    public function Login(Request $request,Response $response){
        // return redirect('/dashboard');
        $email = $request->input("email");
        $email = "Admin@gmail.com";
        $pass = $request->input("pass");
        $pass = "Admin@123456789";
        if(empty($email)){
            return response()->header('error','Email Tidak boleh kosong');
        }else if(empty($pass)){
            return redirect('/login')->header('error','Password Tidak boleh kosong');
        }else{
            $inEmail = ""; $rPass = "";
            $inId = User::select('username')->where('email','=',$email)->limit(1)->get();
            $inEmail = User::select('email')->where('email','=',$email)->limit(1)->get();
            $inPass = User::select('password')->where('email','=',$email)->limit(1)->get();
            $id = json_decode(json_encode($inId));
            $Iemail = json_decode(json_encode($inEmail));
            $Ipass = json_decode(json_encode($inPass));
            if(!$email == $Iemail){
                echo $inEmail."<br>";
                echo "email salah";
                return redirect("/login")->header('error','Email salah');
            }else if(!password_verify($pass,$Ipass[0]->password)){
                // echo "pass ".Hash::make($pass)."<br>";
                echo "".password_hash($pass,PASSWORD_BCRYPT)."<br>";
                echo $pass. "<br>";
                echo "pass salah";
                // return redirect("/login")->withInput()->with(['_method' => 'GET'])->header('error','password salah');
                return redirect("/login")->header('error','password salah');
            }else{
                echo "email dan password benar<br>";
                $waktu = time() + (60 * 60 * 24 * 1);
                echo "waktu $waktu<br>";
                return redirect("/dashboard")->withCookies([cookie('id',$id[0]->username,$waktu),cookie('key',hash("sha512",$email),$waktu)]);
            }
        }
    }
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback(User $user){
        try{
            echo "login dengan gooogle<br>";
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->exists();
            if(User::where('google_id', $user->id)->exists()){
                echo "find user is $finduser <br>";
                echo "login dengan google 213213<br>";
                echo $user->getId();
                $email = $user->getEmail();
                $waktu = time() + (60 * 60 * 24 * 1);
                $inId = User::select('username')->where('email','=',$email)->limit(1)->get();
                $id = json_decode(json_encode($inId));
                return redirect()->intended("/dashboard");
            }else{
                $user = Socialite::driver('google')->user();
                echo "id tidak ada <br>";
                echo $user->getId();
                // return redirect()->intended('dashboard');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    // public function logout(Request $request, Response $response){
    //     //
    // }
}
?>