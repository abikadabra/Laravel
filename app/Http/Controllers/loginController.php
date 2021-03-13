<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::All();
        return ($user);
    }

    public function register(Request $request)
    {        

        // Validate the value...
         $request->validate([
            'name'      =>  'required',
            'email'     =>  'required|unique:users',
            'password'  =>  'required|min:6',
            'borndate'  =>  'required',
            'gender'    =>  'required',
         ]);


       
        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'borndate'          => $request->borndate,
            'gender'            => $request->gender,
            'remember_token'    => Str::random(80),
        ]); 

        return ('data kamu sudah di tambah');
    }


    public function login(Request $req)
    {

            // $email  = $req->email;
            // $pass   = $req->password;
              

            // //dd(Auth::attempt(['email' => $email, 'password' => $pass]));

            // if (Auth::attempt(['email'=>$email, 'password'=>$pass]))
            // {
            //     return "Hai ". Auth::user()->name;
            // }else{
            //     return "Maaf Email atau Password salah.";
            // }
        


        $this->validate($req,[
            'email'     => 'required|email',
            'password'  => 'required|min:5'
        ]);

        $email  = $req->input('email');
        $pass   = $req->input('password');


        $user = User::where('email', $email)->first();
        if (!$user) {
            # code...
            return response()->json(['message'=>'email yang anda masukan salah']);
        }

        $isValidPassword = Hash::check($pass, $user->password);
        if (!$isValidPassword) {
            # code...
            return response()->json(['message' => 'password yang anda masukan salah']);
        }

        $generateToken = bin2hex(random_bytes(80));
        $user->update([
                'remember_token'=> $generateToken
        ]);

        return response()->json($user);
    }

  

    public function logout()
    {

        
        return('logout success');
        
    }


}
