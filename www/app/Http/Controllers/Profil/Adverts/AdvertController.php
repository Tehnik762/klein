<?php

namespace App\Http\Controllers\Profil\Adverts;

use App\Http\Controllers\Controller;
use App\Http\Middleware\FilledProfile;
use App\Http\Requests\Adverts\AttributesRequest;
use App\Http\Requests\Adverts\UpdateInfoRequest;
use App\Models\Advert;
use App\Models\AdvertAttributes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Service\Adverts\AdvertsService;
use App\Service\GetCategories;

class AdvertController extends Controller
{
    public $service;

    public function __construct(AdvertsService $service)
    {
        $this->middleware(FilledProfile::class);
        $this->service = $service;
    }

    public function index()
    {
        $user = Auth::id();
        $adverts = Advert::where('user_id', $user)->get();
        $statuses = Advert::statusList();
        return view('profil.adverts.index', compact('adverts', 'statuses'));
    }

    public function create()
    {
        $regions = new GetCategories();
        $regions = $regions->give(0);
        return view('profil.adverts.create', compact(['regions']));
    }

    public function attributes(Advert $advert)
    {
        $attributes = AdvertAttributes::all()->keyBy('id');
        return view('profil.adverts.edit_attributes', compact('advert', 'attributes'));
    }

    public function update_attributes(Advert $advert, AttributesRequest $request)
    {

        $this->service->editAttributes($advert->id, $request);
        return redirect(route('profil.adverts.show', $advert));
    }

    public function editInfo(Advert $advert)
    {
        return view('profil.adverts.edit', compact('advert'));
    }

    public function updateInfo(UpdateInfoRequest $request, Advert $advert)
    {
        $this->service->updateInfo($request, Auth::user(), $advert);
        return redirect()->route('profil.adverts.show', [$advert]);
    }

    public function moderate(Advert $advert)
    {
        $advert->sendToModeration();
        return redirect()->back()->with('info', __('advert.sentmoderate'));
    }

    public function deactivate(Advert $advert)
    {
        $this->service->deactivate($advert->id);
        return redirect()->back()->with('info', __('advert.deactivatesuc'));
    }

    public function delete(Advert $advert)
    {
        $advert->delete();
        return redirect()->route('profil.adverts')->with('info', __('advert.deletesuc'));
    }

    public function favourites()
    {
        /** @var User $user */
        $user = Auth::user();
        $adverts = $user->getFavourites()->paginate(15);
        return view('profil.adverts.favourites', compact('adverts'));   
    }
}
