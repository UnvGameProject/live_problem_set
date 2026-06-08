import React from 'react';
import { fireEvent, render, screen } from '@testing-library/react';
import ServiceOrderDemo from '../ServiceOrderDemo.jsx';

describe('ServiceOrderDemo', () => {
    it('renders the service order workspace', () => {
        render(<ServiceOrderDemo />);

        expect(screen.getByText('Messy service orders')).toBeInTheDocument();
        expect(screen.getByText('Selected order')).toBeInTheDocument();
        expect(screen.getByText('SO-1001')).toBeInTheDocument();
    });

    it('updates the selected order when a different order is selected', () => {
        render(<ServiceOrderDemo />);

        fireEvent.click(screen.getByText('Blue Line Freight'));

        expect(screen.getByText('TRK-1940')).toBeInTheDocument();
        expect(screen.getByText('Missing technician')).toBeInTheDocument();
    });
});
