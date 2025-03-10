<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendCreateStudent;
use App\Services\NewPasswordService;
use Exception;
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

            Mail::to($this->data['email'])->send(new SendCreateStudent([
                'username' => $this->data['username'],
                'url' => env('APP_URL_FRONT') . '/new/password/' . $new_password->token
            ]));
        } catch (Exception $e) {
            Log::error('ERROR SEND EMAIL CREATE STUDENT: ' . $e->getMessage());
        }
    }
}
