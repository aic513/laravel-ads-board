<?php

use App\Http\Route\AdvertsPath;
use App\Models\Adverts\Category;
use App\Models\Region;
use Illuminate\Contracts\Container\BindingResolutionException;

if (!function_exists('adverts_path')) {

    /**
     * @throws BindingResolutionException
     */
    function adverts_path(Region|null $region, Category|null $category)
    {
        return app()->make(AdvertsPath::class)
            ->withRegion($region)
            ->withCategory($category);
    }
}