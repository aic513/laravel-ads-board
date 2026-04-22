<?php
declare(strict_types=1);

namespace App\Http\Serializers;

use App\Models\User;

class UserSerializer
{
    public function profile(User $user): array
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'phone' => [
                'number' => $user->phone,
                'verified' => $user->phone_verified,
            ],
            'name' => [
                'first' => $user->name,
                'last' => $user->last_name,
            ],
        ];
    }
}
