<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $order = new Order;
        $order->customer = $request->customer;
        $order->payed = $request->payed;
        $order->save();
        return response()->json($order);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return response()->json($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->customer = $request->customer;
        $order->payed = $request->payed;
        $order->save();
        return response()->json($order);
    }
    public function addproducttoorder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
		$data = $request->json()->all();
        $product_id = $data['product_id']; 
      
	try{
        if($order->payed=="no"){			
			$order->product_id = $product_id;
			$order->save();
			return response()->json("Product is successfully attached to the order");
		}else
		{
			return response()->json("The order is already paid");
		}
	}catch(Exception $e){
		return response()->json("Some errors  occured ".$e->getMessage());
    }
	}
	    public function payorder(Request $request, $orderid)
    { 
	    
		$order_id=$orderid;
		$params=[
			'order_id' => (int) $order_id,
			'customer_email' => 'johndoe@example.com',
			'value' => 33.4
		];
		
		
		$response = Http::post('https://superpay.view.agentur-loop.com/pay', $params);

		 $status = $response->status();
		 $body = $response->body();
		 $data = $response->json();
		 if($status == 200){
			 $order = Order::findOrFail($order_id);
			 $order->payed = "yes";
			$order->save();
			  
		 }else{
			 $order->payed="no";
			 $order->save;
		 }
		
		 return $data['message']; 
	}
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(['message' => 'Order deleted successfully']);
    }
}
