<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(){
       
        $products = Product::all()->where("active",1)->where('stock','>',0);
        return view("customer.home",["products"=>$products]);
    }

    public function getProduct($id){
        if(isset(auth()->user()->google_id)){
            $userId=auth()->user()->google_id;
            $product=Product::findOrFail($id);
            $userInfo=User::where("google_id",$userId)->first();

            $shippingAddress=Address::where("user_id",$userId)->get();

            return view('customer.product',['product'=>$product,'address'=>$shippingAddress,'userInfo'=> $userInfo]);
        }else{
            $product=Product::findOrFail($id);
            return view('customer.product',['product'=>$product]);
        }
        
    }
}
