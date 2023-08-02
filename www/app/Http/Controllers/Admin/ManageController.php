<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use App\Http\Requests\Adverts\AttributesRequest;
use App\Http\Requests\Adverts\RejectRequest;
use App\Http\Requests\Adverts\UpdateInfoRequest;
use App\Models\Advert;
use App\Models\AdvertAttributes;
use App\Models\AdvertCategory;
use App\Models\Regions;
use App\Service\Adverts\AdvertsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    private $service; 

    public function __construct(AdvertsService $service) {
        //$this->middleware(FilledProfile::class);
        $this->service = $service;
    }

    public function attributes (Advert $advert) {
        $attributes = AdvertAttributes::all()->keyBy('id');
        return view('adverts.edit_attributes', compact('advert', 'attributes'));
    }

    public function attributes_update (Advert $advert, AttributesRequest $request) {

        $this->service->editAttributes($advert->id, $request);

        return redirect(route('manage.show', $advert));
    }

    public function index (Request $request) {
        $statuses = Advert::statusList();
        $manage_active = TRUE;
        $adverts = $this->service->getAdverts(Auth::user(), $request);
        $regions = Regions::where('parent_id', '=', NULL)->pluck('name', 'id');
        $categories = AdvertCategory::defaultOrder()->pluck('name', 'id');
        return view('adverts.index', compact('adverts', 'manage_active', 'statuses', 'regions', 'categories'));
    }    

    public function show (Advert $advert) {
        $attributes = AdvertAttributes::all()->keyBy('id');
        $manage_active = TRUE;
        $statuses = Advert::statusList();
        return view('adverts.show', compact('advert', 'manage_active', 'statuses', 'attributes'));
    }  


    public function deletePhoto($id) {
        $this->service->deletePhoto($id);
        return redirect()->back();
    }

    public function editInfo(Advert $advert) {
        return view('adverts.edit', compact('advert'));
    }

    public function updateInfo(UpdateInfoRequest $request, Advert $advert) {
        $this->service->updateInfo($request, Auth::user(), $advert);
        return redirect()->route('manage.show', [$advert]);
    }

    public function approve(Advert $advert) { 

            $this->service->approveAdvert($advert->id);
            return redirect()->back();
    }

    public function reject(Advert $advert, RejectRequest $request) {
        $this->service->reject($advert->id, $request);
        return redirect()->back();
    }

    public function deactivate(Advert $advert) {
        $this->service->deactivate($advert->id);
        return redirect()->back();
    }

    public function delete(Advert $advert) {
        $advert->delete();
        return redirect()->route('manage.index')->with('info', __('advert.deletesuc'));
    }

}
