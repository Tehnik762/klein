<?php

namespace Database\Seeders;

use App\Models\AdvertAttributes;
use App\Models\AdvertCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $base = file(__DIR__.'/base_attributes.csv');
        foreach ($base as $row) {
            $part = str_getcsv(
                $row,
                "~",
                "^"
            );
            
            $part[4] = explode(",", $part[4]);
            $part[4] = array_map(function ($i) {
                return trim($i);
            }, $part[4]);

            $parent = AdvertCategory::whereName($part[0])->first();
            $attr = new AdvertAttributes([
                'name' => $part[1],
                'type' => $part[2],
                'required' => $part[3],
                'variants' => $part[4],
                'sort' => $part[5]
            ]);

            $parent->attributes()->save($attr);
        }
    }
}
