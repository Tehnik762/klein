<?php

namespace App\Service\Adverts;

use App\Http\Requests\Adverts\AttributesRequest;
use App\Http\Requests\Adverts\CreateRequest;
use App\Http\Requests\Adverts\PhotoRequest;
use App\Http\Requests\Adverts\RejectRequest;
use App\Http\Requests\Adverts\UpdateInfoRequest;
use App\Models\Advert;
use App\Models\Advert\Photo;
use App\Models\AdvertCategory;
use App\Models\Regions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SebastianBergmann\CodeCoverage\Report\PHP;
use Illuminate\Support\Str;

class AdvertsService
{

    public function create($userId, $categoryId, $regionId, CreateRequest $request): Advert
    {

        /** @var User $user */
        $user = User::findOrFail($userId);
        /** @var Region $region */
        $region = $regionId ? Regions::findOrFail($regionId) : null;
        /** @var AdvertCategory $category */
        $category = AdvertCategory::findOrFail($categoryId);


        return DB::transaction(function () use ($request, $user, $region, $category) {
            /** @var Advert $advert */
            $advert = Advert::make([
                'title' => $request['title'],
                'content' => $request['content'],
                'address' => $request['address'],
                'price' => $request['price'],
                'status' => Advert::STATUS_DRAFT,
                'slug' => Str::slug($request['slug']),
            ]);
            $advert->user()->associate($user);
            $advert->region()->associate($region);
            $advert->category()->associate($category);

            $advert->saveOrFail();

            foreach ($category->allAttributes() as $attribute) {
                $value = $request['attribute'][$attribute->id] ?? null;
                if (!empty($value)) {
                    $advert->values()->create([
                        'attribute_id' => $attribute->id,
                        'value' => $value
                    ]);
                }
            }
            $advert->save();
            return $advert;
        });
    }

    public function addPhotos($id, PhotoRequest $request)
    {
        $advert = $this->getAdvert($id);

        DB::transaction(function () use ($advert, $request, $id) {
            Storage::makeDirectory('public/content/' . $id);
            foreach ($request['file'] as $file) {

                $public_path = $file->store('public/content/' . $id);
                $storage_path = storage_path('app/' . $public_path);
                $public_path = str_replace("public", "storage", $public_path);
                $advert->photos()->create([
                    'file' => $public_path,
                    'storage_path' => $storage_path
                ]);
            }
        });
    }

    public function sendtoModeration($id)
    {
        $advert = $this->getAdvert($id);
        $advert->sendtoModeration();
    }

    public function getAdvert($id): Advert
    {
        return Advert::findOrFail($id);
    }

    public function approveAdvert($id)
    {
        $advert = $this->getAdvert($id);
        $advert->approveAdvert(Carbon::now());
        // Here you can insert any additional logic
    }

    public function reject($id, RejectRequest $request)
    {
        $advert = $this->getAdvert($id);
        $advert->reject($request['reason']);
        // Here you can insert any additional logic
    }

    public function editAttributes($id, AttributesRequest $request)
    {
        $advert = $this->getAdvert($id);

        DB::transaction(function () use ($advert,  $request) {
            $advert->values()->delete();

            foreach ($advert->category->allAttributes() as $attribute) {
                $value = $request['attributes'][$attribute->id] ?? null;
                if (!empty($value)) {
                    $advert->values()->create([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                    ]);
                }
            }
        });
    }

    public function remove($id)
    {
        $advert = $this->getAdvert($id);
        $advert->delete();
    }

    public function getAdverts($user, $request)
    {
        if (Gate::allows("moderate")) {
            $query = Advert::orderBy('updated_at', 'DESC');

            if (!empty($value = $request->get('name'))) {
                $author = User::where('name', $value)->first();
                if (isset($author)) {
                    $query->where('user_id', $author->id);
                }
                }
                

            if (!empty($value = $request->get('status'))) {
                $query->where('status', $value);
            }

            if (!empty($value = $request->get('region'))) {
                $region = Regions::find($value);
                $query->ForRegion($region);
            }

            if (!empty($value = $request->get('category'))) {
                $category = AdvertCategory::find($value);
                $query->ForCategory($category);
            }

            return $query->paginate();
        } else {
            return Advert::where('user_id', $user->id)->paginate();
        }
    }

    public function deletePhoto($id)
    {
        /** @var Photo $photo */
        $photo = Photo::find($id);
        /** @var User $user */
        $user = Auth::user();

        if (Gate::allows("moderate") or $photo->advert->user_id == $user->id) {
            // Delete photo
            unlink($photo->storage_path);
            // Delete DB
            $photo->delete();
        } else {
            return back()->with('error', __('admin.fail'));
        }
    }

    public function updateInfo(UpdateInfoRequest $request, User $user, Advert $advert)
    {

        if (Gate::allows("moderate") or $advert->user_id == $user->id) {
            $advert->title = $request['title'];
            $advert->content = $request['content'];
            $advert->price = $request['price'];
            $advert->address = $request['address'];
            $advert->save();
        } else {
            return back()->with('error', __('admin.fail'));
        }
    }

    public function deactivate($id)
    {
        $advert = $this->getAdvert($id);
        /** @var User $user */
        $user = Auth::user();
        if (Gate::allows("moderate") or $advert->user_id == $user->id) {
            $advert->deactivate();
        }
    }


    /**
     * @param Advert $advert
     * 
     * @return void
     */
    public function expire(Advert $advert): void
    {
        $advert->expire();
        echo $advert->title . PHP_EOL;
    }
}
