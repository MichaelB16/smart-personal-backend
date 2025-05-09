<?php

namespace App\Jobs;

use App\Mail\SendUserNewPassowrd;
use App\Services\NewPasswordService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNewPasswordEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected array $data)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $new_password = app(NewPasswordService::class)->create([
                'user_id' => $this->data['user_id']
            ]);

            $this->data['event'] = 'new_password';
            $this->data['subject'] = 'Nova senha';
            $this->data['url'] = env('APP_URL_FRONT') . '/new/password/' . $new_password->token;

            Http::post(env('WEBHOOK_PIPEDREAM_URL'), [
                ...$this->data,
                'html' => view('mail.new_password', $this->data)->render()
            ]);
        } catch (Exception $e) {
            Log::error('ERROR SEND NEW PASSWORD EMAIL: ' . $e->getMessage());
        }
    }
}
