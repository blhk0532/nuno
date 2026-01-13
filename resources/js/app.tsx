import '../css/app.css';

import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';
import { initializeTheme } from './utils/theme';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

// Prevent loading on non-Inertia pages
if (!document.querySelector('script[data-page]')) {
    console.warn('Livewire ⚡ Detected: Inertia not initialized.');
} else {
    createInertiaApp({
        title: (title) => (title ? `${title} - ${appName}` : appName),
        resolve: (name) =>
            resolvePageComponent(
                `./pages/${name}.tsx`,
                import.meta.glob('./pages/**/*.tsx'),
            ),
        setup({ el, App, props }) {
            const root = createRoot(el);

            root.render(<App {...props} />);
        },
        progress: {
            color: '#4B5563',
        },
    });

    // This will set light / dark mode on load...
    initializeTheme();
}
