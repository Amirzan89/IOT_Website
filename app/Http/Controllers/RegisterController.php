<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function Register(Request $request, User $user){
        $username = $request->input("username");
        echo "usernammeeee $username <br>";
        // echo isempty($username)."br>";
        // echo isset($username)."br>";
        $email = $request->input("email");
        $nama = $request->input("nama");
        // $email = "Admin@gmail.com";
        $pass = $request->input("pass");
        $pass1 = $request->input("pass_new");
        if(empty($username)){
            // echo "username tidak boleh kosong <br>";
            return response()->header('error','Username Tidak boleh kosong');
        }else if(empty($email)){
            // echo "email tidak boleh kosong <br>";
            return response()->header('error','Email Tidak boleh kosong');
        }else if(empty($nama)){
            // echo "nama tidak boleh kosong <br>";
            return response()->header('error','Nama Lengkap Tidak boleh kosong');
        }else if(empty($pass)){
            echo "password tidak boleh kosong <br>";
            return response()->header('error','Password Tidak boleh kosong');
        }else if(empty($pass1)){
            echo "password tidak boleh kosong <br>";
            return response()->header('error','Ulangi Password Tidak boleh kosong');
        }else if (User::select("username")->where('username','LIKE','%'.$username.'%')->limit(1)->exists()){
            // if(DB::table("users")->select("username")->where('email','=',$username)->limit(1)->exists()){
            // echo "username sudah digunakan <br>";
            return response()->header('error','Username sudah digunakan');
        }else{
            if($pass === $pass1){
                // DB::table("users")->select("username")->where('email','=',$email)->limit(1)->get();
                $user->username = $username;
                $user->email = $email;
                $user->nama_users = $nama;
                $user->password = Hash::make($pass);
                if($user->save()){
                    echo "akun berhasil dibuat <br>";
                    return redirect('/login')->header('Success','Akun Berhasil Dibuat Silahkan Login');
                }else{
                    echo "akun gagal dibuat <br>";
                    return response('/register')->header('error','Akun Gagal Dibuat');
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