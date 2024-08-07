<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderInvoice;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create() : JsonResponse
    {
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
        $user = User::find(Auth::id());

        $orders = $user->orders()
            ->paginate(25);

        return new OrderCollection($orders);
    }

    public function show($number) : object
    {
        $order = Order::where('number', $number)->first();

        if(!$order) {
            return $this->sendError('Order does not exist.', ['error' => 'Missing order in database'], 404);
        }

        return new OrderResource($order);
    }

    public function confirmed($number, Request $request) : JsonResponse
    {
        $order = Order::where('number', $number)->first();

        if(!$order) {
            return $this->sendError('Order does not exist.', ['error' => 'Missing order in database'], 404);
        }

        $order->update([
            'status' => $request->filled('status') ? $request->get('status') : OrderStatus::Pending->value,
            'note' => $request->filled('note') ? $request->get('note') : null,
        ]);

        $order->save();

        return $this->sendResponse($order, 'Order confirmed.');
    }

    public function finalize($number) : JsonResponse
    {
        $user = User::find(Auth::id());

        $order = Order::where('number', $number)->first();

        if(!$order) {
            return $this->sendError('Order does not exist.', ['error' => 'Missing order in database'], 404);
        }

        $orderItems = $order->items->map(function ($item) {
            return [
                'product_sku' => $item->product_sku,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'amount' => $item->quantity * $item->price,
            ];
        })->toArray();

        $data = [
            'order_number' => $order->number,
            'status' => OrderStatus::Completed->value,
            'name' => $user->name,
            'company' => $user->company,
            'tax_number' => $user->tax_number,
            'email' => $user->email,
            'billing_address' => $order->billingAddress->getFullAddress(),
            'shipping_address' => $order->shippingAddress ? $order->shippingAddress->getFullAddress() : null,
            'order_items' => $orderItems,
            'payment_details' => $order->payment_details,
            'total' => $order->total,
            'note' => $order->note,
        ];

        $orderInvoice = OrderInvoice::firstWhere('order_number', $order->number);

        if($orderInvoice) {
            $orderInvoice->update($data);
            $orderInvoice->save();
        } else {
            OrderInvoice::create($data);
        }
        
        return $this->sendResponse($order, 'Order finalized. Order receipt saved.');
    }

    public function addProduct($number, OrderRequest $request) : JsonResponse
    {
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
