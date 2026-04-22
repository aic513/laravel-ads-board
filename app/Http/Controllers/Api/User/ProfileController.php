<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cabinet\ProfileEditRequest;
use App\Http\Resources\User\ProfileResource;
use App\Models\User;
use App\UseCases\Profile\ProfileService;
use Illuminate\Http\Request;
use Swagger\Annotations as SWG;

class ProfileController extends Controller
{
    private $service;

    public function __construct(ProfileService $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(
     *     path="/user",
     *     tags={"Profile"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(ref="#/definitions/Profile"),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function show(Request $request)
    {
        return new ProfileResource($request->user());
    }

    public function update(ProfileEditRequest $request)
    {
        $this->service->edit($request->user()->id, $request);

        $user = User::findOrFail($request->user()->id);
        return new ProfileResource($user);
    }
}
