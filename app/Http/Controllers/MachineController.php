<?php

namespace App\Http\Controllers;

use App\Models\Machine;
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
                'net_weight_has_to_be',
                'cycle_time_has_to_be',
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
}
