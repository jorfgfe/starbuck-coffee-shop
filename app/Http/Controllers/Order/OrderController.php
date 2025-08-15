<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Extra;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $orderStoreRequest) 
    {
        try {
            $data = $orderStoreRequest->validated();
            
            $validationResult = $this->validateOrder($data);

            if ($validationResult instanceof JsonResponse) {
                return $validationResult;
            }
            
            $total = $validationResult;
            
            DB::transaction(function () use ($data, $total) {
                $order = Order::create([
                    'total_paid' => $data['payment'],
                    'total' => $total
                ]);

                foreach ($data['order'] as $productOrdered) {
                    $product = Product::findOrFail($productOrdered['productId']);
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $productOrdered['quantity']
                    ]);
                    
                    $product->decrement('stock', $productOrdered['quantity']);
                }
            });

            $change = $data['payment'] - $total;
            return $this->successResponse([
                'message' => 'Order created successfully',
                'change' => $change > 0 ? $change : 0
            ], 201);
            
        } catch (\Exception $e) {
            return $this->errorResponse(['Error creating order', $e->getMessage()]);
        }
    }

    private function validateOrder(array $data): JsonResponse|int
    {
        $total = 0;

        foreach ($data['order'] as $productOrdered) {
            $product = Product::findOrFail($productOrdered['productId']);

            if ($product->stock <= 0 || $product->stock < $productOrdered['quantity']) { 
                return $this->errorResponse(
                    ['Insufficient stock for product: ' . $product->name], 
                    200
                );
            } 

            $total += ($product->price * $productOrdered['quantity']);

            if (isset($productOrdered['extra'])) {
                foreach ($productOrdered['extra'] as $extra) {
                    $extraFound = Extra::findOrFail($extra);
                    $total += $extraFound->price;
                }
            }
        }


        if ($total > $data['payment']) {
            return $this->errorResponse(['Insufficient funds'], 200);
        }

        return $total;
    }

    
}
