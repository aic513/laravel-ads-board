<?php
declare(strict_types=1);

namespace App\UseCases\Profile;

use App\Http\Requests\Cabinet\ProfileEditRequest;
use App\Models\User;

class ProfileService
{
    public function edit($id, ProfileEditRequest $request): void
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $oldPhone = $user->phone;
        $user->update($request->only('name', 'last_name', 'phone'));
        if ($user->phone !== $oldPhone) {
            $user->unverifyPhone();
        }
    }
}
