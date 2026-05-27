<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List semua pesanan
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 20;
        $status = $request->status;

        $query = Order::with(['items.product', 'user', 'kurir'])->latest();

        if ($status) {
            $query->where('status', $status);
        }

        return response()->json($query->paginate($perPage));
    }


    // Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:processing,shipping,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        // Notif user
        Notification::create([
            'user_id' => $order->user_id,
            'type' => 'order_update',
            'title' => 'Status Pesanan Diperbarui',
            'message' => "Pesanan #{$order->order_number} telah {$request->status}",
            'reference_type' => 'order',
            'reference_id' => $order->id
        ]);

        return response()->json(['message' => 'Status updated', 'order' => $order]);
    }

    // Assign kurir
    public function assignKurir(Request $request, $id)
    {
        $request->validate([
            'kurir_id' => 'required|exists:users,id'
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'kurir_id' => $request->kurir_id,
            'status' => 'shipping'
        ]);

        // Notif kurir
        Notification::create([
            'user_id' => $request->kurir_id,
            'type' => 'new_delivery',
            'title' => 'Pengantaran Baru',
            'message' => "Anda ditugaskan mengantar pesanan #{$order->order_number}",
            'reference_type' => 'order',
            'reference_id' => $order->id
        ]);

        return response()->json(['message' => 'Kurir assigned', 'order' => $order->load('kurir')]);
    }

    // List kurir
    public function kurirList()
    {
        return response()->json(User::where('role', 'kurir')->get(['id', 'name']));
    }
}
