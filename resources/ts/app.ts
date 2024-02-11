import "../css/app.css";
import "./bootstrap";

import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { Link, createInertiaApp } from "@inertiajs/vue3";
import { type DefineComponent, createApp, h } from "vue";

createInertiaApp({
    title: (title) => (title ? `${title} - Link Shortener` : "Link Shortener"),
    resolve: (name) => {
        return resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>("./Pages/**/*.vue")
        );
    },
    setup: ({ el, App, props, plugin }) => {
        createApp({
            render: () => h(App, props),
            mounted: () => {
                document.getElementById("init-placeholder")?.remove();
            },
        })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component("A", Link)
            .mount(el);
    },
    progress: { color: "#264653" },
});
