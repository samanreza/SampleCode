<?php

namespace App\Http\Controllers;

use App\Contract\Services\CustomUserServiceInterface;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public CustomUserServiceInterface $customUserService;

    public function __construct(CustomUserServiceInterface $customUserService)
    {
        $this->customUserService = $customUserService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $this->customUserService->checkUserAuthentication()
        ]);
    }

    public function login(Request $userRequest): \Illuminate\Http\JsonResponse
    {
        $data = $this->_sanitize($userRequest);

        return \response()->json([
            'loginInfo' => $this->customUserService->usersLogin($data)
        ]);
    }

    /**
     * @param UserRequest $userRequest
     * @return array
     */
    private function _sanitize(Request $userRequest): array
    {
        return [
            User::COLUMN_USERNAME => $userRequest->{User::COLUMN_USERNAME},
            User::COLUMN_PASSWORD => $userRequest->{User::COLUMN_PASSWORD},
        ];
    }
}
