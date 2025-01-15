<template>
    <AuthenticatedLayout>
        <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            Saved Materials
                        </h1>

                        <!-- Sort Controls -->
                        <div class="mb-6">
                            <label for="sort" class="text-sm font-medium text-gray-700 dark:text-gray-300">Sort by:</label>
                            <select
                                id="sort"
                                v-model="sortCriterion"
                                @change="sortMaterials"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                            >
                                <option value="price">Price</option>
                                <option value="species">Species</option>
                                <option value="date">Date</option>
                            </select>
                        </div>

                        <!-- Materials List -->
                        <div v-if="sortedMaterials.length" class="space-y-6">
                            <div
                                v-for="material in sortedMaterials"
                                :key="material.id"
                                class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6 transition-all hover:shadow-md"
                            >
                                <div class="flex flex-col md:flex-row justify-between gap-4">
                                    <!-- Material Info -->
                                    <div class="space-y-4">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ material.timber_species.speacies }}
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Added on {{ formatDate(material.timber_species.date) }}
                                            </p>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Type</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ material.timber_species.seller }}</p>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Class</p>
                                                <p class="font-medium text-gray-900 dark:text-white">{{ material.timber_species.class }}</p>
                                            </div>
                                            <div class="space-y-1">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Dimensions</p>
                                                <p class="font-medium text-gray-900 dark:text-white">
                                                    {{ material.timber_species.diameter }}mm × {{ material.timber_species.length }}m
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price and Actions -->
                                    <div class="flex flex-col justify-between items-end">
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Price</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                                ${{ material.timber_species.price }}
                                            </p>
                                        </div>
                                        <button
                                            @click="deleteMaterial(material.id)"
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div
                            v-else
                            class="text-center py-12 px-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg"
                        >
                            <p class="text-gray-500 dark:text-gray-400">
                                No saved materials yet. Start by saving some materials from the price comparison page.
                            </p>
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
import { ref, computed } from "vue";
import { useTheme } from "@/composables/useTheme";

const { isDark, gradients } = useTheme();

// Computed gradient text class
const gradientTextClass = computed(() => gradients.text.value);

const logicon = computed(() => require("../icons/timber/logs.png"));

const props = defineProps({
    auth: {
        user: Object,
    },
    savedMaterials: {
        type: Array,
        default: () => [],
    },
});

const savedMaterials = computed(() => props.savedMaterials ?? []);

const sortCriterion = ref(props.sort || "species");

const sortedMaterials = computed(() => {
    return [...savedMaterials.value].sort((a, b) => {
        if (sortCriterion.value === "price") {
            return a.timber_species.price - b.timber_species.price;
        } else if (sortCriterion.value === "date") {
            return (
                new Date(a.timber_species.date) -
                new Date(b.timber_species.date)
            );
        } else {
            return a.timber_species.speacies.localeCompare(
                b.timber_species.speacies,
            );
        }
    });
});

const sortMaterials = () => {
    // Inertia.visit(window.location.href.split("?")[0], {
    //     method: "get",
    //     data: { sort: sortCriterion.value },
    //     preserveState: true,
    // });
};

const deleteMaterial = (id) => {
    if (confirm("Are you sure you want to delete this material?")) {
        // Inertia.delete(`/saved-materials/${id}`, {
        //     onSuccess: () => {
        //         window.location.reload(); // Force a full-page reload
        //     },
        // });
    }
};

// watch(sortCriterion, sortMaterials);

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString();
};
</script>
