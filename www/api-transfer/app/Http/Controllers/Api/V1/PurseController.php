<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurseRequest;
use App\Http\Resources\Purse\PurseResource;
use App\Services\Interfaces\PurseServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Class PurseController
 * @package App\Http\Controllers\Api\V1
 */
class PurseController extends Controller
{
    /**
     * @var PurseServiceInterface
     */
    private PurseServiceInterface $purseServiceInterface;

    /**
     * PurseController constructor.
     * @param PurseServiceInterface $purseServiceInterface
     */
    public function __construct(
        PurseServiceInterface $purseServiceInterface
    ) {
        $this->purseServiceInterface = $purseServiceInterface;
    }

    /**
     * @OA\Post(
     *      path="/purses",
     *      operationId="store",
     *      tags={"Purses"},
     *      summary="Create purse",
     *      description="Return created new purse",
     *      @OA\RequestBody(
     *          @OA\MediaType( mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="balance", type="number"),
     *                   @OA\Property(property="user_id", type="integer"),
     *               )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of new purse",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                   @OA\Property(property="id", type="number"),
     *                   @OA\Property(property="balance", type="number"),
     *                   @OA\Property(property="status", type="string"),
     *                   @OA\Property(property="user", type="object",
     *                       @OA\Property(property="id", type="number"),
     *                       @OA\Property(property="name", type="string"),
     *                       @OA\Property(property="email", type="string"),
     *                       @OA\Property(property="document", type="string"),
     *                       @OA\Property(property="profile", type="string"),
     *                       @OA\Property(property="status", type="string")
     *                   ),
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
     *  	@OA\Response(
     *          response=422,
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
     * )
     *
     * @param PurseRequest $request
     * @return PurseResource|JsonResponse
     */
    public function store(PurseRequest $request): PurseResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $purse = $this->purseServiceInterface->create($request->all());

            DB::commit();

            return response()->json(new PurseResource($purse->load('user')), 201);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Patch(
     *      path="/purses/{purse_id}/balance",
     *      operationId="updateBalance",
     *      tags={"Purses"},
     *      summary="Update Balance from Purse",
     *      description="Return updated Balance",
     *      @OA\Parameter(
     *          name="purse_id",
     *          in="path",
     *          required=true,
     *          description="Purse id",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType( mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="balance", type="number"),
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of updated wallet",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                   @OA\Property(property="id", type="number"),
     *                   @OA\Property(property="balance", type="number"),
     *                   @OA\Property(property="status", type="string"),
     *                   @OA\Property(property="user", type="object",
     *                       @OA\Property(property="id", type="number"),
     *                       @OA\Property(property="name", type="string"),
     *                       @OA\Property(property="email", type="string"),
     *                       @OA\Property(property="document", type="string"),
     *                       @OA\Property(property="profile", type="string"),
     *                       @OA\Property(property="status", type="string")
     *                   ),
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
     *          response=404,
     *          description="Not Found",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
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
     * )
     *
     * @param PurseRequest $request
     * @param int $purse_id
     * @return PurseResource|JsonResponse
     */
    public function updateBalance(PurseRequest $request, int $purse_id): PurseResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $purse = $this->purseServiceInterface->update($purse_id, $request->all());

            DB::commit();

            return response()->json(new PurseResource($purse->load('user')), 200);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
