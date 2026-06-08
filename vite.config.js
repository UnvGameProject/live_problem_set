import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from '@defstudio/vite-livewire-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/scss/app.scss',
            ],
            refresh: [
                'resources/views/**/*.blade.php',
                'resources/js/**/*.js',
                'resources/js/**/*.jsx',
                'resources/scss/**/*.scss'
            ],
        }),
        livewire(),
        react()
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'fullbaydemo.localhost',
            protocol: 'ws'
        },
        watch: {
            usePolling: true,
            interval: 1000
        }
    },
    build: {
        manifest: 'manifest.json',
        outDir: 'public/build'
    },
    resolve: {
        alias: {
            '@': '/resources',
            '$': 'jquery',
            'jQuery': 'jquery'
        }
    },
    test: {
        environment: 'jsdom',
        globals: true,
        setupFiles: [
            'resources/js/test/setup.js'
        ]
    }
});
