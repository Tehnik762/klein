<?php

namespace App\Models;

use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertAttributes extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'required', 'variants', 'sort', 'advert_category_id'];
    protected $casts = [
        'variants' => 'array',
    ];

    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_FLOAT = 'float';
    
    public static function typesList(): array
    {
        return [
            self::TYPE_STRING => 'String',
            self::TYPE_INTEGER => 'Integer',
            self::TYPE_FLOAT => 'Float',
        ];
    }

    public static function typesArray(): array
    {
        return [
            self::TYPE_STRING,
            self::TYPE_INTEGER,
            self::TYPE_FLOAT,
        ];
    }

    public function isString(): bool
    {
        return $this->type === self::TYPE_STRING;
    }

    public function isInteger(): bool
    {
        return $this->type === self::TYPE_INTEGER;
    }

    public function isFloat(): bool
    {
        return $this->type === self::TYPE_FLOAT;
    }

    public function isNumber(): bool
    {
        return $this->isInteger() || $this->isFloat();
    }

    public function isSelect(): bool
    {   
        if (is_null($this->variants)) {
            return false;
        } 
        return \count($this->variants) > 1;
    }


}
