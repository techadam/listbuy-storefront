<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /**
     * Send a reset code to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function sendResetCodeEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if ($validator->fails()) {
            return $this->badRequest("Please enter a valid email address.");
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $reset_pin = mt_rand(1000, 9999);
            $user->password_reset_code = $reset_pin;
            $user->save();

            Mail::to($request->input('email'))
                ->send(new PasswordResetMail($user));

            return $this->success(null, "Password reset code sent to your mail!");
        }

        return $this->notFound("No user is associated with this email.");

    }

    /**
     * Verify user password reset code
     */
    public function verifyResetCode($code)
    {
        $user = User::where('password_reset_code', $code)->first();

        if ($user) {
            return $this->success(['reset_code' => $code]);
        }

        return $this->badRequest("Invalid or incorrect reset code entered.");
    }

    /**
     *  Reset user password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'reset_code' => 'required|numeric',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->badRequest("Validation error", $validator->messages()->toArray());
        }

        $user = User::where(['email' => $request->email, 'password_reset_code' => $request->reset_code])->first();

        if ($user) {
            $user->password_reset_code = null;
            $user->password = Hash::make($request->input("password"));
            $user->save();
            return $this->success(null, "Password reset successful. Login to continue.");
        }
        return $this->notFound("User not found.");

    }
}
