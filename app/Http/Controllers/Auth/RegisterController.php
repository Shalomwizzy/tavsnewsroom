<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('showRegistrationForm', 'register.form');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['nullable', 'in:admin,writer,guest'],
        ]);
    }

    protected function create(array $data)
    {
        // Check if this is the first user
        $isFirstUser = User::count() === 0;

        // Assign the role, default to admin if first user
        $role = $isFirstUser ? 'admin' : $data['role'];

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);
    }


    protected function registered(Request $request, $user)
{
    if (User::count() === 1) {
        return redirect()->route('admin.env.show');
    }
    
    return redirect($this->redirectPath());
}



}