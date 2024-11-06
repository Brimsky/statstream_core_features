<template>
    <AuthenticatedLayout>
        <div class="container mx-auto px-4 py-10 dark:bg-neutral-800 bg-white">
            <div class="p-6 rounded-xl dark:bg-neutral-800 bg-white shadow-md">
                <h4
                    class="text-xl font-semibold dark:text-white text-black mb-4"
                >
                    Saved Materials
                </h4>
                <div class="mb-4">
                    <label for="sort" class="dark:text-white text-black"
                        >Sort by:</label
                    >
                    <select
                        id="sort"
                        v-model="sortCriterion"
                        @change="sortMaterials"
                        class="ml-2 p-1 rounded"
                    >
                        <option value="price">Price</option>
                        <option value="species">Species</option>
                        <option value="date">Date</option>
                    </select>
                </div>

                <div v-if="sortedMaterials.length">
                    <div class="space-y-4">
                        <div
                            v-for="material in sortedMaterials"
                            :key="material.id"
                            class="p-4 bg-white dark:bg-neutral-800 shadow-md hover:shadow-lg rounded-md relative"
                        >
                            <button
                                @click="deleteMaterial(material.id)"
                                class="absolute top-2 right-2 text-red-500"
                            >
                                Delete
                            </button>
                            <div class="flex items-center space-x-4 mb-4">
                                <div
                                    class="w-20 h-20 flex items-center justify-center rounded-md"
                                >
                                    <img
                                        class="w-full h-full object-contain"
                                        :src="logicon"
                                    />
                                </div>
                                <div>
                                    <h5
                                        class="text-sm font-semibold text-black dark:text-white"
                                    >
                                        {{ material.timber_species.speacies }}
                                    </h5>
                                    <h5
                                        class="text-sm font-semibold text-black dark:text-white"
                                    >
                                        {{ material.timber_species.seller }}
                                    </h5>
                                    <span
                                        class="text-xs font-medium text-black dark:text-white"
                                        >Class:
                                        {{
                                            material.timber_species.class
                                        }}</span
                                    >
                                </div>
                            </div>
                            <div
                                class="grid grid-cols-2 gap-4 text-black dark:text-white"
                            >
                                <div>
                                    <p>
                                        <strong>Location:</strong>
                                        {{ material.timber_species.location }}
                                    </p>
                                    <p>
                                        <strong>Length:</strong>
                                        {{ material.timber_species.length }} m
                                    </p>
                                </div>
                                <div>
                                    <p>
                                        <strong>Diameter:</strong>
                                        {{
                                            material.timber_species.diameter
                                        }}
                                        cm
                                    </p>
                                    <p>
                                        <strong>Date Recorded:</strong>
                                        {{ material.timber_species.date }}
                                    </p>
                                    <p>
                                        <strong>Current Price:</strong>
                                        {{ material.timber_species.price }} $
                                    </p>
                                    <p>
                                        <strong>Initial Price:</strong>
                                        {{ material.initial_price }} $
                                    </p>
                                    <p>
                                        <strong>Price Change:</strong>
                                        {{ material.price_change }} $ ({{
                                            material.price_change_percentage.toFixed(
                                                2,
                                            )
                                        }}%)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <p class="text-white">No materials saved yet.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Inertia } from "@inertiajs/inertia";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import timberlog from "../icons/timber/logs.png";
import { useTheme } from "@/Components/useTheme.js";

const { isDark, toggleTheme } = useTheme();

const logicon = computed(() => timberlog);

const { props } = usePage();
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
    Inertia.visit(window.location.href.split("?")[0], {
        method: "get",
        data: { sort: sortCriterion.value },
        preserveState: true,
    });
};

const deleteMaterial = (id) => {
    if (confirm("Are you sure you want to delete this material?")) {
        Inertia.delete(`/saved-materials/${id}`, {
            onSuccess: () => {
                window.location.reload(); // Force a full-page reload
            },
        });
    }
};

watch(sortCriterion, sortMaterials);
</script>
