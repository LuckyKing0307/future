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
            'name'    => ['required', 'string'],
            'referral'    => ['nullable', 'string'],
            'surname'    => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'phone' => $input['phone'],
            'name' => $input['name'],
            'surname' => $input['surname'],
            'is_referal' => $input['referral'] ? $input['referral'] : null,
            'password' => Hash::make($input['password']),
        ]);
    }
}
