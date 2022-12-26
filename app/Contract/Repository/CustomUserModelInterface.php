<?php

namespace App\Contract\Repository;

use App\Models\User;

interface CustomUserModelInterface
{
    public function index();

    public function createNewUser(User $user,array $data);
}
