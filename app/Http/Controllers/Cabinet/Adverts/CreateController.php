<?php

namespace App\Http\Controllers\Cabinet\Adverts;


use App\Http\Controllers\Controller;
use App\Http\Requests\Adverts\CreateRequest;
use App\Models\Adverts\Category;
use App\Models\Region;
use App\UseCases\Adverts\AdvertService;
use Illuminate\Support\Facades\Auth;

class CreateController extends Controller
{
    private AdvertService $service;

    public function __construct(AdvertService $service)
    {
        $this->service = $service;
    }

    public function category()
    {
        $categories = Category::defaultOrder()->withDepth()->get()->toTree();

        return view('cabinet.adverts.create.category', compact('categories'));
    }

    public function region(Category $category, Region|null $region = null)
    {
        $regions = Region::where('parent_id', $region ? $region->id : null)->orderBy('name')->get();

        return view('cabinet.adverts.create.region', compact('category', 'region', 'regions'));
    }

    public function advert(Category $category, Region|null $region = null)
    {
        return view('cabinet.adverts.create.advert', compact('category', 'region'));
    }

    public function store(CreateRequest $request, Category $category, Region|null $region = null)
    {
        try {
            $advert = $this->service->create(
                Auth::id(),
                $category->id,
                $region ? $region->id : null,
                $request
            );
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('adverts.show', $advert);
    }
}