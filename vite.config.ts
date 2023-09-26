import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vuePlugin from "@vitejs/plugin-vue";
import pugPlugin from "vite-plugin-pug";

export default defineConfig({
    plugins: [
        vuePlugin(),
        pugPlugin(),
        laravel({
            input: ['resources/css/app.scss', 'resources/js/app.ts'],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `
                    @import "/resources/css/global/vars.scss";
                    @import "/resources/css/global/mixins.scss";
                `
            }
        }
    },
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler',
            '#components': 'resources/js/components',
            '#pages': 'resources/js/pages',
            '#stores': 'resources/js/stores',
            '#ui': 'resources/js/ui',
            '#models': 'resources/js/models'
        },
    }
});
