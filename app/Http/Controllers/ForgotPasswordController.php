<?php

namespace App\Http\Controllers;

use App\Services\ForgotPasswordService;
use App\Services\Mails\SendEmailForgotPasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function __construct(
        protected ForgotPasswordService $forgotPasswordService,
        protected SendEmailForgotPasswordService $sendEmailForgotPasswordService,
    ) {}


    public function forgotPassword(Request $request): JsonResponse
    {
        $data = $request->validate(['email' => 'required|email']);

        $user = $this->forgotPasswordService->checkEmailIsValid($data['email']);

        if (!$user) {
            return response()->json([
                'message' => 'E-mail inválido!',
                'error' => 'mail_invalid'
            ], 422);
        }

        if ((int) $user->is_google === 1) {
            return response()->json([
                'message' => 'Conta vinculada ao Google',
                'error' => 'google_account'
            ], 422);
        }

        $this->sendEmailForgotPasswordService->send([
            'email' => $user->email,
            'user_id' => $user->id,
            'username' => $user->name,
        ]);

        return response()->json([
            'message' => 'E-mail de recuperação enviado com sucesso'
        ]);
    }
}
