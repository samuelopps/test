<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferRequest;
use App\Http\Resources\Transfer\TransferCollection;
use App\Http\Resources\Transfer\TransferResource;
use App\Services\Interfaces\TransferServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Class TransferController
 * @package App\Http\Controllers\Api\V1
 */
class TransferController extends Controller
{
    /**
     * @var TransferServiceInterface
     */
    private TransferServiceInterface $transferServiceInterface;

    /**
     * TransferController constructor.
     * @param TransferServiceInterface $transferServiceInterface
     */
    public function __construct(
        TransferServiceInterface $transferServiceInterface)
    {
        $this->transferServiceInterface = $transferServiceInterface;
    }

    /**
     * @OA\Get(
     *      path="/transfers",
     *      operationId="getAll",
     *      tags={"Transfers"},
     *      summary="Get list of transfers",
     *      description="Returns list of transfers",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of all transers",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                   @OA\Property(property="id", type="number"),
     *                   @OA\Property(property="amount", type="number"),
     *                   @OA\Property(property="status", type="string"),
     *                   @OA\Property(property="notified", type="boolean"),
     *                   @OA\Property(property="paying_purse", type="object",
     *                       @OA\Property(property="id", type="number"),
     *                       @OA\Property(property="balance", type="number"),
     *                       @OA\Property(property="status", type="string"),
     *                       @OA\Property(property="user", type="object",
     *                           @OA\Property(property="id", type="number"),
     *                           @OA\Property(property="name", type="string"),
     *                           @OA\Property(property="email", type="string"),
     *                           @OA\Property(property="document", type="string"),
     *                           @OA\Property(property="profile", type="string"),
     *                           @OA\Property(property="status", type="string")
     *                       ),
     *                   ),
     *                   @OA\Property(property="receiver_purse", type="object",
     *                       @OA\Property(property="id", type="number"),
     *                       @OA\Property(property="balance", type="number"),
     *                       @OA\Property(property="status", type="string"),
     *                       @OA\Property(property="user", type="object",
     *                           @OA\Property(property="id", type="number"),
     *                           @OA\Property(property="name", type="string"),
     *                           @OA\Property(property="email", type="string"),
     *                           @OA\Property(property="document", type="string"),
     *                           @OA\Property(property="profile", type="string"),
     *                           @OA\Property(property="status", type="string")
     *                       ),
     *                   ),
     *               ),
     *           )
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
     * @return TransferCollection|JsonResponse
     */
    public function index(): TransferCollection|JsonResponse
    {
        try {
            $transfers = $this->transferServiceInterface->getAll();

            return response()->json(
                new TransferCollection($transfers->load('payingPurse.user', 'receiverPurse.user')), 200);
        } catch (Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/transfers",
     *      operationId="store",
     *      tags={"Transfers"},
     *      summary="Create transfer",
     *      description="Return created new transfer",
     *      @OA\RequestBody(
     *          @OA\MediaType( mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="amount", type="number"),
     *                  @OA\Property(property="receiver_purse_id", type="integer"),
     *                 @OA\Property(property="paying_purse_id", type="integer"),
     *               )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              description="data of new transfer",
     *              type="object",
     *              @OA\Property(property="data", type="object",
     *                  @OA\Property(property="id", type="number"),
     *                  @OA\Property(property="amount", type="number"),
     *                  @OA\Property(property="status", type="string"),
     *                  @OA\Property(property="notified", type="boolean"),
     *                  @OA\Property(property="paying_purse", type="object",
     *                      @OA\Property(property="id", type="number"),
     *                      @OA\Property(property="balance", type="number"),
     *                      @OA\Property(property="status", type="string"),
     *                      @OA\Property(property="user", type="object",
     *                          @OA\Property(property="id", type="number"),
     *                          @OA\Property(property="name", type="string"),
     *                          @OA\Property(property="email", type="string"),
     *                          @OA\Property(property="document", type="string"),
     *                          @OA\Property(property="profile", type="string"),
     *                          @OA\Property(property="status", type="string"),
     *                      ),
     *                  ),
     *                  @OA\Property(property="receiver_purse", type="object",
     *                      @OA\Property(property="id", type="number"),
     *                      @OA\Property(property="balance", type="number"),
     *                      @OA\Property(property="status", type="string"),
     *                      @OA\Property(property="user", type="object",
     *                          @OA\Property(property="id", type="number"),
     *                          @OA\Property(property="name", type="string"),
     *                          @OA\Property(property="email", type="string"),
     *                          @OA\Property(property="document", type="string"),
     *                          @OA\Property(property="profile", type="string"),
     *                          @OA\Property(property="status", type="string"),
     *                      ),
     *                  ),
     *              ),
     *           )
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
     *     )
     *
     *
     * @param TransferRequest $request
     * @return TransferResource|JsonResponse
     */
    public function store(TransferRequest $request): TransferResource|JsonResponse
    {
        DB::beginTransaction();

        try {
            $transfer = $this->transferServiceInterface
                ->create($request->all());
            DB::commit();

            return response()->json(
                new TransferResource($transfer->load('payingPurse.user', 'receiverPurse.user')), 201);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
