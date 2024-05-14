<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProductsController extends Controller
{
    public function inserProduct(Request $request)
    {
        try{
            $nameProd= $request->input("name");
            $img= $request->input("img");
            $desc= $request->input("desc");
            $price= $request->input("price");
            $stock=$request->input("stock");

            Product::create(['name'=>$nameProd,'img'=> $img,'description'=>$desc,'price'=>$price,'stock'=>$stock,'active'=>1]);
            
            return response()->json(['status'=>'success']);

        }catch(\Exception $e){
            return response()->json(['error'=>$e]);
        }
    }
    public function showProducts()
    {   try{
        if (auth()->user()->google_id == env('ADMIN_ID')) {

            $products = Product::all();

            return view("admin.products", ["products" => $products]);
        } else {
            return view("customer.home");
        }
    }catch(\Exception $e){
        if($e->getCode() == 0){
            return redirect("/");
        }
    }
    }
        
    
    public function getSpecificProduct(Request $request)
    {
        if (auth()->user()->google_id == env("ADMIN_ID")) {
            $idProduct = $request->idProd;
            $product = Product::find($idProduct);

            return response()->json(['data', $product]);
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $idProduct = $request->id;
            $nameProd = $request->name;
            $img = $request->img;
            $desc = $request->desc;
            $price = $request->price;
            $stock = $request->stock;

            Product::where('id', $idProduct)->update([
                'name' => $nameProd,
                'img' => $img, 'description' => $desc, 'price' => $price, 'stock' => $stock
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['Error:' => $e]);
        }
    }

    public function deleteProduct(Request $request)
    {
        try {

            Product::where('id', $request->idProd)->update(['active' => 0]);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }
}
