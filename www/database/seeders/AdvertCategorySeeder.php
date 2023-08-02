<?php

namespace Database\Seeders;

use App\Models\AdvertCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdvertCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $base = file(__DIR__.'/base_advert.csv');
        foreach ($base as $row) {
            $part = str_getcsv(
                $row,
                "~",
                "^"
            );
        $parent = AdvertCategory::where('name', $part[0])->first();
        if (is_null($parent)) {
            $parent = new AdvertCategory();
            $parent = $parent->register($part[0]);
        }
        $child = new AdvertCategory();
        $child->register($part[1], $parent->id);
        }
    }
}
