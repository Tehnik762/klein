<?php

namespace App\Http\Router;

use App\Models\AdvertCategory;
use App\Models\Regions;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Support\Facades\Cache;

class AdvertsPath implements UrlRoutable {
     /**
     * @var Regions
     */
    public $region;
    
    /**
     * @var AdvertCategory
     */
    public $category;

    public function withRegion(?Regions $region): self
    {
        $clone = clone $this;
        $clone->region = $region;
        return $clone;
    }

    public function withCategory(?AdvertCategory $category): self
    {
        $clone = clone $this;
        $clone->category = $category;
        return $clone;
    }


   /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey() {
        $segments = [];

        if ($this->region) {
            $segments[] = Cache::rememberForever("region_".$this->region->id, function () {
                return $this->region->getPath();
            });
        }

        if ($this->category) {
            $segments[] = Cache::rememberForever("category_".$this->category->id, function () {
                return $this->category->getPath();
            });
        }

        return implode('/', $segments);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName() {
        return 'adverts_path';
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null) {
        
        $route = Cache::rememberForever($value, function () use ($value) {
            
            $chunks = explode('/', $value);

            /** @var Regions|null $region */
            $region = null;
            do {
                $slug = reset($chunks);
                if ($slug && $next = Regions::where('slug', $slug)->where('parent_id', $region ? $region->id : null)->first()) {
                    $region = $next;
                    array_shift($chunks);
                }
            } while (!empty($slug) && !empty($next));
    
            /** @var Category|null $category */
            $category = null;
            do {
                $slug = reset($chunks);
                if ($slug && $next = AdvertCategory::where('slug', $slug)->where('parent_id', $category ? $category->id : null)->first()) {
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
        });
        return $route;
    }

    /**
     * Retrieve the child model for a bound value.
     *
     * @param  string  $childType
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field) {
        return null;
    }
}

