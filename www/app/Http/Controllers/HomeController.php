<?php

namespace App\Http\Controllers;

use App\Http\Router\AdvertsPath;
use App\Models\Advert;
use App\Models\AdvertAttributes;
use App\Models\AdvertCategory;
use App\Models\Regions;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
   
    }

    public function index()
    {

        $categories = AdvertCategory::whereIsRoot()->defaultOrder()->get();
        
        $regions = Regions::where('parent_id', NULL)->orderBy('name', 'asc')->get();

        $adverts = Advert::active()->orderBy('published_at', 'DESC')->paginate(12);

        $region = NULL;
        $category = NULL;

        return view('welcome', compact('adverts', 'categories', 'regions', 'region', 'category'));
    }

    public function show(Advert $advert) {
        
        if ($advert->status == Advert::STATUS_ACTIVE) {
            $user = Auth::id();
            $attributes = AdvertAttributes::all()->keyBy('id');           
            return view('main.show', compact('advert', 'attributes', 'user'));
        } else {
            return redirect()->back();
        }

    }

    public function makeFavourite(Advert $advert) {
        $user_id = Auth::id();
        $advert->makeFavourite($user_id);
        return redirect()->back();
    }
    

    public function filtered(AdvertsPath $adverts_path) {
        
        $query = Advert::active()->with(['category', 'region'])->orderByDesc('published_at');

        if ($category = $adverts_path->category) {
            $query->forCategory($category);
        }

        if ($region = $adverts_path->region) {
            $query->forRegion($region);
        }

        $regions = $region ? $region->children()->orderBy('name')->get() : Regions::where("parent_id", NULL)->orderBy('name')->get();
        
        $categories = $category
        ? $category->children()->defaultOrder()->get()
        : AdvertCategory::whereIsRoot()->defaultOrder()->get();
        
        $adverts = $query->paginate(12);


        return view('welcome', compact('adverts', 'categories', 'regions', 'region', 'category', 'adverts_path'));
    }

}
