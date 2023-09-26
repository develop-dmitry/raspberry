import './bootstrap';

import {createApp, h, type DefineComponent, App} from "vue";
import {createInertiaApp} from "@inertiajs/inertia-vue3";
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import {createPinia} from "pinia";

createInertiaApp({
    resolve: async (name: string) => {
        return await resolvePageComponent(
            `./pages/${name}.vue`,
            import.meta.glob<DefineComponent>(`./pages/**/*.vue`)
        )
    },
    setup({ el, app, props, plugin }): App {
        const vueApp: App = createApp({ render: () => h(app, props) });

        vueApp
            .use(plugin)
            .use(createPinia())
            .mount(el);

        return vueApp;
    },
});
