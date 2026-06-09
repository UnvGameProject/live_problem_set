import React from 'react';
import { fireEvent, render, screen } from '@testing-library/react';
import ServiceOrderDemo from '../ServiceOrderDemo.jsx';

describe('ServiceOrderDemo', () => {
    it('renders the service order workspace', () => {
        render(<ServiceOrderDemo />);

        expect(screen.getByText('Messy service orders')).toBeInTheDocument();
        expect(screen.getByRole('heading', { name: /Selected order/i })).toBeInTheDocument();
        expect(screen.getByText('North River Logistics')).toBeInTheDocument();
        expect(screen.getAllByText('SO-1001')).toHaveLength(2);
    });

    it('updates the selected order when a different order is selected', () => {
        render(<ServiceOrderDemo />);

        fireEvent.click(screen.getByText('Blue Line Freight'));

        expect(screen.getByText('TRK-1940')).toBeInTheDocument();
        expect(screen.getByText('Missing technician')).toBeInTheDocument();
    });
});
