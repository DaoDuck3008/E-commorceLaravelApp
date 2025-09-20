<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;


class AuthController extends Controller
{
    //
    public function registerView () {
        return view('auth.register');
    }

    public function create(Request $request){
        //validate
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|min:10|max:11',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'FullName' => $request->name,
            'Email' => $request->email,
            'PhoneNumber' => $request->phone,
            'PasswordHash' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công!');

    }

    public function loginView() {
        return view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);


        try{
            $credentials = $request->only('email','password');
            $remember = $request->has('remember');

            if (Auth::attempt(['Email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
                $request->session()->regenerate();
                
                return redirect()->route('home')->with('success', 'Đăng nhâp thành công!');
            } else {
                return back()->with('error', 'Email hoặc mật khẩu không đúng');
            }
    
        }catch(\Exception $e){
            return back()->with('error' , 'Lỗi'. $e->getMessage());
        }
    
    }

    public function logout (Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }


}
