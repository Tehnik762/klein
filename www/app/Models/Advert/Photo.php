<?php

namespace App\Models\Advert;

use App\Models\Advert;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $table = 'advert_photos';
    protected $fillable = ['file', 'advert_id', 'storage_path'];

   public function advert() {
    return $this->belongsTo(Advert::class, 'advert_id', 'id');
   }
}
