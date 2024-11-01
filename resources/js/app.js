import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp, Link as InertiaLink } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { ThemePlugin } from "@/Components/useTheme.js";
import * as echarts from "echarts";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        // console.log("Inertia props:", props);
        const app = createApp({ render: () => h(App, props) });

        app.component("InertiaLink", InertiaLink);
        app.component("Link", InertiaLink);
        app.use(plugin);
        app.use(ZiggyVue);
        app.use(ThemePlugin); // Add the theme plugi

        app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
