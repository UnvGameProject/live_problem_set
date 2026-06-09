<?php

namespace Tests\Feature;

use Tests\TestCase;

class InterviewDemoRoutesTest extends TestCase
{
    public function test_landing_page_loads(): void
    {
        $response = $this->get(route('landing'));

        $response->assertOk();
        $response->assertSee('Service Order Triage Demo');
        $response->assertSee(route('interview-demo.show'));
        $response->assertSee(route('php-workspace.show'));
    }

    public function test_service_order_demo_page_loads(): void
    {
        $response = $this->get(route('interview-demo.show'));

        $response->assertOk();
        $response->assertSee('Service Order Triage Dashboard');
        $response->assertSee('service-order-demo-root');
    }

    public function test_php_workspace_page_loads(): void
    {
        $response = $this->get(route('php-workspace.show'));

        $response->assertOk();
        $response->assertSee('PHP Data Workbench');
        $response->assertSee('PHP-only workbench');
    }
}
