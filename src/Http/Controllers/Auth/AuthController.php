<?php

namespace Maksb\Admin\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Maksb\Admin\Dto\Auth\NewUserDto;
use Maksb\Admin\Http\Controllers\Controller;
use Maksb\Admin\Http\Requests\Auth\ForgotPasswordRequest;
use Maksb\Admin\Http\Requests\Auth\LoginRequest;
use Maksb\Admin\Http\Requests\Auth\RegisterRequest;
use Maksb\Admin\Http\Requests\Auth\UpdatePasswordRequest;
use Maksb\Admin\Http\Resources\UserResource;
use Maksb\Admin\Http\Responses\ApiResponse;
use Maksb\Admin\Models\AdminUser;
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
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if ($request->wantsJson()) {
                return ApiResponse::success(['redirect_url' => route('admin.dashboard')]);
            }

            return redirect()->route('admin.dashboard');
        }

        if ($request->wantsJson()) {
            throw new AuthenticationException('Invalid credentials');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    public function loginPage()
    {
        return view('maksb/admin::auth.login');
    }

    public function registerPage()
    {
        return view('maksb/admin::auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->usersService->createNewUser(NewUserDto::fromArray($request->validated()));

        Auth::guard('admin')->login($user);

        if ($request->wantsJson()) {
            return ApiResponse::success(['redirect_url' => route('admin.dashboard')]);
        }

        return redirect()->route('admin.dashboard');
    }

    public function check()
    {
        if (Auth::guard('admin')->check()) {
            return ApiResponse::success([
                'user' => UserResource::make(Auth::guard('admin')->user()),
            ]);
        }

        throw new AuthorizationException("User not authorized");
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return ApiResponse::success(['redirect_url' => route('admin.login')]);
        }

        return redirect()->route('admin.login');
    }

    public function refresh()
    {
        return ApiResponse::success([
            'token' => Auth::guard('admin')->refresh()
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
            function (AdminUser $user, string $password) {
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
