import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    define: {
        'process.env': process.env
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: true,
        port: 8080,
        hmr: {
            host: 'localhost'
        },
    },
    resolve: {
        alias: [
            {
                find: /^~.+/,
                replacement: (val) => {
                    return val.replace(/^~/, "");
                },
            },
        ],
    },
    build: {
        commonjsOptions: {
            transformMixedEsModules: true,
        }
    }
});
