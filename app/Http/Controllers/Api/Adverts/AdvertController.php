<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Adverts;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\SearchRequest;
use App\Http\Resources\Adverts\AdvertDetailResource;
use App\Http\Resources\Adverts\AdvertListResource;
use App\Models\Adverts\Advert\Advert;
use App\Models\Adverts\Category;
use App\Models\Region;
use App\UseCases\Adverts\SearchService;
use Illuminate\Support\Facades\Gate;
use Swagger\Annotations as SWG;


/**
 * @SWG\Get(
 *     path="/adverts",
 *     tags={"Adverts"},
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
class AdvertController extends Controller
{
    private $search;

    public function __construct(SearchService $search)
    {
        $this->search = $search;
    }

    public function index(SearchRequest $request)
    {
        $region = $request->get('region') ? Region::findOrFail($request->get('region')) : null;
        $category = $request->get('category') ? Category::findOrFail($request->get('category')) : null;

        $result = $this->search->search($category, $region, $request, 20, $request->get('page', 1));

        return AdvertListResource::collection($result->adverts);
    }

    /**
     * @SWG\Get(
     *     path="/adverts/{advertId}",
     *     tags={"Adverts"},
     *     @SWG\Parameter(
     *         name="advertId",
     *         description="ID of advert",
     *         in="path",
     *         required=true,
     *         type="integer"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(ref="#/definitions/AdvertDetail"),
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function show(Advert $advert)
    {
        if (!($advert->isActive() || Gate::allows('show-advert', $advert))) {
            abort(403);
        }

        return new AdvertDetailResource($advert);
    }
}
