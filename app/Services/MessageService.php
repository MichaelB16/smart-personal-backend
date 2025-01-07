<?php

namespace App\Services;

use App\Models\Message;

class MessageService
{
    public function __construct(protected Message $message) {}

    public function all()
    {
        return $this->message->first();
    }

    public function createOrUpdateMessage(array $data)
    {
        return $this->message->updateOrCreate(
            [
                'user_id' => auth()->id()
            ],
            [
                ...$data
            ]
        );
    }
}
