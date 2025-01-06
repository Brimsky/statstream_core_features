import { ref, onMounted, watch, computed } from 'vue';

// Create a global theme state
const isDark = ref(false);

// Theme composable
export function useTheme() {
    // Apply theme to document and save to localStorage
    const applyTheme = (dark) => {
        // Update DOM
        if (dark) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        }
        
        // Save to localStorage
        localStorage.setItem('theme', dark ? 'dark' : 'light');
        isDark.value = dark;
    };

    // Initialize theme
    const initTheme = () => {
        // Check localStorage first
        const savedTheme = localStorage.getItem('theme');
        
        if (savedTheme) {
            applyTheme(savedTheme === 'dark');
        } else {
            // Check system preference
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            applyTheme(prefersDark);
        }
    };

    // Toggle theme
    const toggleTheme = () => {
        applyTheme(!isDark.value);
    };

    // Watch for system theme changes
    const watchSystemTheme = () => {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches);
            }
        });
    };

    // Initialize on mount
    onMounted(() => {
        initTheme();
        watchSystemTheme();
    });

    // Watch theme changes
    watch(isDark, (newValue) => {
        applyTheme(newValue);
    }, { immediate: true });

    return {
        isDark,
        toggleTheme,
        // Theme-specific values
        icons: {
            logo: computed(() => isDark.value ? '/icons/Logo/darkicon.png' : '/icons/Logo/icon.png'),
            theme: computed(() => isDark.value ? '/icons/Mode/moon.png' : '/icons/Mode/sun.png')
        },
        gradients: {
            text: computed(() => isDark.value
                ? 'bg-gradient-to-r from-purple-400 via-pink-400 to-blue-500'
                : 'bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-500'
            )
        }
    };
}
