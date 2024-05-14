<?php

namespace App\Http\Controllers;

use App\Mail\PaymentAccepted;
use App\Models\Orders;
use App\Models\PayOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PayOrderController extends Controller
{
    public function addOrderPayment(Request $request){
          try{
            $request->validate([
                'file' => 'required|file|mimes:jpeg,png,pdf|max:2048', 
            ]);
            $base64File = base64_encode(file_get_contents($request->file('file')));
    
            $idOrder = $request->input('idOrder');
            $totalOrder = $request->input('TotalOrder');
    
            //guardar pago
            Orders::where('id', $idOrder)->update(['status'=>'Processing']);
            
            $payment= new PayOrder();
            $payment->total = $totalOrder;
            $payment->file=$base64File;
            $payment->observations='';
            $payment->orders_id=$idOrder;
            $payment->user_id=auth()->user()->google_id;
            $payment->save();
            
            $email=User::where('google_id',auth()->user()->google_id)->first();
            Mail::to($email->email)->send(new PaymentAccepted());

            
            return response()->json(['status'=> 'success']);
          }catch(\Exception $e){
            return response()->json(['error'=> $e]);
          }
          
        
    }
    
}
