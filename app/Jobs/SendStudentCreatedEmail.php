<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCreateStudent;
use App\Services\NewPasswordService;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendStudentCreatedEmail implements ShouldQueue
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
                'student_id' => $this->data['student_id']
            ]);

            $this->data['event'] = 'student_created';
            $this->data['url'] = env('APP_URL_FRONT') . '/new/password/' . $new_password->token;

            Http::post(env('WEBHOOK_PIPEDREAM_URL'), [
                ...$this->data,
                'html' => view('mail.create_student', $this->data)->render()
            ]);
        } catch (Exception $e) {
            Log::error('ERROR SEND EMAIL CREATE STUDENT: ' . $e->getMessage());
        }
    }
}
