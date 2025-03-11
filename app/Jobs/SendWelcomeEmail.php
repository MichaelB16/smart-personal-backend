<?php

namespace App\Jobs;

use App\Mail\SendMailUser;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
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
            Mail::to($this->data['email'])->send(new SendMailUser([
                'username' => $this->data['username'],
            ]));
        } catch (Exception $e) {
            Log::error('ERROR SEND EMAIL WELCOME: ' . $e->getMessage());
        }
    }
}
