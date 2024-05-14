<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    public function index(){
        return view("admin.map");
    }

    public function addLocation(Request $request){
        try{
            $location = new Location();
            $location->name = $request->name;
            $location->latitude = $request->latitude;
            $location->longitude = $request->longitude;
            $location->save();
            
            return response()->json(['status'=>'success']);
        }catch(\Exception $e){
            return response()->json(['error'=>$e]);
        }
    }
    public function getMaps(){

    return view('customer.mapaStore');
    }

    public function getDBMaps(){
        $locations=Location::all();
        return response()->json(['locations'=> $locations]);
    }
}
