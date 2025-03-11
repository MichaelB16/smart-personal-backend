<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserRequest;
use App\Services\Mails\SendEmailNewPasswordService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected SendEmailNewPasswordService $sendEmailNewPasswordService
    ) {}


    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($this->userService->getByEmail($data['email'])) {
            return response()->json([
                'error' => 'user_exists',
                'message' => 'user exists!'
            ], 422);
        }

        $user = $this->userService->create($data);

        if ($user && $user->id) {
            $this->sendEmailNewPasswordService->send([
                'user_id' => $user->id,
                'email' => $user->email,
                'username' => $user->name,
            ]);
        }

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $result = $this->userService->find($id);

        return response()->json($result);
    }

    public function update(StudentRequest $request, string $id)
    {
        $data = $request->validated();

        $result = $this->userService->update($id, $data);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data' => $result
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->userService->delete($id);

        return response()->json([
            'message' => 'successfully deleted',
            'data' => $result
        ]);
    }
}
