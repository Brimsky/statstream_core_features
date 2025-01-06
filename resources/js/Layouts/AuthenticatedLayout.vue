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
                            class="nav-link"
                        >
                            Dashboard
                        </Link>
                        <Link
                            :href="route('timber-category.index')"
                            class="nav-link"
                        >
                            Timber
                        </Link>
                        <Link
                            v-if="user && user.vip_status"
                            :href="route('saved-materials.index')"
                            class="nav-link"
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
                        <div class="relative ml-3">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-100 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        <div>{{ user.name }}</div>

                                        <div class="ml-1">
                                            <svg
                                                class="fill-current h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </div>
                                    </button>
                                </template>

                                <template #content>
                                    <DropdownLink
                                        :href="route('profile.edit')"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                                    >
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                                    >
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
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
import { Link, usePage } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Footer from "../Components/Footers/Footer.vue";
import { useTheme } from "@/composables/useTheme";

// Import icons
import lightIcon from "../icons/Logo/icon.png";
import darkIcon from "../icons/Logo/darkicon.png";
import lightmode from "../icons/Mode/sun.png";
import darkmode from "../icons/Mode/moon.png";

// Use theme composable
const { isDark, toggleTheme, icons, gradients } = useTheme();

// Computed values for icons
const mode = computed(() => isDark.value ? darkmode : lightmode);
const iconSrc = computed(() => isDark.value ? darkIcon : lightIcon);

// Computed gradient text class
const gradientTextClass = computed(() => gradients.text.value);

const { user } = usePage().props.auth;
const showingNavigationDropdown = ref(false);
</script>

<style>
/* Remove duplicate styles since they're now in app.css */
</style>
