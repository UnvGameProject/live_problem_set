<div class="php-workspace">
    <div class="php-workspace__editor">
        <div class="panel-heading">
            <p class="eyebrow">Input</p>
            <h2>Raw service orders</h2>
        </div>

        <p class="workspace-copy">
            Edit the JSON payload below. Livewire sends the changes back to PHP,
            normalizes valid records, and reports invalid records without a full page refresh.
        </p>

        <textarea
            class="json-editor"
            wire:model.live.debounce.600ms="payload"
            spellcheck="false"
            aria-label="Raw service order JSON payload"
        ></textarea>

        <div class="workspace-actions">
            <button class="secondary-action secondary-action--button" type="button" wire:click="loadSample">
                Reset sample
            </button>

            <button class="primary-action primary-action--button" type="button" wire:click="analyze">
                Analyze now
            </button>
        </div>

        @if ($parseError)
            <div class="workspace-alert" role="alert">
                JSON error: {{ $parseError }}
            </div>
        @endif
    </div>

    <div class="php-workspace__results">
        <div class="summary-grid">
            <article class="summary-card">
                <span>Total</span>
                <strong>{{ $summary['total'] }}</strong>
            </article>

            <article class="summary-card">
                <span>Valid</span>
                <strong>{{ $summary['valid'] }}</strong>
            </article>

            <article class="summary-card">
                <span>Invalid</span>
                <strong>{{ $summary['invalid'] }}</strong>
            </article>

            <article class="summary-card">
                <span>High Priority</span>
                <strong>{{ $summary['high_priority'] }}</strong>
            </article>
        </div>

        <section class="result-panel">
            <div class="panel-heading">
                <p class="eyebrow">Output</p>
                <h2>Normalized valid orders</h2>
            </div>

            @if ($validOrders === [])
                <p class="empty-state">No valid orders yet.</p>
            @else
                <div class="table-wrap">
                    <table class="workspace-table">
                        <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($validOrders as $order)
                            <tr>
                                <td>{{ $order['order_id'] }}</td>
                                <td>{{ $order['customer_name'] }}</td>
                                <td>{{ $order['status'] }}</td>
                                <td>{{ $order['priority'] }}</td>
                                <td>${{ number_format($order['estimated_total'], 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <section class="result-panel">
            <div class="panel-heading">
                <p class="eyebrow">Validation</p>
                <h2>Invalid records</h2>
            </div>

            @if ($invalidOrders === [])
                <p class="empty-state">No invalid records found.</p>
            @else
                <div class="invalid-list">
                    @foreach ($invalidOrders as $invalidOrder)
                        <article class="invalid-card">
                            <strong>Row {{ $invalidOrder['row'] }}</strong>
                            <p>{{ $invalidOrder['reason'] }}</p>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
</div>
