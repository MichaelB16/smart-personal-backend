<?php

namespace App\Services;

use App\Models\Message;

class MessageService
{
    public function __construct(protected Message $message) {}

    public function all()
    {
        return $this->message->select(['message_pre_class', 'message_pre_expiry'])->first();
    }

    public function createOrUpdateMessage(array $data)
    {
        return $this->message->updateOrCreate(
            [
                'user_id' => get_user_id()
            ],
            [
                ...$data
            ]
        );
    }
}
