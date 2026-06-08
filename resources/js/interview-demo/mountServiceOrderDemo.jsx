import React from 'react';
import { createRoot } from 'react-dom/client';
import ServiceOrderDemo from './ServiceOrderDemo.jsx';

export default function mountServiceOrderDemo() {
    const rootElement = document.getElementById('service-order-demo-root');

    if (!rootElement) {
        return;
    }

    createRoot(rootElement).render(<ServiceOrderDemo />);
}
