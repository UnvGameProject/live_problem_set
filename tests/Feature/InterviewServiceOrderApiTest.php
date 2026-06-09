<?php

namespace Tests\Feature;

use App\Models\InterviewServiceOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InterviewServiceOrderApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_orders_api_returns_database_records(): void
    {
        InterviewServiceOrder::query()->create([
            'order_id' => 'SO-9001',
            'customer_name' => 'Test Fleet',
            'vehicle_id' => 'TRK-9001',
            'technician' => 'Casey',
            'status' => 'Open',
            'priority' => 'urgent',
            'labor_hours' => 2.50,
            'parts_cost' => 100.25,
        ]);

        $response = $this->getJson(route('interview-demo.service-orders.index'));

        $response->assertOk();
        $response->assertJsonPath('data.0.order_id', 'SO-9001');
        $response->assertJsonPath('data.0.customer_name', 'Test Fleet');
        $response->assertJsonPath('data.0.vehicle_id', 'TRK-9001');
    }
}
