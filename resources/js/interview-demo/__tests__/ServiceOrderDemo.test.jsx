import React from 'react';
import { fireEvent, render, screen } from '@testing-library/react';
import ServiceOrderDemo from '../ServiceOrderDemo.jsx';

const serviceOrders = [
    {
        order_id: 'SO-1001',
        customer_name: 'North River Logistics',
        vehicle_id: 'TRK-8842',
        technician: 'Alex',
        status: 'Open',
        priority: 'urgent',
        labor_hours: 2.5,
        parts_cost: 184.25,
    },
    {
        order_id: 'SO-1002',
        customer_name: 'Blue Line Freight',
        vehicle_id: 'TRK-1940',
        technician: null,
        status: 'in progress',
        priority: 'normal',
        labor_hours: 3,
        parts_cost: 91,
    },
];

describe('ServiceOrderDemo', () => {
    beforeEach(() => {
        global.fetch = vi.fn(() => Promise.resolve({
            ok: true,
            json: () => Promise.resolve({
                data: serviceOrders,
            }),
        }));
    });

    afterEach(() => {
        vi.restoreAllMocks();
    });

    it('loads and renders service orders from the API', async () => {
        render(<ServiceOrderDemo />);

        expect(screen.getByText('Loading service orders...')).toBeInTheDocument();

        expect(await screen.findByText('Service orders')).toBeInTheDocument();
        expect(screen.getByText('North River Logistics')).toBeInTheDocument();
        expect(screen.getByRole('heading', { name: /Selected order/i })).toBeInTheDocument();
        expect(screen.getAllByText('SO-1001')).toHaveLength(2);
    });

    it('updates the selected order when a different order is selected', async () => {
        render(<ServiceOrderDemo />);

        fireEvent.click(await screen.findByText('Blue Line Freight'));

        expect(screen.getByText('TRK-1940')).toBeInTheDocument();
        expect(screen.getByText('Missing technician')).toBeInTheDocument();
    });
});
