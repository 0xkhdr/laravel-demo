<?php

namespace App\Actions\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterUser
{
    /**
     * Register a new user and assign the author role.
     *
     * @param RegisterRequest $request
     * @return User
     * @throws ValidationException
     */
    public function __invoke(RegisterRequest $request): User
    {
        // Check if email already exists
        if (User::where('email', $request->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => 'The email address is already registered.',
            ]);
        }

        // Create user with hashed password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign author role to the new user
        $user->assignRole('author');

        // Return user instance with roles eager-loaded
        return $user->load('roles');
    }
}
