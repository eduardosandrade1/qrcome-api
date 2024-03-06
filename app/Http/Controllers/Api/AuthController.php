<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegister;
use App\Models\User;
use App\Services\EmailService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Nette\Utils\Random;

class AuthController extends Controller
{
    public function login( Request $request )
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->whereNotNull('email_verified_at')->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $response = [
            'token' => $user->createToken($request->email)->plainTextToken,
            'user' => $user,
        ];
        return $response;
    }

    public function register(UserRegister $request)
    {
        $request->validated();
        try {
            $user = new User();
            $user->name = $request->userName;
            $user->email = $request->userEmail;
            $user->segment = $request->userSegment;
            $user->code_verify = Random::generate(6, '0-9');

            $user->save();

            EmailService::send($user);

            return response()->json([
                'id' => Crypt::encrypt($user->email)
            ]);

        } catch (Exception $e) {
            Log::error($e);
            abort(403, "Error creating user");
        }
    }

    public function confirmCode(string $userEmail, Request $request)
    {
        try {
            $email = Crypt::decrypt($userEmail);
            $user = User::whereEmail($email)->first();

            if ( $user ) {

                if( $user->code_verify == $request->code ) {
                    User::whereEmail($email)->update(['email_verified_at' => date(now()), 'code_verify' => null]);
                    return response()->json([
                        'status' => 'confirmed',
                    ]);
                } else {
                    return response()->json([
                        'status' => 'invalid_code',
                    ]);
                }

            }

        } catch (Exception $e) {
            Log::error($e);
            abort(403, "Error confirm code user");
        }
    }

    public function setPassword(string $userEmail, Request $request)
    {

        try {

            $email = Crypt::decrypt($userEmail);
            $user = User::whereEmail($email)->update([
                'password' => bcrypt($request->password)
            ]);

            if ( $user ) {
                return response()->json([
                    'status' => 'password_updated',
                ]);
            }

            return response()->json([
                'status' => 'password_error',
            ]);

        } catch (Exception $e) {
            Log::error($e);
            abort(403, "Error set password");
        }

    }
}
