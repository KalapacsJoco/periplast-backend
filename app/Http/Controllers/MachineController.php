<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Machine::all());
    }

    public function show($id): JsonResponse
    {
        $machine = Machine::findOrFail($id);

        // Get running orders for this machine using the existing relationship
        $runningOrders = $machine->orders()
            ->where('status', 'running')
            ->select([
                'id',
                'customer_order_number',
                'material',
                'gross_weight_has_to_be',
                'gross_weight', // Added
                'net_weight_has_to_be',
                'net_weight', // Added
                'cycle_time_has_to_be',
                'cycle_time', // Added
                'product_name',
                'quantity',
                'hot_water_cooling',
                'created_at'
            ])
            ->get();

        return response()->json([
            'id' => $machine->id,
            'name' => $machine->name,
            'status' => $machine->status,
            'running_orders' => $runningOrders, // Only running orders
            'created_at' => $machine->created_at,
            'updated_at' => $machine->updated_at,
        ]);
    }

    public function updateOrder(Request $request, $orderId)
    {
        $validated = $request->validate([
            'gross_weight' => 'nullable|numeric|min:0',
            'net_weight' => 'nullable|numeric|min:0',
            'cycle_time' => 'nullable|numeric|min:0',
        ]);

        $order = Order::findOrFail($orderId);
        $order->update($validated);

        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $order
        ]);
    }

    public function stop(Machine $machine)
    {
        // Update machine status to stopped
        $machine->update(['status' => 'stopped']);

        return response()->json(['message' => 'Machine stopped successfully']);
    }

    public function resume(Machine $machine)
    {
        // Update machine status to running or whatever your normal status is
        $machine->update(['status' => 'running']);

        return response()->json(['message' => 'Machine resumed successfully']);
    }
}
