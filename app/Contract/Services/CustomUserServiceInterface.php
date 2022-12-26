<?php

namespace App\Contract\Services;

use App\Models\User;

interface CustomUserServiceInterface
{
    public function usersLogin(array $data):\Illuminate\Http\JsonResponse;

    public function checkUserAuthentication();
}
