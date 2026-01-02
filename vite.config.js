import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";
import * as fs from 'fs';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        https: {
            key: fs.readFileSync('/etc/letsencrypt/live/aeugene.top/privkey.pem'),
            cert: fs.readFileSync('/etc/letsencrypt/live/aeugene.top/fullchain.pem'),
        },
        // Make sure the server is accessible over the local network
        host: 'aeugene.top',
        port: 5173
    },
});