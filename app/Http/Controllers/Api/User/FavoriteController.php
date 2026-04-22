<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Controller;
use App\Http\Resources\Adverts\AdvertDetailResource;
use App\Models\Adverts\Advert\Advert;
use App\UseCases\Adverts\FavoriteService;
use Illuminate\Support\Facades\Auth;
use Swagger\Annotations as SWG;

class FavoriteController extends Controller
{
    private $service;

    public function __construct(FavoriteService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    /**
     * @SWG\Get(
     *     path="/user/favorites",
     *     tags={"Favorites"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(
     *             type="array",
     *             @SWG\Items(ref="#/definitions/AdvertList")
     *         ),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function index()
    {
        $adverts = Advert::favoredByUser(Auth::user())->orderByDesc('id')->paginate(20);

        return AdvertDetailResource::collection($adverts);
    }

    public function remove(Advert $advert)
    {
        try {
            $this->service->remove(Auth::id(), $advert->id);
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('cabinet.favorites.index');
    }
}
