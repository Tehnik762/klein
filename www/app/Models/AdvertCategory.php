<?php

namespace App\Models;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Str;

class AdvertCategory extends Model
{
    use HasFactory;
    use NodeTrait;

    protected $fillable = ['name', 'slug', 'parent_id'];

    public function register($name, $parent_id=NULL) {
        $slug = Str::slug($name, "-");
        $cat = self::create([
            'name' => $name,
            'slug' => $slug
        ]);
        if (!is_null($parent_id)) {
            $cat->parent_id = $parent_id;
            $cat->save();
        }
        return $cat;
    }

    public function change($id, $name, $slug, $parent_id) {
        $cat = self::find($id);
        $cat->name = $name;
        $cat->slug = $slug;
        $cat->parent_id = $parent_id;
        $cat->save();
        return $cat;
    }

    public function attributes() {
        return $this->hasMany(AdvertAttributes::class);
    }

    public function allAttributes() {
        $own = $this->attributes()->orderBy('sort')->get();
        $parent = $this->parent ? $this->parent->allAttributes() : "";
        if (is_string($parent)) {
            return $own;
        } else {
            return $parent->merge($own);
        }
        
    }

    public function getPath(): string
    {
        return implode('/', array_merge($this->ancestors()->defaultOrder()->pluck('slug')->toArray(), [$this->slug]));
    }

    public function descIds() {
        $desc = $this->descendants->pluck('id')->toArray();
        $desc[] = $this->id;        
        return $desc;

    }

}
