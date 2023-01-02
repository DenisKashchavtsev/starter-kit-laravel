<?php

namespace App\Services\V1\Admin\Token;

use App\Exceptions\ValidationException;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Hash;

final class CreateTokenService
{
    /**
     * @throws ValidationException
     */
    public function create(string $email, string $password, string $deviceName)
    {
        $user = AdminUser::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return false;
        }

        return $user->createToken($deviceName)->plainTextToken;
    }
}