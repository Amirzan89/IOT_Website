<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Exception;
Use Closure;
use Mail;
use Carbon\Carbon;
class ResetPassController extends Controller
{
    public function test(Request $request, Response $response){
        $email = Str::random(5).'@gmail.com';
        DB::table('password_reset')->insert([
            'email'=>$email,
            'token'=>Str::random(64),
            'validated_at'=>Carbon::now(),
            'created_at'=>Carbon::now()
        ]);
        return response()->json('successs '.$email);
    }
    public function testing(Request $request, Response $response){
        try{
        $email = $request->input('email');
        if(PasswordReset::where('email',$email)->exists()){
            $increate = User::select('created_at')->where('email','=',$email)->limit(1)->get();
            $Icreate = json_decode($increate);
            return response()->json('email ditemukan dengan waktu '. $Icreate);
            // $data = json_decode(json_encode(PasswordReset::select('created_at')->where('email',$email)->limit(1)->get()));
            // $create = Carbon::parse($data[0]['created_at']);
            $create = Carbon::parse($Icreate);
            $current = Carbon::now();
            // $compare = $current->diffInSeconds($create);
            $compare = $create->diffInSeconds($current);
            if($compare >= 10){
                return response()->json('10'."dengan waktu "." waktu ". " data ");
            }else{
                return response()->json('kurang '."dengan waktu "." waktu" ." data ");
            }
        }else{
            return response()->json('error email tidak ditemukan',404);
        }
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function sendReset(Request $request,Response $response){
        // echo "reset password";
        // return redirect('/dashboard');
        try{
            $email = $request->input("email");
            // $email = "Admin@gmail.com";
            if(empty($email)){
                return response()->header('error','Email empty');
            }else{
                $inEmail = "";
                $inEmail = User::select('email')->where('email','=',$email)->limit(1)->get();
                $Iemail = json_decode(json_encode($inEmail));
                if(!$email == $Iemail){
                    echo $inEmail."<br>";
                    echo "email salah";
                    return redirect("/password/reset")->header('error','Wrong email');
                }else{
                    if(PasswordReset::where('email','=',$email)->exist()){
                        $create = PasswordReset::select('created_at')->where('email','=',$email)->limit(1)->get();
                            if(empty($create) || is_null($create)){
                                return response()->json(['data'=>'invalid error']);
                            }else{
                                $timee = Carbon::create($create);
                                $currentTime = Carbon::now();
                            }
                            
                    }else{
                        // echo "email benar<br>";
                        $token = Str::random(64);
                        DB::table('password_resets')->insert([
                            'email' => $request->email, 
                            'token' => $token, 
                            'validated_at' => Carbon::now(),
                            'created_at' => Carbon::now()
                        ]);
                        $data = [
                            'token'=>$token
                        ];
                        Mail::to($request->email)->send(new ForgotPassword($data));
                        return response()->json(['check your mail box']);
                    // Mail::to($request->email)->send('email.forgetPassword', ['token' => $token], function($message) use($request){
                        // $message->to($request->email);
                        // $message->subject('Reset Password');
                        // });
                    }
                }
            }
        }catch(Exception $ex){
            return response()->json('Error when sending email');
        }
        // return back()->with('message', 'We have e-mailed your password reset link!');
    }
    public function handleReset(Request $request,Response $response, Closure $next){
        // return redirect('/dashboard');
        $email = $request->input("email");
        $token = $request->input("token");
        // $email = "Admin@gmail.com";
        if(empty($email)){
            return redirect('/forgot')->header('error','Email empty');
        }else if(empty($token)){
            return redirect('/forgot')->header('error','Token empty');
        }else{
            $inEmail = ""; $inToken = "";
            $inEmail = User::select('email')->where('email','=',$email)->limit(1)->get();
            $inToken = PasswordReset::select('token')->where('email','=',$email)->limit(1)->get();
            $Iemail = json_decode(json_encode($inEmail));
            $Itoken = json_decode(json_encode($inToken));
            if(!$email == $Iemail){
                echo $inEmail."<br>";
                echo "email salah";
                return redirect("/forgot")->header('error','Wrong Email');
            }else if(!$token == $Itoken){
                return redirect("/forgot")->header('error','Wrong Token');
            }else{
                echo "email dan token benar<br>";
                $next();
            }
        }
    }
    public function handleResetView(Request $request, Response $response){
        $path = $request->path();
        // $tokenPath = ''
    }
    public function changePass(Request $request, Response $response, User $user){
        $email = $request->input("email");
        // $email = "Admin@gmail.com";
        $pass = $request->input("pass");
        $pass1 = $request->input("pass_new");
        if(empty($email)){
            // echo "email tidak boleh kosong <br>";
            return response('/forgot')->header('error','Email Tidak boleh kosong');
        }else if(empty($pass)){
            echo "password tidak boleh kosong <br>";
            return response('/forgot')->header('error','Password Tidak boleh kosong');
        }else if(empty($pass1)){
            echo "password tidak boleh kosong <br>";
            return response('/forgot')->header('error','Ulangi Password Tidak boleh kosong');
        }else{
            if($pass === $pass1){
                // DB::table("users")->select("username")->where('email','=',$email)->limit(1)->get();
                $user->email = $email;
                $user->password = Hash::make($pass);
                if($user->save()){
                    echo "akun berhasi diganti <br>";
                    return redirect('/login')->header('Success','Password Berhasil diubah Silahkan Login');
                }else{
                    echo "akun gagal dibuat <br>";
                    return redirect('/forgot')->header('error','Password Gagal Diubah');
                }
            }else{
                echo "Password harus sama <br>";
                return response()->header('error','Password Harus Sama');
            }
        }
        // return view('welcome');
    }
}
?>