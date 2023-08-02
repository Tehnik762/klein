<?php

namespace App\Http\Controllers\Profil\Adverts;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use App\Http\Requests\Adverts\CreateRequest;
use App\Http\Requests\Adverts\PhotoRequest;
use App\Models\Advert;
use App\Models\AdvertAttributes;
use App\Models\AdvertCategory;
use App\Models\Regions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Service\Adverts\AdvertsService;
use Illuminate\Support\Facades\Gate;

class CreateAdvertController extends Controller
{
     private $service;
    public function __construct() {
        $this->middleware(FilledProfile::class);
        $this->service = new AdvertsService();
    }
    
   public function category() {
        $categories = AdvertCategory::defaultOrder()->withDepth()->get()->toTree();
        return view('profil.adverts.category', compact('categories'));

   }

   /**
    * @param AdvertCategory $category
    * @param Regions|null $region
    * 
    * @return [type]
    */
   public function region(AdvertCategory $category, Regions $region = null) {
        $regions = Regions::where('parent_id', '=', $region ? $region->id : null)->orderBy('name')->get();
        return view('profil.adverts.region', compact('regions', 'region', 'category'));
   }

   /**
    * @param (AdvertCategory $category
    * @param Regions|null $region
    * 
    * @return [type]
    */
   public function content(AdvertCategory $category, Regions $region = null) {
        return view('profil.adverts.create', compact('category', 'region'));
   }


   public function store(CreateRequest $request, AdvertCategory $category, Regions $region = null) {
          try {
               $advert = $this->service->create(
                    Auth::id(),
                    $category->id,
                    $region->id,
                    $request
               );
          } catch(\DomainException $e) {
               return back()->with('error', $e->getMessage());
          }
          return redirect()->route('profil.adverts.show', $advert);
   }

   public function show(Advert $advert) {
     if (!Gate::allows('show-advert', $advert)) {
          abort(403);
     }
          $attributes = AdvertAttributes::all()->keyBy('id');

          $status_list = Advert::statusList();

          return view('profil.adverts.show', compact('advert', 'status_list', 'attributes'));
   }
   

   public function addphotos(Advert $advert) {
     return view('profil.adverts.photos.add', compact('advert'));
   }

   public function storephotos(Advert $advert, PhotoRequest $request) {
     try {
          $photos = $this->service->addPhotos($advert->id, $request);
     } catch (\DomainException $e) {
          return back()->with('error', $e->getMessage());
     }
          return redirect()->route('profil.adverts.show', $advert);
   }


}
