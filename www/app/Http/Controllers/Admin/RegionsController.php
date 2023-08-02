<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regions;
use Illuminate\Http\Request;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = Regions::where('parent_id', NULL)->orderBy('name', 'asc')->get();
        $regions_active = TRUE;
        return view('admin.regions.index', compact('regions', 'regions_active'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Regions  $regions
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $main = Regions::where('id', $id)->first();

        $regions = Regions::where('parent_id', $id)->orderBy('name', 'asc')->get()->all();
        $count = count($regions);
        $regions_active = TRUE;
        return view('admin.regions.index', compact('regions', 'count', 'main', 'regions_active'));
    }


}
