<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { useDark, useToggle } from "@vueuse/core";
import { ref } from "vue";

import lightIcon from "../icons/Logo/icon.png";
import darkIcon from "../icons/Logo/darkicon.png";
import lightmode from "../icons/Mode/sun.png";
import darkmode from "../icons/Mode/moon.png";

import Start from "../Components/Home/About.vue";
import Footer from "../Components/Footers/Footer.vue";

const isDark = useDark();
const toggleDark = useToggle(isDark);

const mode = computed(() => (isDark.value ? darkmode : lightmode));
const iconSrc = computed(() => (isDark.value ? darkIcon : lightIcon));

defineProps({
    canLogin: {
        type: Boolean,
        required: true,
    },
    canRegister: {
        type: Boolean,
        required: true,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const open = ref(false);

// Close mobile menu when clicking outside
const closeMenu = () => {
    open.value = false;
};

// Close menu on route change
const handleRouteChange = () => {
    open.value = false;
};
</script>

<template>
    <div class="antialiased">
        <!-- Navbar -->
        <div class="relative text-white dark:bg-neutral-800 bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Logo and Brand -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="flex items-center space-x-2">
                            <img class="h-8 w-auto" :src="iconSrc" alt="Icon" />
                            <span
                                class="dark:text-white text-black text-xl md:text-3xl font-bold tracking-wider"
                            >
                                STATSTREAM
                            </span>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div
                        v-if="canLogin"
                        class="hidden md:flex items-center space-x-4"
                    >
                        <template v-if="$page.props.auth.user">
                            <Link
                                :href="route('dashboard')"
                                class="navbar-btn hover:bg-neutral-700 px-4 py-2 rounded-lg transition-colors"
                            >
                                Dashboard
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="navbar-btn hover:bg-neutral-700 px-4 py-2 rounded-lg transition-colors"
                            >
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="navbar-btn hover:bg-neutral-700 px-4 py-2 rounded-lg transition-colors"
                            >
                                Register
                            </Link>
                        </template>
                        <button
                            @click="toggleDark"
                            class="p-2 rounded-lg bg-stone-900 hover:bg-stone-700 dark:hover:bg-stone-400 dark:bg-white text-white transition-colors"
                        >
                            <img
                                class="h-6 w-6"
                                :src="mode"
                                alt="Dark Mode Icon"
                            />
                        </button>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button
                            @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-neutral-700 focus:outline-none"
                            :aria-expanded="open"
                        >
                            <span class="sr-only">Open main menu</span>
                            <svg
                                v-if="!open"
                                class="block h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                            <svg
                                v-else
                                class="block h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
            >
                <div
                    v-if="open"
                    class="md:hidden absolute w-full bg-neutral-800 z-50"
                >
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <template v-if="$page.props.auth.user">
                            <Link
                                :href="route('dashboard')"
                                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-neutral-700"
                            >
                                Dashboard
                            </Link>
                        </template>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-neutral-700"
                            >
                                Log in
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-neutral-700"
                            >
                                Register
                            </Link>
                        </template>
                        <button
                            @click="toggleDark"
                            class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-white hover:bg-neutral-700"
                        >
                            Dark Mode
                        </button>
                    </div>
                </div>
            </transition>
        </div>

        <Start />
        <Footer />
    </div>
</template>
