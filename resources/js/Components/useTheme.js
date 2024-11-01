// Update your file at: resources/js/Components/useTheme.js

import { ref, watch, onMounted } from "vue";

// Create a shared state
const sharedDark = ref(false);

// Theme manager factory
const createThemeManager = () => {
    const initTheme = () => {
        // Check localStorage first
        const savedTheme = localStorage.getItem("theme");

        if (savedTheme) {
            sharedDark.value = savedTheme === "dark";
        } else {
            // If no saved theme, check system preference
            sharedDark.value = window.matchMedia(
                "(prefers-color-scheme: dark)",
            ).matches;
        }

        // Apply theme immediately
        applyTheme(sharedDark.value);

        // Listen for system theme changes
        window
            .matchMedia("(prefers-color-scheme: dark)")
            .addEventListener("change", (e) => {
                if (!localStorage.getItem("theme")) {
                    sharedDark.value = e.matches;
                    applyTheme(e.matches);
                }
            });
    };

    const applyTheme = (dark) => {
        if (dark) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
        localStorage.setItem("theme", dark ? "dark" : "light");
    };

    const toggleTheme = () => {
        sharedDark.value = !sharedDark.value;
    };

    // Watch for changes
    watch(sharedDark, (newValue) => {
        applyTheme(newValue);
    });

    return {
        isDark: sharedDark,
        toggleTheme,
        initTheme,
    };
};

// Create a singleton instance
const themeManager = createThemeManager();

// Plugin installation
export const ThemePlugin = {
    install: (app) => {
        app.config.globalProperties.$theme = themeManager;
        app.provide("theme", themeManager);
    },
};

// Composable for use in components
export const useTheme = () => {
    // Initialize on mount if not already initialized
    onMounted(() => {
        if (
            !document.documentElement.classList.contains("dark") &&
            !document.documentElement.classList.contains("light")
        ) {
            themeManager.initTheme();
        }
    });

    return {
        isDark: themeManager.isDark,
        toggleTheme: themeManager.toggleTheme,
    };
};
