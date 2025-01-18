<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserRequest;
use App\Mail\SendUserNewPassowrd;
use App\Services\NewPasswordService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct(protected UserService $userService, protected NewPasswordService $newPasswordService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($this->userService->getByEmail($data['email'])) {
            return response()->json(['error' => 'user_exists', 'message' => 'user exists!'], 422);
        }

        $user = $this->userService->create($data);

        if ($user && $user->id) {
            $new_password = $this->newPasswordService->create(['user_id' => $user->id]);
            $this->sendEmailNewPassword($user, $new_password->token);
        }

        return response()->json([
            'message' => 'User created successfully.',
            'data' => $user
        ]);
    }

    protected function sendEmailNewPassword($user, $token)
    {
        try {
            Mail::to($user->email)->send(new SendUserNewPassowrd([
                'url' => env('APP_URL_FRONT') . '/new/password/' . $token,
                'username' => $user->name,
            ]));
        } catch (Exception $e) {
            return $e->getMessage();
        }
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
