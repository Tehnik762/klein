<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advert;

class SearchController extends Controller
{
    public function search(Request $request)
    {
            $search = $request->search;
            $adverts = Advert::search($search)->where("status", Advert::STATUS_ACTIVE)->paginate(20)->withQueryString();
         
       

        return view('search', compact('adverts', 'search'));
    }


}
