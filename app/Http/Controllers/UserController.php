<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{


    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email'    => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => ['required', 'in:writer,admin'],
        ]);

        User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.dashboard')->with('user_created', 'User created successfully.');
    }

    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username'    => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'role'        => ['required', 'in:writer,admin'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string'],
        ]);

        $permissions = null;
        if ($request->role === 'writer') {
            $validSections = array_keys(config('writer_permissions.sections'));
            $permissions   = array_values(array_intersect(
                $request->input('permissions', []),
                $validSections
            ));
        }

        $user->update([
            'username'    => $request->username,
            'email'       => $request->email,
            'role'        => $request->role,
            'permissions' => $permissions,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function updateAccount(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id); 
    
        $request->validate([
            'profile_picture' => 'image|mimes:jpg,jpeg,png,gif|max:5028',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'bio' => 'nullable|string|max:500',
        ]);

        $data = $request->only('username', 'email', 'bio');
    
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }
    
        // Update the user's details
        $user->update($data);
        
        // Handle profile picture upload if provided
        if ($request->hasFile('profile_picture')) {
            $uploadedFile = $request->file('profile_picture');
            $fileName = 'profile_picture_' . time() . '.' . $uploadedFile->extension();
            $location = public_path('profile_pictures');
            $uploadedFile->move($location, $fileName);
            
            $user->profile_picture = 'profile_pictures/' . $fileName;
            $user->save();
        }
        return redirect()->route('users.show', Auth::user()->id) ->with('success', 'Account details updated successfully!');
    
    }
    
    }