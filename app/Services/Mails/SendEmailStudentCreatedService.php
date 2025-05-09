<?php

namespace App\Services\Mails;

use App\Contracts\SendEmailInterface;
use App\Jobs\SendStudentCreatedEmail;
use App\Services\NewPasswordService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendEmailStudentCreatedService implements SendEmailInterface
{

    public function __construct(protected NewPasswordService $newPasswordService) {}

    public function send(array $data)
    {
        try {
            $newPassword = $this->newPasswordService->create([
                'student_id' => $data['student_id'],
            ]);

            Http::post(env('WEBHOOK_PIPEDREAM_URL'), [
                ...$data,
                'event' => 'student_created',
                'url' => env('APP_URL_FRONT') . '/new/password/' . $newPassword->token
            ]);
        } catch (Exception $e) {
            Log::error('ERROR SEND EMAIL CREATE STUDENT: ' . $e->getMessage());
        }
    }
}
