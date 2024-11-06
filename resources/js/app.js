import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp, Link as InertiaLink } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import { useTheme } from "@/Components/useTheme";
import * as echarts from "echarts";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

// Initialize theme before app creation
const { isDark } = useTheme();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue"),
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.component("InertiaLink", InertiaLink);
        app.component("Link", InertiaLink);
        app.use(plugin);
        app.use(ZiggyVue);

        app.mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
