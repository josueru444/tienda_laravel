<?php
use App\Http\Controllers\CartItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/add-cart/',function (Request $request){
    
    return json_encode(compact('s'));
});
