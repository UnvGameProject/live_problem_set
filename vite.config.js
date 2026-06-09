import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/scss/app.scss',
                'resources/js/interview-demo/index.jsx',
            ],
            refresh: [
                'resources/views/**/*.blade.php',
                'resources/js/**/*.js',
                'resources/js/**/*.jsx',
                'resources/scss/**/*.scss'
            ],
        }),
        react()
    ],
    server: {
    host: '0.0.0.0',
    port: 5173,
    strictPort: true,
    cors: {
        origin: [
            'http://fullbaydemo.localhost',
            'http://fullbaydemo.localhost:80',
        ],
        credentials: true
    },
    hmr: {
        host: 'fullbaydemo.localhost',
        protocol: 'ws',
        port: 5173,
        clientPort: 5173
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
    }
});
