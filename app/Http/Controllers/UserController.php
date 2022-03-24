<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepository $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->user->register($request);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->user->login($request);
    }

    public function getUser(): \Illuminate\Http\JsonResponse
    {
        return $this->user->getUser();
    }
}
