<?php

namespace Maksb\Admin\Http\Controllers\Auth;

use Maksb\Admin\Dto\Auth\NewUserDto;
use Maksb\Admin\Http\Controllers\Controller;
use Maksb\Admin\Http\Requests\Auth\ForgotPasswordRequest;
use Maksb\Admin\Http\Requests\Auth\LoginRequest;
use Maksb\Admin\Http\Requests\Auth\RegisterRequest;
use Maksb\Admin\Http\Requests\Auth\UpdatePasswordRequest;
use Maksb\Admin\Http\Resources\UserResource;
use Maksb\Admin\Http\Responses\ApiResponse;
use Maksb\Admin\Models\User;
use Maksb\Admin\Services\User\UsersService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct(private readonly UsersService $usersService)
    { }

    public function login(LoginRequest $request)
    {
        if (auth()->attempt($request->validated())) {
            $user = auth()->user();

            return ApiResponse::success([
                'user' => UserResource::make($user),
            ]);
        }

        throw new AuthenticationException('Invalid credentials');
    }

    public function loginPage()
    {
        return view('auth.login');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->usersService->createNewUser(NewUserDto::fromArray($request->validated()));

        auth()->login($user);

        return ApiResponse::success([
            'user' => UserResource::make($user),
        ]);
    }

    public function check()
    {
        if (auth()->check()) {
            return ApiResponse::success([
                'user' => UserResource::make(auth()->user()),
            ]);
        }

        throw new AuthorizationException("User not authorized");
    }

    public function logout()
    {
        auth()->logout();

        return ApiResponse::success([
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return ApiResponse::success([
            'token' => auth()->refresh()
        ]);
    }

    public function verifyEmail(int $id, string $hash, EmailVerificationRequest $request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();
        }

        return ApiResponse::success();
    }

    public function sendVerifyNotification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return ApiResponse::success();
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $data = $request->validated();

        $status = Password::sendResetLink($data);

        return $status === Password::ResetLinkSent ? ApiResponse::success() : ApiResponse::fail($status);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $data = $request->validated();

        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PasswordReset
            ? ApiResponse::success()
            : ApiResponse::fail($status);
    }
}
