<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function get() {
        $location = DB::table('locations')->where('id','=',1)->first();

        return response()->json([
            'lat' => $location->lat,
            'long'=>$location->long,
        ]);
    }
}
