<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'user';

        return User::create($data);
    }

    public function updateUser(User $user, array $data)
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);

            if (isset($data['photo'])) {

                if ($user->photo) {
                    Storage::disk('public')->delete($user->photo);
                }

                $path = $data['photo']->store('avatars', 'public');
                $user->photo = $path;
                unset($data['photo']);
            }

            $user->update($data);

            return $user;
        }
    }
}
