<?php

namespace App\Livewire\InterviewDemo;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class PhpWorkspace extends Component
{
    public string $payload = '';

    public array $validOrders = [];

    public array $invalidOrders = [];

    public array $summary = [
        'total' => 0,
        'valid' => 0,
        'invalid' => 0,
        'high_priority' => 0,
        'estimated_total' => 0.0,
    ];

    public ?string $parseError = null;

    public function mount(): void
    {
        $this->loadSample();
    }

    public function loadSample(): void
    {
        $this->payload = json_encode([
            [
                'order_id' => 'SO-1001',
                'customer_name' => 'North River Logistics',
                'vehicle_id' => 'TRK-8842',
                'status' => 'Open',
                'priority' => 'urgent',
                'labor_hours' => '2.5',
                'parts_cost' => '184.25',
            ],
            [
                'order_id' => 'SO-1002',
                'customer_name' => 'Blue Line Freight',
                'vehicle_id' => 'TRK-1940',
                'status' => 'in progress',
                'priority' => 'normal',
                'labor_hours' => '3',
                'parts_cost' => '91.00',
            ],
            [
                'order_id' => 'SO-1002',
                'customer_name' => 'Duplicate Example',
                'vehicle_id' => 'TRK-1940',
                'status' => 'waiting',
                'priority' => 'low',
                'labor_hours' => 'bad-value',
                'parts_cost' => '44.00',
            ],
        ], JSON_PRETTY_PRINT);

        $this->analyze();
    }

    public function updatedPayload(): void
    {
        $this->analyze();
    }

    public function analyze(): void
    {
        $this->parseError = null;
        $this->validOrders = [];
        $this->invalidOrders = [];
        $this->summary = [
            'total' => 0,
            'valid' => 0,
            'invalid' => 0,
            'high_priority' => 0,
            'estimated_total' => 0.0,
        ];

        $decoded = json_decode($this->payload, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->parseError = json_last_error_msg();

            return;
        }

        if (! is_array($decoded)) {
            $this->parseError = 'Payload must be a JSON array of service orders.';

            return;
        }

        $seenOrderIds = [];

        foreach ($decoded as $index => $order) {
            $this->summary['total']++;

            if (! is_array($order)) {
                $this->invalidOrders[] = [
                    'row' => $index + 1,
                    'reason' => 'Order must be a JSON object.',
                    'order' => $order,
                ];

                continue;
            }

            $errors = $this->validateOrder($order, $seenOrderIds);

            if ($errors !== []) {
                $this->invalidOrders[] = [
                    'row' => $index + 1,
                    'reason' => implode(' ', $errors),
                    'order' => $order,
                ];

                continue;
            }

            $normalized = $this->normalizeOrder($order);
            $seenOrderIds[] = $normalized['order_id'];

            if ($normalized['priority'] === 'high') {
                $this->summary['high_priority']++;
            }

            $this->summary['estimated_total'] += $normalized['estimated_total'];
            $this->validOrders[] = $normalized;
        }

        $this->summary['valid'] = count($this->validOrders);
        $this->summary['invalid'] = count($this->invalidOrders);
        $this->summary['estimated_total'] = round($this->summary['estimated_total'], 2);
    }

    public function render(): View
    {
        return view('livewire.interview-demo.php-workspace');
    }

    private function validateOrder(array $order, array $seenOrderIds): array
    {
        $errors = [];

        foreach (['order_id', 'customer_name', 'vehicle_id', 'status', 'priority'] as $field) {
            if (! array_key_exists($field, $order) || trim((string) $order[$field]) === '') {
                $errors[] = "{$field} is required.";
            }
        }

        if (isset($order['order_id']) && in_array((string) $order['order_id'], $seenOrderIds, true)) {
            $errors[] = 'Duplicate order_id.';
        }

        if (! $this->normalizeStatus((string) ($order['status'] ?? ''))) {
            $errors[] = 'Unsupported status.';
        }

        if (! $this->normalizePriority((string) ($order['priority'] ?? ''))) {
            $errors[] = 'Unsupported priority.';
        }

        if (! is_numeric($order['labor_hours'] ?? null)) {
            $errors[] = 'labor_hours must be numeric.';
        }

        if (! is_numeric($order['parts_cost'] ?? null)) {
            $errors[] = 'parts_cost must be numeric.';
        }

        return $errors;
    }

    private function normalizeOrder(array $order): array
    {
        $laborHours = (float) $order['labor_hours'];
        $partsCost = (float) $order['parts_cost'];
        $laborRate = 125.00;

        return [
            'order_id' => trim((string) $order['order_id']),
            'customer_name' => trim((string) $order['customer_name']),
            'vehicle_id' => trim((string) $order['vehicle_id']),
            'status' => $this->normalizeStatus((string) $order['status']),
            'priority' => $this->normalizePriority((string) $order['priority']),
            'labor_hours' => round($laborHours, 2),
            'parts_cost' => round($partsCost, 2),
            'estimated_total' => round(($laborHours * $laborRate) + $partsCost, 2),
        ];
    }

    private function normalizeStatus(string $status): ?string
    {
        return match (strtolower(trim($status))) {
            'open', 'new' => 'open',
            'in progress', 'in_progress', 'working' => 'in_progress',
            'complete', 'completed', 'done' => 'completed',
            'cancelled', 'canceled' => 'cancelled',
            default => null,
        };
    }

    private function normalizePriority(string $priority): ?string
    {
        return match (strtolower(trim($priority))) {
            'urgent', 'high' => 'high',
            'normal', 'medium' => 'normal',
            'low' => 'low',
            default => null,
        };
    }
}
