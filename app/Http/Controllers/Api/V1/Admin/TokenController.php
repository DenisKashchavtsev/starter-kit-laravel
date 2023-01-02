<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Exceptions\ValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Token\DestroyTokenRequest;
use App\Http\Requests\V1\Admin\Token\StoreTokenRequest;
use App\Services\V1\Admin\Token\CreateTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TokenController extends Controller
{
    /**
     * @OA\Post(
     *      path="/admin/tokens",
     *      operationId="storeToken",
     *      tags={"Tokens"},
     *      summary="Store new token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreTokenRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Content",
     *      )
     * )
     */
    public function store(StoreTokenRequest $request, CreateTokenService $createTokenService): JsonResponse
    {
        $token = $createTokenService->create(
            $request->email, $request->password, $request->device_name
        );

        if (!$token) {
            throw new ValidationException('The provided credentials are incorrect.');
        }

        return response()->json(
            ['token' => $token],
            ResponseAlias::HTTP_CREATED
        );
    }

    /**
     * @OA\Delete(
     *      path="/admin/tokens",
     *      operationId="deleteToken",
     *      tags={"Tokens"},
     *      summary="Delete existing token",
     *      description="Deletes a record and returns no content",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/DestroyTokenRequest")
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Undocumented",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function destroy(DestroyTokenRequest $request): Response
    {
        Auth::user()->tokens()->whereName($request->device_name)->delete();

        return response()->noContent();
    }
}
