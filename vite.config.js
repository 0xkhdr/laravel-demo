import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/design-system.css',
                'resources/js/nav.js',
                'resources/js/menu.js',
            ],
            refresh: true,
        }),
    ],
})
