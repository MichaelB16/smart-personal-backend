<?php


namespace App\Services\Mails;

use App\Contracts\SendEmailInterface;
// use App\Jobs\SendWelcomeEmail;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendEmailWelcomeService implements SendEmailInterface
{
    public function send(array $data)
    {

        try {
            $data['event'] = 'welcome';
            $data['subject'] = 'Bem-vindo!';

            Http::post(env('WEBHOOK_PIPEDREAM_URL'), [
                ...$data,
                'html' => view('mail.welcome', $data)->render()
            ]);
        } catch (Exception $e) {
            Log::error('ERROR SEND EMAIL WELCOME: ' . $e->getMessage());
        }

        // SendWelcomeEmail::dispatch([
        //     'email' => $data['email'],
        //     'username' => $data['username'],
        // ]);
    }
}
