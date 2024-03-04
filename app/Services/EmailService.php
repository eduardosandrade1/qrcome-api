<?php

namespace App\Services;

use App\Mail\NewUserCodeVerify;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


class EmailService {

    public static function send(User $user)
    {

        Mail::to($user->email)->send(new NewUserCodeVerify($user));

        return true;
    }

}
