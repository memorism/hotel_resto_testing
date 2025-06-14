<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->usertype == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->usertype == 'restonew') {
            return redirect()->route('resto.dashboard');
        } elseif ($user->usertype == 'hotelnew') {
            return redirect()->route('hotel.dashboard');
        } elseif ($user->usertype == 'frontofficehotel') {
            return redirect()->route('hotel.frontoffice.booking.index');
        } elseif ($user->usertype == 'financehotel') {
            return redirect()->route('finance.index');
        } elseif ($user->usertype == 'scmhotel') {
            return redirect()->route('scm.supplies.index');
        } elseif ($user->usertype == 'cashierresto') {
            return redirect()->route('cashierresto.orders.index');
        } elseif ($user->usertype == 'financeresto') {
            return redirect()->route('financeresto.finances.index');
        } elseif ($user->usertype == 'scmresto') {
            return redirect()->route('scmresto.supplies.index');
        }

        return redirect()->route('dashboard'); // fallback jika usertype tidak dikenali
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
