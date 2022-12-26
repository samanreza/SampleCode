<?php

namespace App\Services;

use App\Contract\Repository\CustomUserModelInterface;
use App\Contract\Services\CustomUserServiceInterface;
use App\Models\User;
use \Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class CustomUserService implements CustomUserServiceInterface
{
    private CustomUserModelInterface $customUserModel;

    public function __construct(CustomUserModelInterface $customUserModel)
    {
        $this->customUserModel = $customUserModel;
    }

    public function checkUserAuthentication()
    {
        if (Gate::allows('admin'))
        {
            return $this->customUserModel->index();
        }
        else
        {
            throw new \Exception("Access Denied");
        }
    }

    public function usersLogin(array $data): \Illuminate\Http\JsonResponse
    {
        if (! $token = auth('api')->attempt($data))
        {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);

    }

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
