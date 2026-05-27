<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,bank_transfer,virtual_account,qris',
            'delivery_time' => 'required|in:pagi,sore,khusus',
            'delivery_note' => 'nullable|string',

        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->stock < $item['quantity']) throw new \Exception("Stok {$product->name} tidak cukup");

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;
                $orderItems[] = ['product_id' => $product->id, 'quantity' => $item['quantity'], 'price' => $product->price, 'subtotal' => $subtotal];

                // $product->decrement('stock', $item['quantity']);
                // StockMovement::create(['product_id' => $product->id, 'type' => 'out', 'quantity' => $item['quantity'], 'reference_type' => 'order', 'created_by' => auth()->id()]);
                $product->decrement('stock', $item['quantity']);
            }

            // HITUNG TOTAL DENGAN FEES
            $totalAmount = $total;

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'status' => 'pending_payment',
                'payment_status' => 'unpaid',
                'delivery_time' => $request->delivery_time,
                'delivery_note' => $request->delivery_note,
            ]);

            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $totalAmount,  // ← PAKAI TOTAL YANG SUDAH DITAMBAH
                'expires_at' => now()->addMinutes(10), // ← 10 menit
            ]);

            // Notifikasi admin
            $admins = \App\Models\User::whereIn('role', ['admin', 'master'])->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'new_order',
                    'title' => 'Pesanan Baru',
                    'message' => 'Pesanan #' . $order->order_number . ' dari ' . auth()->user()->name,
                    'reference_type' => 'order',
                    'reference_id' => $order->id
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Pesanan berhasil dibuat', 'order' => $order->load('items.product')], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getOrders(Request $request)
    {
        $perPage = $request->per_page ?? 10;
        return response()->json(
            Order::with(['items.product', 'payment'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate($perPage)
        );
    }


    public function getOrderDetail(int $id)
    {
        return response()->json(Order::with(['items.product', 'payment'])->findOrFail($id));
    }
}
