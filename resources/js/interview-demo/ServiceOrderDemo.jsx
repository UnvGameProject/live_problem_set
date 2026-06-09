import React, { useEffect, useMemo, useState } from 'react';

export default function ServiceOrderDemo() {
    const [orders, setOrders] = useState([]);
    const [selectedOrderId, setSelectedOrderId] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [loadError, setLoadError] = useState(null);

    useEffect(() => {
        let isMounted = true;

        async function loadOrders() {
            setIsLoading(true);
            setLoadError(null);

            try {
                const response = await fetch('/api/interview-demo/service-orders', {
                    headers: {
                        Accept: 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error(`Unable to load service orders. Status: ${response.status}`);
                }

                const payload = await response.json();
                const loadedOrders = Array.isArray(payload.data) ? payload.data : [];

                if (!isMounted) {
                    return;
                }

                setOrders(loadedOrders);
                setSelectedOrderId(loadedOrders[0]?.order_id ?? null);
            } catch (error) {
                if (!isMounted) {
                    return;
                }

                setLoadError(error instanceof Error ? error.message : 'Unable to load service orders.');
            } finally {
                if (isMounted) {
                    setIsLoading(false);
                }
            }
        }

        loadOrders();

        return () => {
            isMounted = false;
        };
    }, []);

    const selectedOrder = useMemo(() => {
        return orders.find((order) => order.order_id === selectedOrderId) ?? orders[0] ?? null;
    }, [orders, selectedOrderId]);

    if (isLoading) {
        return (
            <div className="service-demo service-demo--single">
                <div className="service-demo__panel">
                    <p className="eyebrow">Loading</p>
                    <h2>Loading service orders...</h2>
                    <p className="workspace-copy">
                        Fetching service order records from Laravel and PostgreSQL.
                    </p>
                </div>
            </div>
        );
    }

    if (loadError) {
        return (
            <div className="service-demo service-demo--single">
                <div className="service-demo__panel">
                    <p className="eyebrow">Error</p>
                    <h2>Unable to load service orders</h2>
                    <p className="workspace-alert">{loadError}</p>
                </div>
            </div>
        );
    }

    if (orders.length === 0) {
        return (
            <div className="service-demo service-demo--single">
                <div className="service-demo__panel">
                    <p className="eyebrow">Empty state</p>
                    <h2>No service orders found</h2>
                    <p className="workspace-copy">
                        The database is connected, but no demo service orders have been seeded yet.
                    </p>
                </div>
            </div>
        );
    }

    return (
        <div className="service-demo">
            <div className="service-demo__panel service-demo__panel--input">
                <div className="panel-heading">
                    <p className="eyebrow">Database</p>
                    <h2>Service orders</h2>
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

                {selectedOrder && (
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
                            <dd>{Number(selectedOrder.labor_hours).toFixed(2)}</dd>
                        </div>

                        <div>
                            <dt>Parts cost</dt>
                            <dd>${Number(selectedOrder.parts_cost).toFixed(2)}</dd>
                        </div>
                    </dl>
                )}

                <p className="hmr-note">
                    Data is loaded from Laravel and PostgreSQL. Edit this React component to verify HMR.
                </p>
            </div>
        </div>
    );
}
