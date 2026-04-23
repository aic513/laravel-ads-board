<?php

use App\Http\Route\AdvertsPath;
use App\Http\Route\PagePath;
use App\Models\Adverts\Category;
use App\Models\Page;
use App\Models\Region;

if (!function_exists('adverts_path')) {

    function adverts_path(?Region $region, ?Category $category)
    {
        return app()->make(AdvertsPath::class)
            ->withRegion($region)
            ->withCategory($category);
    }
}

if (!function_exists('page_path')) {

    function page_path(Page $page)
    {
        return app()->make(PagePath::class)
            ->withPage($page);
    }
}
