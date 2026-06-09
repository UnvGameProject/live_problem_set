<?php

namespace Database\Seeders;

use App\Models\InterviewServiceOrder;
use Illuminate\Database\Seeder;

class InterviewServiceOrderSeeder extends Seeder
{
    /**
     * Seed sample service orders for the interview demo.
     */
    public function run(): void
    {
        $orders = [
            [
                'order_id' => 'SO-1001',
                'customer_name' => 'North River Logistics',
                'vehicle_id' => 'TRK-8842',
                'technician' => 'Alex',
                'status' => 'Open',
                'priority' => 'urgent',
                'labor_hours' => 2.50,
                'parts_cost' => 184.25,
            ],
            [
                'order_id' => 'SO-1002',
                'customer_name' => 'Blue Line Freight',
                'vehicle_id' => 'TRK-1940',
                'technician' => null,
                'status' => 'in progress',
                'priority' => 'normal',
                'labor_hours' => 3.00,
                'parts_cost' => 91.00,
            ],
            [
                'order_id' => 'SO-1003',
                'customer_name' => 'Evergreen Fleet Services',
                'vehicle_id' => 'TRK-5521',
                'technician' => 'Morgan',
                'status' => 'completed',
                'priority' => 'low',
                'labor_hours' => 1.75,
                'parts_cost' => 42.50,
            ],
        ];

        foreach ($orders as $order) {
            InterviewServiceOrder::query()->updateOrCreate(
                ['order_id' => $order['order_id']],
                $order
            );
        }
    }
}
