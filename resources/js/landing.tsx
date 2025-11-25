import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import App from './landing/App';
import '../css/app.css';

const container = document.getElementById('landing-root');
if (container) {
    createRoot(container).render(
        <StrictMode>
            <App />
        </StrictMode>
    );
}

