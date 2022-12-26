<?php

namespace App\Repositories;
use App\Models\User;
use App\Contract\Repository\CustomUserModelInterface;

class CustomUserRepository implements CustomUserModelInterface
{
    /**
     * @param User $user
     * @param array $data
     */
    public function createNewUser(User $user,array $data)
    {
        $user->setUsername($data[User::COLUMN_USERNAME])
            ->setPassword($data[User::COLUMN_PASSWORD])
            ->setRole($data[User::COLUMN_ROLE])
            ->save();
    }

    public function index(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::query()->select([
            User::COLUMN_USERNAME,
            User::COLUMN_ROLE
        ])->paginate();
    }


}
