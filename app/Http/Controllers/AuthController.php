<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ], [
            'name.required' => 'İsim alanı boş bırakılamaz.',
            'surname.required' => 'Soyad alanı boş bırakılamaz.',
            'email.required' => 'Lütfen bir email adresi girin.',
            'email.email' => 'Geçerli bir email adresi girin.',
            'email.unique' => 'Bu email adresi zaten kullanılıyor.',
            'password.required' => 'Şifre alanı boş bırakılamaz.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifre ve şifre tekrarınız uyuşmuyor.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Kullanıcıyı giriş yapmış olarak ayarla
        Auth::login($user);

        return redirect('/')->with('success', 'Başarıyla kayıt oldunuz!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Kullanıcıyı giriş yapmaya çalış
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
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
