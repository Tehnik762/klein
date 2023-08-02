<?php

namespace App\Service;

use Illuminate\Support\Facades\Session;

Class MiscService {

    public static function makeToken($length = 5) {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function locale($locale) {
        Session::put('locale', $locale);
        return redirect()->back();
    }
}