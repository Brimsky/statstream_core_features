<template>
    <AuthenticatedLayout>
        <div class="min-h-screen dark:bg-neutral-800 pb-12">
            <!-- Hero Section -->
            <div class="relative overflow-hidden py-12 lg:py-20">
                <!-- Background gradient -->
                <div class="absolute inset-0 dark:opacity-20 opacity-10">
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-blue-100 via-purple-100 to-teal-100 dark:from-purple-900 dark:via-blue-900 dark:to-teal-900 animate-gradient"
                    ></div>
                </div>

                <!-- Content -->
                <div
                    class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center"
                >
                    <h1
                        class="mb-6 text-4xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl animate-fade-in"
                    >
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500"
                        >
                            Timber Analytics Dashboard
                        </span>
                    </h1>
                    <p
                        class="max-w-2xl mx-auto text-lg font-normal text-gray-600 lg:text-xl dark:text-gray-300 animate-fade-in-delayed"
                    >
                        Empowering the timber industry with cutting-edge
                        analytics and insights that drive sustainable growth and
                        innovation.
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <!-- Timber Volume Card -->
                    <div
                        class="bg-white dark:bg-neutral-800 rounded-2xl shadow-xl dark:shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 transform hover:scale-[1.02] transition-all duration-300"
                    >
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2
                                    class="text-xl font-bold text-gray-800 dark:text-white"
                                >
                                    Total Timber Volume
                                </h2>
                                <div
                                    class="p-2 bg-blue-50 dark:bg-neutral-700 rounded-lg"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-blue-600 dark:text-purple-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <div class="flex items-center space-x-1">
                                    <span
                                        class="text-3xl font-bold text-gray-900 dark:text-white"
                                        >{{ timberCount }}</span
                                    >
                                    <span
                                        class="text-sm text-gray-500 dark:text-gray-400"
                                        >units</span
                                    >
                                </div>
                                <div
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200"
                                >
                                    +12.5%
                                </div>
                            </div>
                            <div
                                class="mt-4 h-2 bg-gray-100 dark:bg-neutral-700 rounded-full overflow-hidden"
                            >
                                <div
                                    class="h-full bg-gradient-to-r from-blue-500 to-teal-500 dark:from-purple-500 dark:to-blue-500"
                                    style="width: 75%"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- Users Card -->
                    <div
                        class="bg-white dark:bg-neutral-800 rounded-2xl shadow-xl dark:shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700 transform hover:scale-[1.02] transition-all duration-300"
                    >
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2
                                    class="text-xl font-bold text-gray-800 dark:text-white"
                                >
                                    Total Users
                                </h2>
                                <div
                                    class="p-2 bg-purple-50 dark:bg-neutral-700 rounded-lg"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-purple-600 dark:text-purple-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex items-baseline justify-between">
                                <div class="flex items-center space-x-1">
                                    <span
                                        class="text-3xl font-bold text-gray-900 dark:text-white"
                                        >{{ userCount }}</span
                                    >
                                    <span
                                        class="text-sm text-gray-500 dark:text-gray-400"
                                        >active</span
                                    >
                                </div>
                                <div
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200"
                                >
                                    +5.2%
                                </div>
                            </div>
                            <div
                                class="mt-4 h-2 bg-gray-100 dark:bg-neutral-700 rounded-full overflow-hidden"
                            >
                                <div
                                    class="h-full bg-gradient-to-r from-purple-500 to-pink-500 dark:from-purple-500 dark:to-blue-500"
                                    style="width: 65%"
                                ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import { useTheme } from "@/composables/useTheme";
import axios from "axios";

const { isDark, gradients } = useTheme();

// Computed gradient text class
const gradientTextClass = computed(() => gradients.text.value);

// State to store counts
const userCount = ref(0);
const timberCount = ref(0);

// Function to fetch user count
const fetchUserCount = async () => {
    try {
        const response = await axios.get('/api/user-count');
        userCount.value = response.data.count;
    } catch (error) {
        console.error('Error fetching user count:', error);
    }
};

// Function to fetch timber count
const fetchtimberCount = async () => {
    try {
        const response = await axios.get('/api/timber-count');
        timberCount.value = response.data.count;
    } catch (error) {
        console.error('Error fetching timber count:', error);
    }
};

// Fetch data on component mount
onMounted(() => {
    fetchtimberCount();
    fetchUserCount();
});

defineProps({
    auth: {
        user: Object,
    },
});
</script>

<style scoped>
@keyframes gradient {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.animate-gradient {
    animation: gradient 15s ease infinite;
    background-size: 200% 200%;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
}

.animate-fade-in-delayed {
    animation: fadeIn 0.6s ease-out 0.2s forwards;
    opacity: 0;
}
</style>
