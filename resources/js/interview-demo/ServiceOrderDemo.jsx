import React, { useMemo, useState } from 'react';

const sampleOrders = [
    {
        order_id: 'SO-1001',
        customer_name: 'North River Logistics',
        vehicle_id: 'TRK-8842',
        technician: 'Alex',
        status: 'Open',
        priority: 'urgent',
        labor_hours: '2.5',
        parts_cost: '184.25',
    },
    {
        order_id: 'SO-1002',
        customer_name: 'Blue Line Freight',
        vehicle_id: 'TRK-1940',
        technician: '',
        status: 'in progress',
        priority: 'normal',
        labor_hours: 'bad-value',
        parts_cost: '91.00',
    },
];

export default function ServiceOrderDemo() {
    const [orders] = useState(sampleOrders);
    const [selectedOrderId, setSelectedOrderId] = useState(sampleOrders[0].order_id);

    const selectedOrder = useMemo(() => {
        return orders.find((order) => order.order_id === selectedOrderId) ?? orders[0];
    }, [orders, selectedOrderId]);

    return (
        <div className="service-demo">
            <div className="service-demo__panel service-demo__panel--input">
                <div className="panel-heading">
                    <p className="eyebrow">Input</p>
                    <h2>Messy service orders</h2>
                </div>

                <div className="order-list">
                    {orders.map((order) => (
                        <button
                            className={`order-card ${order.order_id === selectedOrderId ? 'order-card--active' : ''}`}
                            key={order.order_id}
                            type="button"
                            onClick={() => setSelectedOrderId(order.order_id)}
                        >
                            <span>{order.order_id}</span>
                            <strong>{order.customer_name}</strong>
                            <small>{order.status} · {order.priority}</small>
                        </button>
                    ))}
                </div>
            </div>

            <div className="service-demo__panel service-demo__panel--output">
                <div className="panel-heading">
                    <p className="eyebrow">Preview</p>
                    <h2>Selected order</h2>
                </div>

                <dl className="order-details">
                    <div>
                        <dt>Order ID</dt>
                        <dd>{selectedOrder.order_id}</dd>
                    </div>

                    <div>
                        <dt>Vehicle</dt>
                        <dd>{selectedOrder.vehicle_id}</dd>
                    </div>

                    <div>
                        <dt>Technician</dt>
                        <dd>{selectedOrder.technician || 'Missing technician'}</dd>
                    </div>

                    <div>
                        <dt>Status</dt>
                        <dd>{selectedOrder.status}</dd>
                    </div>

                    <div>
                        <dt>Priority</dt>
                        <dd>{selectedOrder.priority}</dd>
                    </div>

                    <div>
                        <dt>Labor hours</dt>
                        <dd>{selectedOrder.labor_hours}</dd>
                    </div>

                    <div>
                        <dt>Parts cost</dt>
                        <dd>${selectedOrder.parts_cost}</dd>
                    </div>
                </dl>

                <p className="hmr-note">
                    HMR check: edit this sentence in ServiceOrderDemo.jsx and the browser should update without a full refresh.
                </p>
            </div>
        </div>
    );
}
