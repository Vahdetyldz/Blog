<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Başarıyla kayıt oldunuz!');
    }

    public function login(UserLoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect('/admin')->with('success', 'Admin olarak giriş yapıldı!');
            }

            return redirect('/')->with('success', 'Giriş başarılı!');
        }

        return redirect()->back()->withErrors(['email' => 'Email veya şifre hatalı.'])->withInput();
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/')->with('success', 'Başarıyla çıkış yapıldı!');
    }
}
