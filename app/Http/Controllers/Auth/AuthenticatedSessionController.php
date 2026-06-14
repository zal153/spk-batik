<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->authenticate();
        } catch (ValidationException $e) {
            $attempts = session('login_attempts', 0) + 1;
            session(['login_attempts' => $attempts]);

            if ($attempts >= 6) {
                return redirect()->route('password.request')->with('status', 'Anda telah salah memasukkan password sebanyak ' . $attempts . ' kali. Silakan setel ulang kata sandi Anda.');
            }

            throw $e;
        }

        // Authentication succeeded: clear failed attempts
        session()->forget(['login_attempts']);

        $request->session()->regenerate();

        $redirectRoute = $request->user()->role === 'admin'
            ? route('admin.dashboard', absolute: false)
            : route('dashboard', absolute: false);

        return redirect()->intended($redirectRoute);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
