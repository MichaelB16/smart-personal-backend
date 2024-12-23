<?php

namespace App\Http\Controllers;

use App\Mail\SendForgotPassword;
use App\Services\ForgotPasswordService;
use App\Services\NewPasswordService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function __construct(protected ForgotPasswordService $forgotPasswordService, protected NewPasswordService $newPasswordService) {}

    public function forgotPassword(Request $request)
    {
        $data = $request->validate(['email' => 'required|email']);

        $user = $this->forgotPasswordService->checkEmailIsValid($data['email']);

        if ($user) {
            if ((int) $user->is_google === 1) {
                return response()->json(['message' => 'account is google', 'error' => 'google_account'], 422);
            } else if ($user->id) {
                $new_password = $this->newPasswordService->create(['user_id' => $user->id]);
                $this->sendEmailForgot($user, $new_password->token);
                return response()->json(['message' => 'sent successfully']);
            }
        }

        return response()->json(['message' => 'e-mail invalid!', 'error' => 'mail_invalid'], 422);
    }

    protected function sendEmailForgot($user, $token)
    {
        try {
            Mail::to($user->email)->send(new SendForgotPassword([
                'url' => env('APP_URL_FRONT') . '/new/password/' . $token,
                'username' => $user->name,
            ]));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
