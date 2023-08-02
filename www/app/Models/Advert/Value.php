<?php

namespace App\Models\Advert;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Value extends Model
{
    protected $table = 'advert_attributes_values';
    protected $fillable = ['value', 'attribute_id'];
}
