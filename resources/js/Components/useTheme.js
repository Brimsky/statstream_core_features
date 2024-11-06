// resources/js/Components/useTheme.js
import { onMounted } from "vue";
import { themeStore } from "./Store/themeStore.js";

export const useTheme = () => {
    const initTheme = () => {
        if (themeStore.initialized.value) return;

        // Check localStorage first
        const savedTheme = localStorage.getItem("theme");

        if (savedTheme) {
            themeStore.isDark.value = savedTheme === "dark";
        } else {
            // Check system preference
            themeStore.isDark.value = window.matchMedia(
                "(prefers-color-scheme: dark)",
            ).matches;
        }

        // Apply theme
        applyTheme(themeStore.isDark.value);
        themeStore.initialized.value = true;
    };

    const applyTheme = (dark) => {
        if (dark) {
            document.documentElement.classList.add("dark");
            document.documentElement.classList.remove("light");
        } else {
            document.documentElement.classList.remove("dark");
            document.documentElement.classList.add("light");
        }
        localStorage.setItem("theme", dark ? "dark" : "light");
    };

    const toggleTheme = () => {
        themeStore.isDark.value = !themeStore.isDark.value;
        applyTheme(themeStore.isDark.value);
    };

    // Initialize theme on component mount
    onMounted(() => {
        initTheme();

        // Listen for system theme changes
        window
            .matchMedia("(prefers-color-scheme: dark)")
            .addEventListener("change", (e) => {
                if (!localStorage.getItem("theme")) {
                    themeStore.isDark.value = e.matches;
                    applyTheme(e.matches);
                }
            });
    });

    return {
        isDark: themeStore.isDark,
        toggleTheme,
    };
};
