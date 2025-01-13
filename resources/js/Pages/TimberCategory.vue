<template>
    <MainLayout>
        <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-neutral-900">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 bg-clip-text text-transparent mb-8">
                    Timber Species Overview
                </h1>

                <!-- Species Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <Link
                        v-for="item in species"
                        :key="item.name"
                        :href="route('timber.show', { species: item.name })"
                        class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700 hover:shadow-xl transition-shadow duration-200 cursor-pointer"
                    >
                        <div class="p-6">
                            <!-- Species Name -->
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                                {{ item.name }}
                            </h2>

                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Sellers -->
                                <div class="bg-gray-50 dark:bg-neutral-700/50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Sellers
                                    </div>
                                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ item.seller_count }}
                                    </div>
                                </div>

                                <!-- Listings -->
                                <div class="bg-gray-50 dark:bg-neutral-700/50 rounded-lg p-4">
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        Listings
                                    </div>
                                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-white">
                                        {{ item.listing_count }}
                                    </div>
                                </div>
                            </div>

                            <!-- Price Range -->
                            <div class="mt-4">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    Price Range
                                </div>
                                <div class="mt-1 flex items-baseline space-x-2">
                                    <span class="text-2xl font-semibold text-gray-900 dark:text-white">
                                        €{{ item.average_price }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        avg (€{{ item.min_price }} - €{{ item.max_price }})
                                    </span>
                                </div>
                            </div>

                            <!-- View Details Button -->
                            <div class="mt-6">
                                <div class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 dark:text-purple-400 bg-blue-50 dark:bg-neutral-700/50 rounded-lg hover:bg-blue-100 dark:hover:bg-neutral-600/50 transition-colors duration-200">
                                    View Details
                                    <ChevronRightIcon class="w-5 h-5 ml-2" />
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ChevronRightIcon } from '@heroicons/vue/24/outline';

defineProps({
    species: {
        type: Array,
        required: true
    }
});
</script>
