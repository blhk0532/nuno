import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.tsx',
                'resources/css/filament/admin/theme.css',
                'resources/css/filament/app/theme.css',
                'resources/css/filament/guest/theme.css',
                'resources/css/filament/booking/theme.css',
                'resources/css/filament/clients/theme.css',
                'resources/css/filament/data/theme.css',
                'resources/css/filament/dev/theme.css',
                'resources/css/filament/dialer/theme.css',
                'resources/css/filament/finance/theme.css',
                'resources/css/filament/manager/theme.css',
                'resources/css/filament/private/theme.css',
                'resources/css/filament/queue/theme.css',
                'resources/css/filament/server/theme.css',
                'resources/css/filament/service/theme.css',
                'resources/css/filament/super/theme.css',
                'resources/css/filament/tools/theme.css',
                'resources/css/filament/storage/theme.css',
                'resources/css/filament/system/theme.css',
                'resources/css/filament/chat/theme.css',
                'resources/css/filament/stats/theme.css',
                'resources/css/filament/calendar/theme.css',
                'resources/css/filament/sheets/theme.css',
                'resources/css/filament/email/theme.css',
                'resources/css/filament/notify/theme.css',
            ],
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
        }),
        react(),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
    ],
    esbuild: {
        jsx: 'automatic',
    },
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
