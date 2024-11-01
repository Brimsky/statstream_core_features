<template>
    <!-- Hero Section -->
    <section
        class="dark:bg-neutral-900 min-h-[85vh] flex items-center antialiased relative overflow-hidden"
    >
        <!-- Background gradient effect -->
        <div class="absolute inset-0 dark:opacity-20 opacity-10">
            <div
                class="absolute inset-0 bg-gradient-to-tr from-blue-100 via-purple-100 to-teal-100 dark:from-purple-900 dark:via-blue-900 dark:to-teal-900 animate-gradient"
            ></div>
        </div>

        <div
            class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12 relative"
        >
            <div class="max-w-4xl space-y-6">
                <h1
                    class="font-inter font-extrabold text-4xl sm:text-5xl lg:text-6xl text-wrap dark:text-white text-black tracking-tight"
                >
                    CHANGE THE WAY YOU
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:via-pink-500 dark:to-blue-500 animate-text"
                    >
                        ANALYZE
                    </span>
                </h1>
                <h1
                    class="font-inter font-extrabold text-4xl sm:text-5xl lg:text-7xl text-wrap bg-gradient-to-r from-blue-600 via-purple-500 to-teal-400 dark:from-purple-400 dark:via-pink-500 dark:to-blue-500 animate-text inline-block text-transparent bg-clip-text"
                >
                    TIMBER
                </h1>
                <p
                    class="font-inter text-lg sm:text-xl lg:text-2xl w-full md:w-2/3 lg:w-1/2 dark:text-gray-300 text-gray-700"
                >
                    Transform your analysis with comprehensive timber price
                    statistics,
                    <span
                        class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500"
                    >
                        redefining how you perceive market trends.
                    </span>
                </p>
                <div class="flex gap-4 flex-wrap">
                    <button
                        class="group relative px-6 py-3 font-semibold rounded-lg overflow-hidden bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-500 dark:to-blue-500 text-white transform transition-all hover:scale-105"
                    >
                        <span class="relative z-10">Start Now</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-teal-500 to-blue-600 dark:from-blue-500 dark:to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity"
                        ></div>
                    </button>
                    <button
                        class="px-6 py-3 font-semibold rounded-lg bg-white dark:bg-neutral-800 text-gray-800 dark:text-white hover:bg-gray-100 dark:hover:bg-neutral-700 transition-all hover:scale-105 border border-gray-200 dark:border-neutral-700"
                    >
                        Learn More
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-white dark:bg-neutral-900 relative">
        <div
            class="mx-auto max-w-screen-xl px-4 py-6 sm:py-10 shadow-2xl rounded-2xl bg-gradient-to-b from-white to-gray-50 dark:from-neutral-900 dark:to-neutral-800"
        >
            <div class="mx-auto max-w-3xl text-center px-4 mb-8">
                <h2
                    class="text-2xl sm:text-3xl lg:text-4xl font-bold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 inline-block text-transparent bg-clip-text mb-4"
                >
                    Trusted by STATSTREAM
                </h2>
                <p
                    class="text-base sm:text-lg lg:text-xl text-gray-600 dark:text-gray-300"
                >
                    Maximize your timber trade with our cutting-edge analytics
                    and market trends. Understand the ebbs and flows of wood
                    supply and demand with intuitive graphs and detailed
                    analytics.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div
                    class="flex flex-col rounded-xl bg-gradient-to-br from-white to-blue-50 dark:from-neutral-800 dark:to-purple-900/30 p-6 text-center transform transition-all hover:scale-105 border border-gray-100 dark:border-neutral-700"
                >
                    <dd
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 inline-block text-transparent bg-clip-text"
                    >
                        $17.3m
                    </dd>
                    <dt
                        class="order-last text-base sm:text-lg font-medium text-gray-600 dark:text-gray-300 mt-2"
                    >
                        Total Timber Sales in Industry
                    </dt>
                </div>

                <div
                    class="flex flex-col rounded-xl bg-gradient-to-br from-white to-blue-50 dark:from-neutral-800 dark:to-purple-900/30 p-6 text-center transform transition-all hover:scale-105 border border-gray-100 dark:border-neutral-700"
                >
                    <dd
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 inline-block text-transparent bg-clip-text"
                    >
                        18
                    </dd>
                    <dt
                        class="order-last text-base sm:text-lg font-medium text-gray-600 dark:text-gray-300 mt-2"
                    >
                        Custom Reports
                    </dt>
                </div>

                <div
                    class="flex flex-col rounded-xl bg-gradient-to-br from-white to-blue-50 dark:from-neutral-800 dark:to-purple-900/30 p-6 text-center transform transition-all hover:scale-105 border border-gray-100 dark:border-neutral-700"
                >
                    <dd
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 inline-block text-transparent bg-clip-text"
                    >
                        37
                    </dd>
                    <dt
                        class="order-last text-base sm:text-lg font-medium text-gray-600 dark:text-gray-300 mt-2"
                    >
                        Timber Varieties
                    </dt>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="dark:bg-neutral-900 bg-white">
        <div class="mx-auto max-w-screen-xl px-4 py-8">
            <div class="mx-auto max-w-lg text-center mb-12">
                <h2
                    class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 inline-block text-transparent bg-clip-text"
                >
                    Enhance Your Forestry Operations
                </h2>
                <p
                    class="text-base sm:text-lg text-gray-600 dark:text-gray-300"
                >
                    Deploy targeted marketing strategies with our digital
                    toolkit designed specifically for the timber industry.
                </p>
            </div>

            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12"
            >
                <template v-for="(feature, index) in features" :key="index">
                    <a
                        class="group block rounded-xl bg-gradient-to-br from-white to-gray-50 dark:from-neutral-800 dark:to-neutral-800/50 p-6 shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 border border-gray-100 dark:border-neutral-700 relative overflow-hidden"
                    >
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-teal-500/10 dark:from-purple-500/10 dark:to-blue-500/10 opacity-0 group-hover:opacity-100 transition-opacity"
                        ></div>
                        <span
                            class="text-3xl sm:text-4xl flex justify-center items-center mb-4"
                        >
                            {{ feature.icon }}
                        </span>
                        <h2
                            class="text-lg sm:text-xl font-bold text-gray-800 dark:text-gray-200 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-blue-600 group-hover:to-teal-500 dark:group-hover:from-purple-400 dark:group-hover:to-blue-500"
                        >
                            {{ feature.title }}
                        </h2>
                        <p
                            class="mt-2 text-sm text-gray-600 dark:text-gray-300"
                        >
                            {{ feature.description }}
                        </p>
                    </a>
                </template>
            </div>

            <div class="text-center">
                <a
                    href="#"
                    class="group relative inline-flex items-center justify-center px-8 py-3 font-semibold rounded-lg overflow-hidden bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-500 dark:to-blue-500 text-white transform transition-all hover:scale-105"
                >
                    <span class="relative z-10">Get Started Today</span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-teal-500 to-blue-600 dark:from-blue-500 dark:to-purple-500 opacity-0 group-hover:opacity-100 transition-opacity"
                    ></div>
                </a>
            </div>
        </div>
    </section>
</template>

<script setup>
const features = [
    {
        icon: "🌲",
        title: "Sustainable Growth Strategies",
        description:
            "Learn to market your eco-friendly practices effectively to reach a green-conscious audience.",
    },
    {
        icon: "🔍",
        title: "Market Trend Analysis",
        description:
            "Gain insights into the latest market trends, allowing you to adjust your strategies in real-time.",
    },
    {
        icon: "📊",
        title: "Data-Driven Sales Techniques",
        description:
            "Harness the power of analytics to refine your sales approach and target the right markets.",
    },
    {
        icon: "🤝",
        title: "Partnership Opportunities",
        description:
            "Discover potential partnership avenues to expand your reach and industry presence.",
    },
    {
        icon: "🛠",
        title: "Customizable Marketing Tools",
        description:
            "Utilize customizable digital marketing tools that cater to the unique aspects of timber industry.",
    },
];
</script>

<style>
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

@keyframes text {
    0%,
    100% {
        background-size: 200% 200%;
        background-position: left center;
    }
    50% {
        background-size: 200% 200%;
        background-position: right center;
    }
}

.animate-gradient {
    animation: gradient 15s ease infinite;
    background-size: 200% 200%;
}

.animate-text {
    animation: text 8s ease infinite;
}

@media (max-width: 640px) {
    .text-wrap {
        word-break: break-word;
    }
}
</style>
