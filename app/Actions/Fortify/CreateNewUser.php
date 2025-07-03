<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'phone'    => ['required', 'string', 'regex:/^\+998\d{9}$/', 'unique:users,phone'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => 'User',
            'phone' => $input['phone'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
