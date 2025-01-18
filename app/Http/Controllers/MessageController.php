<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function __construct(protected MessageService $messageService) {}


    public function index()
    {
        $result = $this->messageService->all();

        return response()->json($result);
    }

    public function store(MessageRequest $request)
    {
        $data = $request->validated();

        $message = $this->messageService->createOrUpdateMessage($data);

        return response()->json([
            'message' => 'Message created successfully.',
            'data' => $message
        ]);
    }
}
