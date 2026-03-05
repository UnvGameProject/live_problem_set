import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import livewire from '@defstudio/vite-livewire-plugin';

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
                'resources/scss/**/*.scss'
            ],
        }),
        livewire()
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'nlffitness.localhost',
            protocol: 'ws'
        },
        watch: {
            usePolling: true,
            interval: 1000
        }
    },
    build: {
        manifest: true,
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
