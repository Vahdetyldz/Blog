<?php
namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
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

        return response()->json([
            'success' => true,
            'message' => 'Başarıyla kayıt oldunuz!'
        ], 200);
    }


    public function login(UserLoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'redirect' => $user->role === 'admin' || $user->role === 'root' ? '/admin-dashboard' : '/',
                'message' => 'Giriş başarılı!'
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'email' => ['Email veya şifre hatalı.']
            ]
        ], 422);
    }


    public function logout()
    {
        Auth::logout();

        return redirect('/')->with('success', 'Başarıyla çıkış yapıldı!');
    }

    /**
     * Sistemdeki tüm kullanıcıları JSON olarak döndürür
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    /**
     * Kullanıcının aktiflik durumunu değiştirir (aktif/pasif)
     */
    public function toggleActive($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Kullanıcı bulunamadı.'], 404);
        }
        $user->is_active = !$user->is_active;
        $user->save();
        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
            'message' => 'Kullanıcı durumu güncellendi.'
        ]);
    }
    public function makeAdmin($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Kullanıcı bulunamadı.'], 404);
        }

        if ($user->role === 'admin') {
            $user->role = 'user'; // Eğer admin ise kullanıcı rolüne çevir
            $user->save();
        }else if ($user->role === 'user') {
            $user->role = 'admin'; // Eğer kullanıcı ise admin rolüne çevir
            $user->save();
        }
        return response()->json([
            'success' => true,
            'role' => $user->role,
            'message' => 'Kullanıcı rolü güncellendi.'
        ]);
    }

    /**
     * Dashboard için kullanıcı, blog, kategori ve yorum sayısı döndürür
     */
    public function dashboardStats()
    {
        return response()->json([
            'userCount' => User::count(),
            'blogCount' => Blog::count(),
            'categoryCount' => Category::count(),
            'commentCount' => Comment::count(),
        ]);
    }
}
