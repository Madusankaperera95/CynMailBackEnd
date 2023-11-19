<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function register(UserRegisterRequest $request)
    {

        $user = $this->userRepository->create($request->only(['name', 'email', 'password']));

        return response()->json(['status' => true,'token' => $user->createToken('API TOKEN')->plainTextToken,'user' => $user],200);

    }

    public function login(UserLoginRequest $request)
    {

        $user = $this->userRepository->findByEmail($request->email);

        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password do not match our records.'
            ], 401);
        }

        return response()->json(['status' => true,'token' => $user->createToken('API TOKEN')->plainTextToken,'user' => $user],200);

    }

    public function logout(Request $request)
    {
        $this->userRepository->getUser()->tokens()->delete();
        return response()->json(['status'=> true,'message' => 'user logged out'],200);
    }

    public function userInfo()
    {
        return response()->json(['status'=> true,'userInfo' => $this->userRepository->getUser()],200);
    }


}
