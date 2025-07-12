<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; 
use Illuminate\Support\Facades\Auth;  
use App\Models\User;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        $data = array();
        return view('auth.register', compact('data'));
    }

    public function logincheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]); 
        $credentials = $request->only('email', 'password'); 
        if (Auth::attempt($credentials)) { 
            if (auth()->user()->deleted_at == 0) {
                return redirect()->route('home')->withSuccess('ยินดีต้อนรับเข้าสู่ระบบ.');
            }
        }
        return redirect()->route('login')->with('error', 'รายละเอียดการล็อกอินไม่ถูกต้อง โปรดลองใหม่อีกครั้ง !');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function registration(Request $request)
    {
        $request->validate([
            'usersname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => 'required'
        ]);

        $data = new User;
        $data->name  = $request->usersname;
        $data->email = $request->email;
        $data->tel   = $request->tel;
        $data->password = Hash::make($request->password);
        $data->deleted_at = 0;
        $data->ip_address = $request->ip();
        $data->created_at = new \DateTime();
        $data->save();
        return redirect()->route('register')->with('success', 'ลงทะเบียนสมาชิกสำเร็จเรียบร้อยแล้ว');
    }
}
