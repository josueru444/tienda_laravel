<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Http\Controllers\AddressController;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function index($userId)
    {
        
        $addresssController=new AddressController();
        $address= $addresssController->getAdress();

        $cartItems = Product::join('cart_items','products.id','=','cart_items.products_id')
        ->select('products.*', 'cart_items.quantity', 'cart_items.id as cartID')->where('cart_items.users_id', $userId)
        ->where('cart_items.status','=',0)
        ->get();
        $total_cart=0;
        foreach( $cartItems as $cartItem ){
            $price= $cartItem->price;
            $quantity= $cartItem->quantity;

            $total=$price*$quantity;
            $cartItem->total=$total;
            $total_cart+=$total;
            $cartItems->total= $total_cart;
        }
        
        
        return view('customer.cart', ['cartItems'=>$cartItems,'addresses'=>$address]);
    }

    public function addCartItem(Request $request){
        try{
            $id_user=auth()->user()->google_id;
            if(isset($id_user)){
            $id_product=$request->id_prod;
            $quantity=$request->quantity;

            $cartItem=CartItem::where('users_id',$id_user)->where('products_id', $id_product)->where('status',0)->first();
            if($cartItem){
                $cartItem->quantity += $quantity;
                $cartItem->save();
            }else{
                $cart=new CartItem();
                $cart->users_id=$id_user;
                $cart->products_id=$request->id_prod;
                $cart->quantity=$request->quantity;
                $cart->save();
            }
            return json_encode(['msg'=>'Carrito Agregado']);
        }else{
            return json_encode(['msg'=>'empty']);
        }
            
        }catch(Exception $e){
            return json_encode(['error'=>$e]);
        }
        
    }

    public function addCartItemShopping($idProduct){
        $productInfo=Product::where('id',$idProduct)->get();
        
        return view('customer.shoppingProduct',['cartItems'=>$productInfo]);
    }


    public function updateCart(Request $request){
        try{
            $quantity=$request->quantity;
            $product=Product::where('id',$request->idProd)->get();
            $maxQuantity=$product[0]->stock;
            
            if($quantity > 1 && $quantity <= $maxQuantity){
                CartItem::where('id',$request->id)->update(['quantity'=>($quantity <=1 ? 1 : $quantity)]);
                return response()->json(['msg'=>'success']);
            }else{
                return response()->json(['msg'=> 'none']);
            }
            
        }catch(Exception $e){
            return response()->json(['error'=>$e]);
        }
    }

    public function deleteCartItem(Request $request){
        try{
            $id_user=auth()->user()->google_id;
            CartItem::where('products_id',$request->idProduct)->where('users_id',$id_user)->where('status',0)->update(['status'=> 3]);
            return response()->json(['status'=> 'success']);
        }catch(Exception $e){
            return response()->json(['error'=>$e]);
        }
        
    }
}
