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

    /**
    * @OA\Post(
    *      path="v1/users",
    *      operationId="Title",
    *      tags={"users"},
    *      summary="add users",
    *      description="register new users",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/Request")
    *      ),
    *      @OA\Response(
    *          response=Response Code,
    *          description="Response Message",
    *       ),
    *     )
    */
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

    /**
    * @OA\Post(
    *      path="v1/users/{id}",
    *      operationId="user_id",
    *      tags={"Tags"},
    *      summary="find user",
    *      description="get find user",
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(ref="#/components/schemas/Request")
    *      ),
    *      @OA\Response(
    *          response=Response Code,
    *          description="Response Message",
    *       ),
    *     )
    */
    public function show(string $id): JsonResponse
    {
        $result = $this->userService->find($id);

        return response()->json($result);
    }

    /**
    * @OA\Put(
    *      path="v1/users/{id}",
    *      operationId="user_id",
    *      tags={"Tags"},
    *      summary="update user",
    *      description="set update user",
    *      @OA\Parameter(
    *          description="user_id",
    *          in="path",
    *          name="id",
    *          required=true,
    *          @OA\Schema(type="int"),
    *          @OA\Examples(example="int", value="1", summary="an int value"),
    *      ),
    *      @OA\RequestBody(
    *          required=Parameter with example,
    *          @OA\JsonContent(ref="#/components/schemas/path")
    *      ),
    *      @OA\Response(
    *          response=int,
    *          description="1",
    *       ),
    *     )
    */
    public function update(StudentRequest $request, string $id)
    {
        $data = $request->validated();

        $result = $this->userService->update($id, $data);

        return response()->json([
            'message' => 'Student updated successfully.',
            'data' => $result
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $result = $this->userService->delete($id);

        return response()->json([
            'message' => 'successfully deleted',
            'data' => $result
        ]);
    }
}
