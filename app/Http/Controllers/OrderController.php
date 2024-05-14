<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception; // Importar la clase Exception

use function Laravel\Prompts\select;

class OrderController extends Controller
{
    public function addOrderUnpaid(Request $request)
    {
        $userId = auth()->user()->id;
        try {

            $userId = auth()->user()->google_id;
            $address = $request->input("address");
            

            $items = CartItem::where('users_id', $userId)->where('status', 0)->get();
            // cambiar el status a 1

            CartItem::where('status', 0)->where('users_id', $userId)->update(['status' => 1]);

            $order = new Orders();
            $order->users_id = $userId;
            $order->shipping_address = $address;
            $order->status = 'Unpaid';
            $order->save();

            $lastOrder = Orders::latest()->where('users_id', $userId)->where('status', 'Unpaid')->get();
            $newStock = 0;
            foreach ($items as $item) {
                $orderItems = new OrderItems();
                $orderItems->order_id = $lastOrder[0]->id;
                $orderItems->cart_item_id = $item->id;
                $orderItems->save();

                $product = Product::find($item->products_id);
                if ($product) {
                    $newStock = $product->stock - $item->quantity;
                    $product->stock = $newStock;
                    $product->save();
                }
            }
            return response()->json(["status" => "success","red"=>$userId]);
        } catch (Exception $e) {
            // Capturar cualquier excepción y retornar un error
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function getOrders(Request $request)
    {
        $userId = $request->user;
        if ($userId == auth()->user()->google_id) {

            $orders = Orders::where("users_id", $userId)->where('status', '!=', 'Delivered')->where('status', '!=', 'Cancelled')->where('status', '!=', 'Unpaid')->where('users_id',$userId)->orderByDesc('id')->get();
            $numberOfUnpaidOrders = count($orders);

            return response()->json(['status' => 'success', 'orders' => $orders, 'long' => $numberOfUnpaidOrders]);
        } else {
            return response()->json(['status' => 'denied']);
        }
    }

    public function getOrdersUnpaid(Request $request)
    {
        $userId = $request->user;
        if ($userId == auth()->user()->google_id) {

            $orders = Orders::where('status', '=', 'Unpaid')->where('users_id',$userId)->orderByDesc('id')->get();
            $numberOfUnpaidOrders = count($orders);

            return response()->json(['status' => 'success', 'orders' => $orders, 'long' => $numberOfUnpaidOrders]);
        } else {
            return response()->json(['status' => 'denied']);
        }
    }

    public function getOrdersDelivered(Request $request)
    {
        $userId = $request->user;
        if ($userId == auth()->user()->google_id) {

            $orders = Orders::where('status', '=', 'Delivered')->where('users_id',$userId)->orderByDesc('id')->get();
            $numberOfUnpaidOrders = count($orders);

            return response()->json(['status' => 'success', 'orders' => $orders, 'long' => $numberOfUnpaidOrders]);
        } else {
            return response()->json(['status' => 'denied']);
        }
    }

    public function orderDetails($orderId)
    {
        $userId = auth()->user()->google_id;

        $details = Orders::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('cart_items', 'order_items.cart_item_id', '=', 'cart_items.id')
            ->join('products', 'cart_items.products_id', '=', 'products.id')
            ->where('orders.users_id', $userId)
            ->where('orders.id', $orderId)
            ->where('orders.status','!=','Cancelled') // Excluir el estado 'Cancelled'
            ->select('orders.id as order_id', 'orders.shipping_address', 'orders.status', 'orders.created_at', 'products.img', 'products.name', 'products.price', 'cart_items.quantity', 'products.id')
            ->get();

        $total = 0;
        
            return view('customer.orderDetails', ['details' => $details, 'total' => $total]);
        
        
    }

    public function cancelOrder(Request $request)
    {
        try {
            $data = $request->json()->all();
            $stock = '';

            if (isset($data['order'])) {
                $cancelledProducts = $data['order'];
                foreach ($cancelledProducts as $product) {
                    $productID = $product['id'];
                    $quantity = $product['quantity'];
                    $orderID = $product['orderId'];

                    //cambia el estado a cancelado

                    Orders::where('id', $orderID)->update(['status' => 'Cancelled']);

                    $stock = Product::where('id', $productID)->select('stock')->get();
                    $oldStock = $stock[0]->stock;

                    $newStock = $oldStock + $quantity;

                    Product::where('id', $productID)->update(['stock' => $newStock]);
                }
            }

            return response()->json(["status" => "success"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }

    public function confirmDelivered(Request $request)
    {
        try {
            $idOrder = $request->input('id_order');
            Orders::where('id', $idOrder)->update(['status' => 'Delivered']);
            return response()->json(["status" => "success"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e]);
        }
    }
}
