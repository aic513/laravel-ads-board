<?php

namespace App\Http\Route;


use App\Models\Adverts\Category;
use App\Models\Region;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Facades\Cache;

class AdvertsPath implements UrlRoutable
{

    public Region|null $region;

    public Category|null $category;

    public function withRegion(Region|null $region): self
    {
        $clone = clone $this;
        $clone->region = $region;
        return $clone;
    }

    public function withCategory(Category|null $category): self
    {
        $clone = clone $this;
        $clone->category = $category;
        return $clone;
    }

    public function getRouteKey()
    {
        $segments = [];

        if ($this->region) {
            $segments[] = Cache::tags(Region::class)->rememberForever('region_path_' . $this->region->id, function () {
                return $this->region->getPath();
            });
        }

        if ($this->category) {
            $segments[] = Cache::tags(Category::class)->rememberForever('category_path_' . $this->category->id,
                function () {
                    return $this->category->getPath();
                });
        }

        return implode('/', $segments);
    }

    public function getRouteKeyName(): string
    {
        return 'adverts_path';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $chunks = explode('/', $value);

        /** @var Region|null $region */
        $region = null;
        do {
            $slug = reset($chunks);
            if ($slug && $next = Region::where('slug', $slug)->where('parent_id',
                    $region ? $region->id : null)->first()) {
                $region = $next;
                array_shift($chunks);
            }
        } while (!empty($slug) && !empty($next));

        /** @var Category|null $category */
        $category = null;
        do {
            $slug = reset($chunks);
            if ($slug && $next = Category::where('slug', $slug)->where('parent_id',
                    $category ? $category->id : null)->first()) {
                $category = $next;
                array_shift($chunks);
            }
        } while (!empty($slug) && !empty($next));

        if (!empty($chunks)) {
            abort(404);
        }

        return $this
            ->withRegion($region)
            ->withCategory($category);
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}