<?php

namespace App\Http\Controllers\InterviewDemo;

use App\Http\Controllers\Controller;
use App\Models\InterviewServiceOrder;
use Illuminate\Http\JsonResponse;

class ServiceOrderDataController extends Controller
{
    /**
     * Return service orders for the React interview demo.
     */
    public function __invoke(): JsonResponse
    {
        $orders = InterviewServiceOrder::query()
            ->orderBy('order_id')
            ->get()
            ->map(fn (InterviewServiceOrder $order): array => [
                'order_id' => $order->order_id,
                'customer_name' => $order->customer_name,
                'vehicle_id' => $order->vehicle_id,
                'technician' => $order->technician,
                'status' => $order->status,
                'priority' => $order->priority,
                'labor_hours' => (float) $order->labor_hours,
                'parts_cost' => (float) $order->parts_cost,
            ])
            ->values();

        return response()->json([
            'data' => $orders,
        ]);
    }
}
