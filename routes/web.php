<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminOrdersController;
use App\Http\Controllers\AdminProductsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PayOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaypalController;
use App\Models\User;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

//google login

Route::get('/login', function () {
    return view('customer.login');
})->name('login');

Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
Route::get('/google-auth/callback', function () {
    try {
        $user_google = Socialite::driver('google')->user();
        $user = User::updateOrCreate(
            ['google_id' => $user_google->id],
            [
                'google_id' => $user_google->id,
                'name' => $user_google->name,
                'email' => $user_google->email,
                'avatar' => $user_google->avatar,
                'external_auth'=>'google'
            ]
        );
        Auth::login($user);
        session_start();
        $_SESSION['username'] = $user_google->name;
        if ($user_google->id == env('ADMIN_ID')) {
            return redirect('admin-panel/');
        }
        return redirect('/');
    } catch (\Exception $e) {
        dd($e->getMessage());
    }
});
//

//Facebook

Route::get('/facebook-auth/redirect', [AuthController::class, 'redirect'])->name('auth.redirect');


Route::get('/facebook-auth/callback', [AuthController::class, 'callback'])->name('auth.callbak');
//https://tienda-josue-ruiz-production.up.railway.app/facebook-auth/callback
//logout

Route::get('logout/', [LogoutController::class, 'logout'])->name('logout');

// products
Route::get('/', [ProductController::class, 'index'])->name('customer.home');
Route::get('/product/{id}', [ProductController::class, 'getProduct'])->name('customer.product');

// cart
Route::get('/cart/{userId}', [CartItemController::class, 'index'])->name('customer.cart')->middleware('auth', 'verified');
Route::post('/add-cart/', [CartItemController::class, 'addCartItem']);

Route::get('add-cart-to-pay/{idProduct}', [CartItemController::class, 'addCartItemShopping']);

Route::post('update-cart-quantity/', [CartItemController::class,'updateCart']);
Route::post('delete-cartItem/', [CartItemController::class,'deleteCartItem']);

//Orders
Route::post('add-order/unpaid', [OrderController::class, 'addOrderUnpaid'])->name('add-order');
Route::post('get-my-orders/', [OrderController::class, 'getOrders'])->name('get-my-orders');
Route::post('get-my-orders-unpaid/', [OrderController::class, 'getOrdersUnpaid']);
Route::post('get-my-orders-delivered/', [OrderController::class, 'getOrdersDelivered']);

Route::get('my-orders/{userId}', function () {
    return view('customer.orders');
})->name('my-orders')->middleware('auth', 'verified');

Route::get('/order-details/{orderId}', [OrderController::class, 'orderDetails'])->name('orderDetails');

Route::post('cancel-order/', [OrderController::class, 'cancelOrder'])->name('cancel-order');
Route::post('confirm-delivered-order', [OrderController::class,'confirmDelivered']);

//addresses
Route::post('add-address/', [AddressController::class, 'insertAddress']);

/* Payments*/
Route::post('paypal/', [PaypalController::class, 'paypal'])->name('paypal');
Route::post('paypal-individual/', [PaypalController::class, 'paypalInidividual'])->name('paypal-individual');

Route::get('success/', [PaypalController::class, 'success'])->name('success');
Route::get('success-individual/', [PaypalController::class, 'successIndividual'])->name('success-individual');

Route::get('cancel/', [PaypalController::class, 'cancel'])->name('cancel');

// Manual Payments
Route::post('send-payment/', [PayOrderController::class, 'addOrderPayment'])->name('add-manual-payment');

//URL admin
Route::get('admin-panel/', [AdminProductsController::class, 'showProducts'])->name('index-admin');
Route::post('insert-product/', [AdminProductsController::class, 'inserProduct']);
Route::post('get-specific-product/', [AdminProductsController::class, 'getSpecificProduct']);
Route::post('update-product/', [AdminProductsController::class, 'updateProduct']);
Route::post('delete-specific-product/', [AdminProductsController::class, 'deleteProduct']);

// orders Admin
Route::get('admin-orders/', [AdminOrdersController::class, 'showOrders'])->name('orders-admin');
Route::get('orders-unpaid/{orderId}', [AdminOrdersController::class, 'getOrderUnpaidDeatails']);
Route::post('confirm-payment/', [AdminOrdersController::class, 'confirmPayment']);
Route::post('shipping-Order/', [AdminOrdersController::class, 'shippingOrder']);
Route::post('get-custom-orders/', [AdminOrdersController::class, 'getCustomOrder']);



//MAIL
Route::post ('/send-mail',[MailController::class,'maildata'])->name('send_mail');

//maps
Route::get('view-form-location/',[LocationsController::class,'index'])->name('view-admin-map');
Route::post('add-location/',[LocationsController::class,'addLocation']);

Route::get('get-map-store/',[LocationsController::class,'getMaps'])->name('customers-map');
Route::GET('get-map-db/',[LocationsController::class,'getDBMaps']);

//Reviews 
Route::get('reviews/',function(){
    return view('customer.reviews');
})->name('reviews');