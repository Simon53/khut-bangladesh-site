<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
   public function store(Request $request){
    $cart = json_decode($request->cart, true);

    if(!$cart || count($cart) === 0){
        return response()->json(['success'=>false, 'message'=>'Cart is empty!']);
    }

    // Calculate subtotal
    $subtotal = 0;
    foreach($cart as $item){
        $subtotal += $item['qty'] * $item['price'];
    }

    // Determine delivery charge
    $delivery = ($request->district == 'Dhaka') ? 80 : 150;

    // Determine order status
    $status = ($request->payment_method == 'cod' && $request->district == 'Dhaka') ? 'pending' : 'paid';

    // ✅ Set delivery status for new orders
    $deliveryStatus = 'pending';

    // Create Order
    $order = Order::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'address'    => $request->address,
        'district'   => $request->district,
        'city'       => $request->city,
        'postcode'   => $request->postcode,
        'notes'      => $request->note ?? null,
        'payment_method' => $request->payment_method,
        'subtotal'   => $subtotal,
        'delivery_charge' => $delivery,
        'total'      => $subtotal + $delivery,
        'status'     => $status,
        'delivery_status' => $deliveryStatus, 
    ]);

    // Insert Order Items
    foreach($cart as $item){
        $order->items()->create([
            'product_id'   => $item['id'] ?? null,
            'product_name' => $item['name'],
            'size'         => $item['size'] ?? null,
            'color'        => $item['color'] ?? null,
            'quantity'     => $item['qty'],
            'price'        => $item['price'],
            'subtotal'     => $item['qty'] * $item['price'],
            'barcode'      => $item['barcode'] ?? null,
        ]);
    }

    return response()->json(['success'=>true, 'message'=>'Order placed successfully!']);
}

}


