<?php

namespace App\Http\Controllers;

use App\Mail\PaymentAccepted;
use App\Models\CartItem;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\PayOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
  public function paypal(Request $request)
  {
    session()->put("address",$request->input('address-paypal-input'));
    
    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $paypalToken = $provider->getAccessToken();
    $response = $provider->createOrder([
      "intent" => "CAPTURE",
      "application_context" => [
        "return_url" => route("success"),
        "cancel_url" => route('cancel')
      ],
      "purchase_units" => [
        [
          "amount" => [
            "currency_code" => "MXN",
            "value" => $request->input('total-paypal')
          ]
        ]
      ]
    ]);
    //dd($response);
    if (isset($response['id']) && $response['id'] != null) {
      foreach ($response['links'] as $link) {
        if ($link['rel'] == 'approve') {
          session()->put('product_name', $request->product_name);
          session()->put('quantity', $request->quantity);
          return redirect()->away($link['href']);
        }
      }
    } else {
      return redirect()->route('customer.home');
    }
  }


  public function success(Request $request)
  {
        $userID=auth()->user()->google_id;
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        if(isset($response['status']) && $response['status'] == 'COMPLETED'){
            
            $order=new Orders();
            $order->users_id=$userID;
            $order->shipping_address=session()->get('address');
            $order->status='Paid';
            $order->save();

            $lastOrder=Orders::latest('id')->first();
            
            $cartItems=CartItem::where('users_id',$userID)->where('status',0)->get();

          
            foreach ($cartItems as $cartItem){
              $product=Product::where('id', $cartItem->products_id)->get();
              
              $productQuantity=$product[0]->stock;
              $newStock=$productQuantity-$cartItem->quantity;

              Product::where('id', $cartItem->products_id)->update(['stock'=>$newStock]);

              $orderItems=new OrderItems();
              $orderItems->order_id=$lastOrder->id;
              $orderItems->cart_item_id=$cartItem->id;
              $orderItems->save();

              CartItem::where('id',$cartItem->id)->update(['status'=>1]);

            }

            $payOrder=new PayOrder();
            $payOrder->total=$response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $payOrder->file='';
            $payOrder->observations='';
            $payOrder->status= 0;
            $payOrder->paypalID=$response['id'];
            $payOrder->orders_id=$lastOrder->id;
            $payOrder->user_id= $userID;
            $payOrder->save();
          
            unset($_SESSION['product_name']);
            unset($_SESSION['address']);
            unset($_SESSION['quantity']);
            $email=User::where('google_id',$userID)->first();
            
            Mail::to($email->email)->send(new PaymentAccepted());
            return redirect('/my-orders/'.$userID);
        } else {
            return redirect()->route('customer.home');
        }
    }
    public function cancel()
    {
      return redirect()->route('customer.home');
  
  }

  public function paypalInidividual(Request $request)
  {
    session()->put("address",$request->input('address-paypal-input'));
    session()->put('productId',$request->input('product-id'));
    session()->put('quantityProd',$request->input('quantity-paypal'));

    $provider = new PayPalClient;
    $provider->setApiCredentials(config('paypal'));
    $paypalToken = $provider->getAccessToken();
    $response = $provider->createOrder([
      "intent" => "CAPTURE",
      "application_context" => [
        "return_url" => route("success-individual"),
        "cancel_url" => route('cancel')
      ],
      "purchase_units" => [
        [
          "amount" => [
            "currency_code" => "MXN",
            "value" => $request->input('total-paypal')
          ]
        ]
      ]
    ]);
    //dd($response);
    if (isset($response['id']) && $response['id'] != null) {
      foreach ($response['links'] as $link) {
        if ($link['rel'] == 'approve') {
          session()->put('product_name', $request->product_name);
          session()->put('quantity', $request->quantity);
          return redirect()->away($link['href']);
        }
      }
    } else {
      return redirect()->route('customer.home');
    }
  }


  public function successIndividual(Request $request)
  {
        $userID=auth()->user()->google_id;
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        // obtener valores de las cookies----------------------------------------

        $idProduct=session()->get('productId');
        $address=session()->get('address');
        $quantityProd=session()->get('quantityProd');

        

        //dd(['id'=>$idProduct,'address;'=>$address, "quant"=>$quantityProd ]);


        if(isset($response['status']) && $response['status'] == 'COMPLETED'){

          //agregar producto al carrito-----------------
            $cartItem=new CartItem();
            $cartItem->users_id=$userID;
            $cartItem->products_id=$idProduct;
            $cartItem->quantity=$quantityProd;
            $cartItem->status=1;
            $cartItem->save();

            //crear una orden----------------------------------------
            $newOrder=new Orders();
            $newOrder->users_id=$userID;
            $newOrder->shipping_address=$address;
            $newOrder->status="Paid";
            $newOrder->save();

            $lastOrder=Orders::latest('id')->first();
            $lastCartItem=CartItem::latest('id')->where('status',1)->where('users_id',$userID)->first();

            $orderItems=new OrderItems();
            $orderItems->order_id=$lastOrder->id;
            $orderItems->cart_item_id=$lastCartItem->id;
            $orderItems->save();


            $payOrder=new PayOrder();
            $payOrder->total=$response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $payOrder->file='';
            $payOrder->observations='';
            $payOrder->status= 0;
            $payOrder->paypalID=$response['id'];
            $payOrder->orders_id=$lastOrder->id;
            $payOrder->user_id= $userID;
            $payOrder->save();

            $product=Product::where('id',$idProduct)->first();
            //dd($product->stock);
            $lastQuantity=$product->stock;
            $newStock=$lastQuantity-$quantityProd;

            Product::where('id',$idProduct)->update(['stock'=>$newStock]);

            unset($_SESSION['productId']);
            unset($_SESSION['address']);
            unset($_SESSION['quantityProd']);
          
            $email=User::where('google_id',$userID)->first();
            
            Mail::to($email->email)->send(new PaymentAccepted());
            return redirect('/my-orders/'.$userID);
        } else {
            return redirect()->route('customer.home');
        }
    }



}
