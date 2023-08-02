<?php

namespace Database\Seeders;

use App\Models\Advert;
use App\Models\AdvertAttributes;
use App\Models\AdvertCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AdvertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Clean demo

        $dir = "/var/www/storage/app/public/content/demo";
        $demo_files = scandir($dir);
        foreach ($demo_files as $file) {
            if ($file != '.' AND $file != '..') {
                unlink($dir.DIRECTORY_SEPARATOR.$file);
            }
        }
        

        Advert::factory(100)->create()->each(function (Advert $advert) {
            //Attributes
            $category = AdvertCategory::find($advert->category_id);

            $attributes = $category->allAttributes();
            foreach ($attributes as $attribute) {
                /** @var AdvertAttributes $attribute */
                if ($attribute->isSelect()) {
                    $size = $attribute->variants;
                    $size_q = count($size)-1;
                    $value = $size[rand(0, $size_q)];
                } elseif ($attribute->isString()) {
                    $value = fake()->word();
                } else {
                    $value = rand(1, 1000);
                }
                $advert->values()->create([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
            //Photos

            $number = rand(1, 5);

            for ($i = 0; $i < $number; $i++) {
                $faker = \Faker\Factory::create();
                $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));
                $filePath= $faker->image($dir = "/var/www/storage/app/public/content/demo", $width = 800, $height = 600);

            
                $advert->photos()->create([
                    'file' => "storage/content/demo/".basename($filePath),
                    'storage_path' => $filePath
                ]);
            }
        });
    }
}
