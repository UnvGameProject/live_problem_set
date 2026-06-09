import React from 'react';
import { createRoot } from 'react-dom/client';
import ServiceOrderDemo from './ServiceOrderDemo.jsx';

const rootElement = document.getElementById('service-order-demo-root');

if (rootElement) {
    createRoot(rootElement).render(<ServiceOrderDemo />);
}
