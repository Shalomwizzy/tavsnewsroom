<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorLoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.author-login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role !== 'writer') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('author.login')
                ->withErrors(['email' => 'These credentials are not authorized for author access.']);
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
