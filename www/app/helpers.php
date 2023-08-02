<?php

use App\Http\Router\AdvertsPath;
use App\Models\Advert;
use App\Models\AdvertCategory;
use App\Models\Regions;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Cache;

if (!function_exists('adverts_path')) {

    function adverts_path(?Regions $region, ?AdvertCategory $category)
    {
        return app()->make(AdvertsPath::class)
            ->withRegion($region)
            ->withCategory($category);
    }
}

if (!function_exists('get_locale')) {

    function getLocale()
    {
        return app()->currentLocale();
    }
}