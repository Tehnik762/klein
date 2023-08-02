<?php
namespace App\Service;


use App\Models\Regions;
use Illuminate\Http\Request;

class GetCategories {

    public function give($id) {
        $id == 0 ? $id = NULL : '';
        return Regions::where("parent_id", $id)->orderBy('name')->select(["name", "id"])->get()->toArray();
    }

}