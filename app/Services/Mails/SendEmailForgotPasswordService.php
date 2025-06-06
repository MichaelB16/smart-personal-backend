<?php

namespace App\Services\Mails;

use App\Contracts\SendEmailInterface;
// use App\Jobs\SendForgotPasswordEmail;
use App\Services\NewPasswordService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendEmailForgotPasswordService implements SendEmailInterface
{
    public function send(array $data)
    {
        try {
            $new_password = app(NewPasswordService::class)->create([
                'user_id' => $data['user_id']
            ]);

            $data['subject'] = 'Esqueceu sua senha?';
            $data['event'] = 'forgot_password';
            $data['url'] = env('APP_URL_FRONT') . '/new/password/' . $new_password->token;

            Http::post(env('WEBHOOK_PIPEDREAM_URL'), [
                ...$data,
                'html' => view('mail.forgot', $data)->render()
            ]);
        } catch (Exception $e) {
            Log::error('ERROR SEND EMAIL FORGOT PASSWORD: ' . $e->getMessage());
        }

        // SendForgotPasswordEmail::dispatch([
        //     'email' => $data['email'],
        //     'user_id' => $data['user_id'],
        //     'username' => $data['username']
        // ]);
    }
}
