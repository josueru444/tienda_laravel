<?php

namespace App\Http\Controllers;

use App\Mail\OrderShipping;
use App\Models\Orders;
use App\Models\PayOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminOrdersController extends Controller
{
    public function showOrders()
    {   try{

    
        if (auth()->user()->google_id == env('ADMIN_ID')) {

            $orders = Orders::all();
            $unpaid = Orders::where('orders.status', 'Processing')->get();
            $paidOrders = Orders::where('status', 'Paid')->get();

            return view("admin.ordersAdmin", ["orders" => $orders, "unpaid" => $unpaid,"paid"=>$paidOrders]);
        } else {
            return view("customer.home");
        }
    }catch (\Exception $e){
        return view("customer.home");
    }
    }
    public function getOrderUnpaidDeatails($OrderId)
    {
        $orderDetail = PayOrder::where('orders_id', $OrderId)->get();
        return view('admin.ordersUnpaid', ["request" => $orderDetail]);
    }

    public function confirmPayment(Request $request)
    {

        try {
            $orderID = $request->idOrder;
            $orderPayID = $request->idPayOrder;
            

            PayOrder::where("id", $orderPayID)->update(['status' => 0]);
            Orders::where('id', $orderID)->update(['status' => 'Paid']);

            return response()->json(['msg' => 'success','data'=>$orderPayID]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function shippingOrder(Request $request){
        try{
            Orders::where('id', $request->idOrder)->update(['status'=> 'Shipped']);
            $idUser=Orders::where('id', $request->idOrder)->first()->users_id;
            $userEmail=User::where('google_id',$idUser)->first()->email;

            Mail::to($userEmail)->send(new OrderShipping());
            return response()->json(['status'=>'success','data'=>$request->idOrder]);
        }catch (\Exception $e) {
            return response()->json(['error'=>$e]);
        }
        
    }

    public function getCustomOrder(Request $request){
        $status=$request->status;
        if($status=='Processing'){
            $unpaidOrder = Orders::where('orders.status',$status )->get();
            return response()->json(['data'=> $unpaidOrder,'status'=>'success']);

        }else if($status=='Paid'){
            $paidOrder=Orders::where('status', $status)->get();
            return response()->json(['data'=> $paidOrder,'status'=>'success']);

        }else if($status=='Shipped'){
            $shippeddOrder=Orders::where('status', $status)->get();
            return response()->json(['data'=> $shippeddOrder,'status'=>'success']);
        }
        else if($status=='Delivered'){
            $deliveredOrder=Orders::where('status', $status)->get();
            return response()->json(['data'=> $deliveredOrder,'status'=>'success']);
        }


        
    }

}
