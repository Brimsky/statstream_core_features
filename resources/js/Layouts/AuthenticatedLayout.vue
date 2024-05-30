<script setup>
import { ref, computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import Footer from '../Components/Footers/Footer.vue';
import { usePage } from '@inertiajs/vue3';
import { useDark, useToggle } from '@vueuse/core';

import lightIcon from '../icons/Logo/icon.png';
import darkIcon from '../icons/Logo/darkicon.png';

import lightmode from '../icons/Mode/sun.png';
import darkmode from '../icons/Mode/moon.png';

const isDark = useDark();
const toggleDark = useToggle(isDark);

const mode = computed(() => (isDark.value ? darkmode : lightmode));
const iconSrc = computed(() => (isDark.value ? darkIcon : lightIcon));

const { user } = usePage().props.auth;
const showingNavigationDropdown = ref(false);

const toggleNavigationDropdown = () => {
  showingNavigationDropdown.value = !showingNavigationDropdown.value;
};
</script>

<template>
  <div>
    <div class="min-h-screen dark:bg-neutral-800 bg-white">
      <!-- Navbar -->
      <div class="text-white dark:bg-neutral-800 flex h-[60px] m-0 px-[35px] py-0">
        <div class="flex items-center justify-between mx-auto w-11/12">
          <!-- Logo and Title -->
          <div class="flex items-center space-x-2">
            <a href="/">
              <img class="h-10" :src="iconSrc" alt="Icon" />
            </a>
            <a href="/" class="dark:text-white text-black text-3xl tracking-wider font-bold">STATSTREAM</a>
          </div>
          <!-- Links and Toggle Button -->
          <div class="hidden md:flex items-center space-x-6">
            <Link :href="route('dashboard')" class="navbar-btn">Dashboard</Link>
            <Link :href="route('timber-category.index')" class="navbar-btn">Timber</Link>
            <Link v-if="user && user.vip_status" :href="route('saved-materials.index')" class="navbar-btn">Saved Materials</Link>
            <button @click="toggleDark()"
                  class="py-2 px-6 bg-stone-900 hover:bg-stone-700 dark:hover:bg-stone-400 dark:bg-white  text-white font-bold rounded-xl shadow-md transition duration-150">
            <img class="h-7" :src="mode" alt="Dark Mode Icon" />
          </button>
            <!-- User Dropdown -->
            <div class="relative">
              <Dropdown align="right" width="48">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                      {{ user.name }}
                      <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                      </svg>
                    </button>
                  </span>
                </template>

                <template #content>
                  <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                  <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
                </template>
              </Dropdown>
            </div>
          </div>

          
          <!-- Mobile Menu Button -->
          <div class="flex md:hidden items-center">
              <button @click="toggleDark() "
                    class="py-2 px-6 bg-stone-900 hover:bg-stone-700 dark:hover:bg-stone-400 dark:bg-white  text-white font-bold rounded-xl shadow-md transition duration-150">
              <img class="h-7" :src="mode" alt="Dark Mode Icon" />
            </button>
            <button @click="toggleNavigationDropdown" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out">
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                <path :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Navigation Menu -->
      <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="md:hidden">
        <div class="pt-2 pb-3 space-y-1">
          <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</ResponsiveNavLink>
          <ResponsiveNavLink :href="route('timber-category.index')" :active="route().current('timber-category.index')">Timber Category</ResponsiveNavLink>
          <ResponsiveNavLink v-if="user && user.vip_status" :href="route('saved-materials.index')" :active="route().current('saved-materials.index')">Saved Materials</ResponsiveNavLink>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
          <div class="px-4">
            <div class="font-medium text-base text-gray-800">{{ user.name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ user.email }}</div>
          </div>
          <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('profile.edit')">Profile</ResponsiveNavLink>
            <ResponsiveNavLink :href="route('logout')" method="post" as="button">Log Out</ResponsiveNavLink>
          </div>
        </div>
      </div>

      <!-- Page Heading -->
      <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>
      <!-- Page Content -->
      <main class="dark:bg-neutral-800 bg-white">
        <slot />
      </main>
    </div>
    <Footer />
  </div>
</template>
