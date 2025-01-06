import { defineStore } from 'pinia';

export const useThemeStore = defineStore('theme', {
    state: () => ({
        isDark: false,
        initialized: false
    }),

    actions: {
        initialize() {
            if (this.initialized) return;

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme) {
                this.isDark = savedTheme === 'dark';
            } else {
                this.isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }

            this.applyTheme();
            this.initialized = true;
        },

        applyTheme() {
            document.documentElement.classList.toggle('dark', this.isDark);
            localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
        },

        toggleTheme() {
            this.isDark = !this.isDark;
            this.applyTheme();
        }
    }
});
