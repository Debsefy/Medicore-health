<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return $this->redirectToDashboard();
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => 'Invalid credentials.']);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages(['email' => 'Your account has been deactivated.']);
        }

        Auth::login($user, $request->boolean('remember'));
        $user->update(['last_login_at' => now()]);
        AuditLog::record('User Login');
        $request->session()->regenerate();

        return $this->redirectToDashboard();
    }

    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:admin,doctor,nurse,receptionist',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        Auth::login($user);
        AuditLog::record('User Registration', $user);
        return $this->redirectToDashboard();
    }

    public function logout(Request $request)
    {
        AuditLog::record('User Logout');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    private function redirectToDashboard()
    {
        return redirect()->route('dashboard');
    }
}
