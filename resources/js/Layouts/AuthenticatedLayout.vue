<template>
    <div class="min-h-screen">
        <nav
            class="bg-white dark:bg-neutral-800 border-b border-gray-100 dark:border-neutral-700"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <Link
                            :href="route('dashboard')"
                            class="flex items-center"
                        >
                            <img class="h-8 w-auto" :src="iconSrc" alt="Icon" />
                            <span
                                class="ml-2 text-2xl font-bold tracking-wider text-transparent bg-clip-text"
                                :class="gradientTextClass"
                            >
                                STATSTREAM
                            </span>
                        </Link>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:space-x-6">
                        <Link
                            :href="route('dashboard')"
                            class="text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-700 px-4 py-2 rounded-lg transition-colors duration-200"
                        >
                            Dashboard
                        </Link>
                        <Link
                            :href="route('timber-category.index')"
                            class="text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-700 px-4 py-2 rounded-lg transition-colors duration-200"
                        >
                            Timber
                        </Link>
                        <Link
                            v-if="user && user.vip_status"
                            :href="route('saved-materials.index')"
                            class="text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-700 px-4 py-2 rounded-lg transition-colors duration-200"
                        >
                            Saved Materials
                        </Link>

                        <!-- Theme Toggle Button -->
                        <button
                            @click="toggleTheme"
                            class="p-2 rounded-lg bg-stone-900 dark:bg-white hover:bg-stone-700 dark:hover:bg-stone-200 transition-colors duration-200"
                        >
                            <img
                                class="h-6 w-6"
                                :src="mode"
                                alt="Theme toggle"
                            />
                        </button>

                        <!-- User Dropdown -->
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    class="flex items-center text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-700 px-4 py-2 rounded-lg transition-colors duration-200"
                                >
                                    {{ user.name }}
                                    <svg
                                        class="ml-2 -mr-0.5 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink
                                    :href="route('profile.edit')"
                                    class="text-black dark:text-white"
                                    >Profile</DropdownLink
                                >
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                    class="text-black dark:text-white"
                                >
                                    Log Out
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden space-x-2">
                        <!-- Theme Toggle Button -->
                        <button
                            @click="toggleTheme"
                            class="p-2 rounded-lg bg-stone-900 dark:bg-white hover:bg-stone-700 dark:hover:bg-stone-200 transition-colors duration-200"
                        >
                            <img
                                class="h-6 w-6"
                                :src="mode"
                                alt="Theme toggle"
                            />
                        </button>

                        <!-- Menu Button -->
                        <button
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-neutral-700"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
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
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="md:hidden"
            >
                <div class="pt-2 pb-3 space-y-1">
                    <Link
                        :href="route('dashboard')"
                        class="block px-3 py-2 text-base font-medium text-black dark:text-white hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors duration-200"
                    >
                        Dashboard
                    </Link>
                    <Link
                        :href="route('timber-category.index')"
                        class="block px-3 py-2 text-base font-medium text-black dark:text-white hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors duration-200"
                    >
                        Timber
                    </Link>
                    <Link
                        v-if="user && user.vip_status"
                        :href="route('saved-materials.index')"
                        class="block px-3 py-2 text-base font-medium text-black dark:text-white hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors duration-200"
                    >
                        Saved Materials
                    </Link>
                </div>

                <!-- Mobile User Info -->
                <div
                    class="pt-4 pb-1 border-t border-gray-200 dark:border-neutral-700"
                >
                    <div class="px-4">
                        <div
                            class="font-medium text-base text-black dark:text-white"
                        >
                            {{ user.name }}
                        </div>
                        <div class="font-medium text-sm text-gray-500">
                            {{ user.email }}
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <Link
                            :href="route('profile.edit')"
                            class="block px-3 py-2 text-base font-medium text-black dark:text-white hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors duration-200"
                        >
                            Profile
                        </Link>
                        <Link
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="block w-full text-left px-3 py-2 text-base font-medium text-black dark:text-white hover:bg-gray-100 dark:hover:bg-neutral-700 transition-colors duration-200"
                        >
                            Log Out
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header
            class="bg-white dark:bg-neutral-800 shadow"
            v-if="$slots.header"
        >
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main class="bg-white dark:bg-neutral-800">
            <slot />
        </main>

        <Footer />
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Footer from "../Components/Footers/Footer.vue";

// Import icons
import lightIcon from "../icons/Logo/icon.png";
import darkIcon from "../icons/Logo/darkicon.png";
import lightmode from "../icons/Mode/sun.png";
import darkmode from "../icons/Mode/moon.png";

// Use theme manager
import { useTheme } from "@/Components/useTheme.js";

const { isDark, toggleTheme } = useTheme();

// Computed values for icons
const mode = computed(() => (isDark.value ? darkmode : lightmode));
const iconSrc = computed(() => (isDark.value ? darkIcon : lightIcon));

// Computed gradient text class
const gradientTextClass = computed(() =>
    isDark.value
        ? "bg-gradient-to-r from-purple-400 via-pink-400 to-blue-500"
        : "bg-gradient-to-r from-blue-600 via-cyan-500 to-emerald-500",
);

const { user } = usePage().props.auth;
const showingNavigationDropdown = ref(false);
</script>

<style scoped>
.transition-colors {
    transition-property: background-color, border-color, color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

.navbar-btn {
    @apply text-black dark:text-white hover:bg-neutral-100 dark:hover:bg-neutral-700 px-4 py-2 rounded-lg transition-colors duration-200;
}
</style>
