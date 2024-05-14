<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class AddressController extends Controller
{
    
    public function getAdress(){
        $user_id = auth()->user()->google_id;
        $addresses = Address::where('user_id', $user_id)->get();
        return $addresses;
    }
    public function insertAddress(Request $request)
    {
        try {
            $user_name = $request->user_name;
            $user_address = $request->address;
            $user_zip = $request->zip_code;  
            $user_id = auth()->user()->google_id;

            $address = new Address();
            $address->user_name = $user_name;
            $address->address = $user_address;
            $address->zip_code = $user_zip;
            $address->user_id = $user_id;
            $address->save();
            return response()->json(["status" => "ok"]);
        } catch (\Exception $e) {
            // En caso de que ocurra una excepción, manejarla aquí
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}
