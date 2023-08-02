<?php

namespace Database\Seeders;

use App\Models\Regions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
 

class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
  

        $base = file(__DIR__.'/germany.csv');
        foreach ($base as $row) {
            $part = str_getcsv(
                $row,
                "~",
                "^"
            );
            if (!isset($res[$part[3]])) // Land name
            {
                $res[$part[3]]['code'] = $part[4];
                $res[$part[3]]['kreis'] = [];
            }

            if (!isset($res[$part[3]]['kreis'][$part[5]])) // Kreis name
            {
                $res[$part[3]]['kreis'][$part[5]]['code'] = $part[2];
                $res[$part[3]]['kreis'][$part[5]]['stadt'] = [];
            }
            $res[$part[3]]['kreis'][$part[5]]['stadt'][] =[
                'plz' => $part[0],
                'name'  => $part[1],
            ];
            
        }

        foreach ($res as $land => $value) {
            $main_land = new Regions();
            $main_land = $main_land->register($land, $value['code']);
            foreach ($value['kreis'] as $kreis => $kreis_arr) {
                $main_kreis = new Regions();
                $main_kreis = $main_kreis->register($kreis, $kreis_arr['code']);
                $main_kreis->parent()->associate($main_land);
                $main_kreis->save();
                foreach ($kreis_arr['stadt'] as $city) {
                    if (!Regions::where('name', $city['name'])->first()) {
                        $stadt = new Regions();
                        $stadt = $stadt->register($city['name'], $city['plz']);
                        $stadt->parent()->associate($main_kreis);
                        $stadt->save();
                    }
                    
                }
            }
        }

    }
}


/*

['Land']['Kreis']['Stadt'] = PLZ

*/