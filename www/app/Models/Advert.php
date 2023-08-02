<?php

namespace App\Models;

use App\Models\Advert\Photo;
use App\Models\Advert\Value;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;
use Typesense\LaravelTypesense\Interfaces\TypesenseDocument;

/**
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property int $region_id
 * @property string $title
 * @property string $content
 * @property int $price
 * @property string $address
 * @property string $status
 * @property string $reject_reason
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $published_at
 * @property Carbon $expires_at
 * */

class Advert extends Model implements TypesenseDocument
{
    use HasFactory, Searchable;

    public const STATUS_DRAFT = 1;
    public const STATUS_MODERATION = 2;
    public const STATUS_ACTIVE = 3;
    public const STATUS_CLOSED = 4;

    public const EXPIRE_PERIOD = 30; // Days

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * @return Array 
     */
    public static function statusList()
    {
        return [
            self::STATUS_DRAFT => __('advert.draft'),
            self::STATUS_MODERATION => __('advert.moderation'),
            self::STATUS_ACTIVE => __('advert.active'),
            self::STATUS_CLOSED => __('advert.closed'),
        ];
    }

    public function statusName()
    {
        return self::statusList()[$this->status];
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isOnModeration()
    {
        return $this->status == self::STATUS_MODERATION;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(AdvertCategory::class, 'category_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo(Regions::class, 'region_id', 'id');
    }

    public function values()
    {
        return $this->hasMany(Value::class, 'advert_id', 'id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'advert_id', 'id');
    }

    public function sendToModeration(): void
    {
        if (!$this->isDraft()) {
            throw new \DomainException(__('advert.alreadymoderated'));
        }
        if (!$this->photos()->count()) {
            throw new \DomainException(__('advert.alertphotos'));
        }


        $this->update([
            'status' => self::STATUS_MODERATION,
        ]);
    }

    public function approveAdvert(Carbon $time): void
    {
        if ($this->status != self::STATUS_MODERATION) {
            throw new \DomainException(__('advert.notmoderation'));
        }

        $this->update([
            'status' => self::STATUS_ACTIVE,
            'published_at' => $time,
            'expires_at' => $time->copy()->addDays(self::EXPIRE_PERIOD),
        ]);
    }

    public function reject($reason): void
    {
        $this->update([
            'status' => self::STATUS_DRAFT,
            'reject_reason' => $reason,
        ]);
    }

    public function deactivate(): void
    {
        $this->update([
            'status' => self::STATUS_DRAFT,
        ]);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', '=', self::STATUS_ACTIVE);
    }

    public function scopeRegion(Builder $query, $id): void
    {
        $query->where('region_id', '=', $id);
    }

    /**
     * @param Builder $query
     * @param Regions $region
     * 
     * @return [type]
     */
    public function scopeForRegion(Builder $query, Regions $region)
    {
        $ids = [$region->id];
        $childrenIds = $ids;
        while ($childrenIds = Regions::whereIn('parent_id', $childrenIds)->pluck('id')->toArray()) {
            $ids = array_merge($ids, $childrenIds);
        }

        $res = array_chunk($ids, 100);
        $result = $query->whereIn('region_id', $res[0]);
        foreach ($res as $piece) {
            $result = $result->orWhereIn('region_id', $piece);
        }

        return $result;
    }

    /**
     * @param Builder $query
     * @param AdvertCategory $category
     * 
     * @return [type]
     */
    public function scopeForCategory(Builder $query, AdvertCategory $category)
    {
        return $query->whereIn('category_id', array_merge(
            [$category->id],
            $category->descendants()->pluck('id')->toArray()
        ));
    }


    public function expire()
    {
        $this->update([
            'status' => self::STATUS_CLOSED,
        ]);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getRouteKey()
    {
        return $this->slug;
    }

    public function makeFavourite($user_id)
    {
        $this->favourite()->toggle($user_id);
    }

    public function isFavourite($user_id)
    {
        return (count($this->belongsToMany(User::class, 'favorites_advert', "advert_id", "user_id")
            ->wherePivot('user_id', $user_id)
            ->get()) != 0);
    }

    public function favourite()
    {
        return $this->belongsToMany(User::class, 'favorites_advert', "advert_id", "user_id");
    }

    public function countFavourite()
    {
        return count($this->favourite()->get());
    }


    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $array = [
            'id' => strval($this->id), 
            'category_id' => $this->category_id,
            'region_id' => $this->region_id,
            'title' => $this->title, 
            'content' => $this->content,
            'status' => $this->status,
            'created_at' => $this->created_at->timestamp];
        
        return $array;
    }

    /**
     * The Typesense schema to be created.
     *
     * @return array
     */
    public function getCollectionSchema(): array {
        return [
            'name' => $this->searchableAs(),
            'fields' => [
                [
                    'name' => 'id',
                    'type' => 'int32',
                ],
                [
                    'name' => 'title',
                    'type' => 'string',
                ],
                [
                    'name' => 'category_id',
                    'type' => 'int32',
                    'facet' => true,
                ],
                [
                    'name' => 'region_id',
                    'type' => 'int32',
                    'facet' => true,
                ],
                [
                    'name' => 'content',
                    'type' => 'string',
                ],
                [
                    'name' => 'status',
                    'type' => 'int32',
                ],
                [
                    'name' => 'created_at',
                    'type' => 'int64',
                ],

            ],
            'default_sorting_field' => 'created_at',
        ];
    }

     /**
     * The fields to be queried against. See https://typesense.org/docs/0.24.0/api/search.html.
     *
     * @return array
     */
    public function typesenseQueryBy(): array {
        return [
            'title', 'content'
        ];
    }    


}
