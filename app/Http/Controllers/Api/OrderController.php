<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create() : JsonResponse {
        if(!Auth::check()) {
            return $this->sendError('User not authorised.', ['error' => 'Unauthorised access'], 401);
        }

        $user = User::find(Auth::id());

        $order = Order::create([
            'number' => uniqid(),
            'status' => OrderStatus::Pending->value,
            'user_id' => $user->id,
            'billpayer_id' => $user->getBillingAddressId(),
            'shipping_address_id' => $user->getShippingAddressId(),
        ]);

        return $this->sendResponse($order, 'Order created and saved.');
    }

    public function orders() : object
    {
        if(!Auth::check()) {
            return $this->sendError('User not authorised.', ['error' => 'Unauthorised access'], 401);
        }

        $user = User::find(Auth::id());

        $orders = $user->orders()
            ->paginate(25);

        return new OrderCollection($orders);
    }

    public function show($number) : object
    {
        if(!Auth::check()) {
            return $this->sendError('User not authorised.', ['error' => 'Unauthorised access'], 401);
        }

        $order = Order::where('number', $number)->first();

        if(!$order) {
            return $this->sendError('Order does not exist.', ['error' => 'Missing order in database'], 404);
        }

        return new OrderResource($order);
    }

    public function addProduct($number, OrderRequest $request) : JsonResponse
    {
        if(!Auth::check()) {
            return $this->sendError('User not authorised.', ['error' => 'Unauthorised access'], 401);
        }

        $order = Order::where('number', $number)->first();

        if(!$order) {
            return $this->sendError('Order does not exist.', ['error' => 'Missing order in database'], 404);
        }

        $product = Product::listed()->where('sku', $request->get('product_sku'))->first();

        if(!$product) {
            return $this->sendError('Product does not exist.', ['error' => 'Missing product in database'], 404);
        }

        $quantity = $request->filled('quantity') ? (int) $request->get('quantity') : 1;


        $orderItem = $order->items->firstWhere('product_sku', $product->sku);

        if ($orderItem) {
            $orderItem->quantity += $quantity;
            $orderItem->price = $product->getPrice();
            $orderItem->save();
    
            $response = $this->sendResponse($orderItem, 'Product updated in order.');
        } else {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_sku' => $product->sku,
                'quantity' => $quantity,
                'price' => $product->getPrice(),
            ]);
    
            $response = $this->sendResponse($orderItem, 'Product added to order.');
        }

        $order->load('items');
        $order->updatePaymentDetails();

        return $response;
    }

    public function removeProduct($number, Request $request) : JsonResponse
    {
        if(!Auth::check()) {
            return $this->sendError('User not authorised.', ['error' => 'Unauthorised access'], 401);
        }

        $order = Order::where('number', $number)->first();

        if(!$order) {
            return $this->sendError('Order does not exist.', ['error' => 'Missing order in database'], 404);
        }

        $orderItem = $order->items->firstWhere('product_sku', $request->get('product_sku'));

        if ($orderItem) {
            $orderItem->delete();
    
            $response = $this->sendResponse($order, 'Product removed from order.');
        } else {
            $response = $this->sendError('Order has no such item.', ['error' => 'Item not found in order'], 404);
        }

        $order->load('items');
        $order->updatePaymentDetails();
        
        return $response;
    }
}
