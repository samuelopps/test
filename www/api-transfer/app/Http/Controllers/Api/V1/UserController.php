<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Purse\PurseResource;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Services\Interfaces\PurseServiceInterface;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\V1
 */
class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private UserServiceInterface $userServiceInterface;

    /**
     * @var PurseServiceInterface
     */
    private PurseServiceInterface $purseServiceInterface;

    /**
     * UserController constructor.
     * @param UserServiceInterface $userServiceInterface
     */
    public function __construct(
        UserServiceInterface $userServiceInterface,
        PurseServiceInterface $purseServiceInterface)
    {
        $this->userServiceInterface = $userServiceInterface;
        $this->purseServiceInterface = $purseServiceInterface;
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getAll",
     *      tags={"Users"},
     *      summary="Get list of users",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="list of users",
     *              type="object",
     *              @OA\Property(property="data", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="id", type="number"),
     *                      @OA\Property(property="name", type="string"),
     *                      @OA\Property(property="email", type="string"),
     *                      @OA\Property(property="document", type="string"),
     *                      @OA\Property(property="profile", type="string"),
     *                      @OA\Property(property="status", type="string"),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      )
     *     )
     *
     *
     * @return UserCollection|JsonResponse
     */
    public function index(): UserCollection|JsonResponse
    {
        try {
            $users = $this->userServiceInterface->getAll();

            return response()->json(new UserCollection($users), 200);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/users/{user_id}/purse",
     *      operationId="getPurse",
     *      tags={"Users"},
     *      summary="Get purse by user",
     *      description="Returns purse by user",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          description="user_id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="purse by user",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="balance", type="number"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="user", type="object",
     *                           @OA\Property(property="id", type="number"),
     *                           @OA\Property(property="name", type="string"),
     *                           @OA\Property(property="email", type="string"),
     *                           @OA\Property(property="document", type="string"),
     *                           @OA\Property(property="profile", type="string"),
     *                           @OA\Property(property="status", type="string")
     *                  ),
     *              ),
     *          )
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="Not Found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Error",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      )
     *     )
     *
     *
     * @param int $user_id
     * @return PurseResource|JsonResponse
     */
    public function getPurse(int $user_id): JsonResponse|PurseResource
    {
        try {
            $purse = $this->purseServiceInterface->getByUserId($user_id);

            return response()->json(
                new PurseResource($purse->load('user')),
                200
            );
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="store",
     *      tags={"Users"},
     *      summary="Create user",
     *      description="Return created user",
     *      @OA\RequestBody(
     *          @OA\MediaType(mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="name", type="string"),
     *                   @OA\Property(property="email", type="string"),
     *                   @OA\Property(property="password", type="string"),
     *                   @OA\Property(property="document", type="string"),
     *                   @OA\Property(property="profile", type="string"),
     *                   @OA\Property(property="status", type="string"),
     *              )
     *           )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of new user",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="name", type="string"),
     *                  @OA\Property(property="email", type="string"),
     *                  @OA\Property(property="document", type="string"),
     *                  @OA\Property(property="profile", type="string"),
     *                  @OA\Property(property="status", type="string")
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="Conflict",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="The given data was invalid",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Server Erro",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      )
     *     )
     *
     *
     * @param UserRequest $request
     * @return UserResource|JsonResponse
     */
    public function store(UserRequest $request): UserResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $user = $this->userServiceInterface->create($request->all());

            DB::commit();
            return response()->json(new UserResource($user), 201);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
