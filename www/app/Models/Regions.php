<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;


class Regions extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, "parent_id", "id");
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, "parent_id", "id");
    }

    public function register($name, $code) {
        $slug = Str::slug($name."-".$code, "-");
        return self::create([
            'name' => $name,
            'code' => $code,
            'slug' => $slug
        ]);
    }

    public function getPlz() {
        return $this->code.", ".$this->name;
    }

    public function AllChildren() {
        
            $kids = $this->children()->get();
 
            $res = $kids;
            foreach ($kids as $one) {
                if ($one->has('children')) {
                    $res = $res->merge($one->AllChildren());
                }
            }
        
        return $res;
    }


    
    public function getPath(): string
    {
        return ($this->parent ? $this->parent->getPath() . '/' : '') . $this->slug;
    }
   
}
