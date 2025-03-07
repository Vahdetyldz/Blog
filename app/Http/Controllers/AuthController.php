<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
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

        User::create([
            'name' => $request->name,//
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Email'i kontrol et
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'Bu email adresi kayıtlı değil.'])->withInput();
        }
    
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Şifreniz hatalı.'])->withInput();
        }
        session(['user' => $user->id]);
    
        return redirect('/');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/')->with('success', 'Başarıyla çıkış yapıldı!');;
    }
}