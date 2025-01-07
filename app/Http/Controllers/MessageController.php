<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(protected MessageService $messageService) {}


    public function index()
    {
        $result = $this->messageService->all();

        return response()->json($result);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'message_pre_class' => 'required',
            'message_pre_expiry' => 'required'
        ]);

        $message = $this->messageService->createOrUpdateMessage($data);

        return response()->json([
            'message' => 'Message created successfully.',
            'data' => $message
        ]);
    }
}
