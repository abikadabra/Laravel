<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;
use Schema;

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
            'remember_token'    => Str::random(40),
        ]); 

        return ('data kamu sudah di tambah');
    }


    //menu login
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


        //memastikan data yang di input dari frontend benar
        $this->validate($req,[
            'email'     => 'required|email',
            'password'  => 'required|min:5',

        ]);

        $email  = $req->input('email');
        $pass   = $req->input('password');


        //cek ke database email dan password
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

        //generate token baru
        $generateToken = bin2hex(random_bytes(40));
        $user->update([
                'remember_token'=> $generateToken
        ]);

        return response()->json($user);
    }


    //untuk menampilkan menu edit dan melempar id ke update untuk di ubah datanya
    public function edit($id)
    {
        $user = DB::table('user')->where('id', $id)->get();

        return $user;
    }


    //untuk merubah data user
    public function update(Request $request)
    {

        DB::table('users')->where('id', $request->id)->update([
                'name'  => $request->name,
                'email' => $request->email,

        ]);

        return ('berhasil di ubah');



        // $data = $request->except('remember_token','id');

        // $validator = Validator::make($request->all(), [

        //     'name'      => 'required',
        //     'password'  => 'required|min:6',
        // ]);

        // if ($valid->fails()) {
        //     # code...
        //     return redirect()->Back()->withInput()->withErrors($validator);
        // }
        // $user = Users::find($id);

        // if ($user->update($data)) {
        //     # code...
        //     Seassion::flash('messsage', 'Update successfully!');
        //     Seassion::flash('alert-class', 'alert-success');
        //     return redirect()->route('users');

        // }else{
        //     Seassion::flash('message', 'Data not updated!');
        //     Seassion::flash('alert-class', 'alert-danger');
        // }
        // return Back()->withInput();



    }

    public function delete($id){

        $user = User::find($id);
        $user->delete();

        // Schema::table('flights', function (Blueprint $users){
        //     $users->softDeletes($id);
        // });

        return ('data ' .$id. ' berhasil di hapus');

    }



  

    public function logout()
    {

        
        return('logout success');
        
    }


}
