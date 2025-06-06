<?php

namespace App\Services\Mails;

use App\Contracts\SendEmailInterface;
// use App\Jobs\SendNewPasswordEmail;
use App\Services\NewPasswordService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendEmailNewPasswordService implements SendEmailInterface
{
    public function send(array $data)
    {
        try {
            $new_password = app(NewPasswordService::class)->create([
                'user_id' => $data['user_id']
            ]);

            $data['event'] = 'new_password';
            $data['subject'] = 'Nova senha';
            $data['url'] = env('APP_URL_FRONT') . '/new/password/' . $new_password->token;

            Http::post(env('WEBHOOK_PIPEDREAM_URL'), [
                ...$data,
                'html' => view('mail.new_password', $data)->render()
            ]);
        } catch (Exception $e) {
            Log::error('ERROR SEND NEW PASSWORD EMAIL: ' . $e->getMessage());
        }

        // SendNewPasswordEmail::dispatch([
        //     'user_id' => $data['user_id'],
        //     'email' => $data['email'],
        //     'username' => $data['username'],
        // ]);
    }
}
