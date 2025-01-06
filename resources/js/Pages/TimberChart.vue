<template>
    <AuthenticatedLayout>
        <div
            class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-neutral-900"
        >
            <!-- Header Section -->
            <div class="max-w-7xl mx-auto mb-8">
                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 bg-clip-text text-transparent"
                >
                    {{ species }} Analysis
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    Detailed market analysis and price comparison
                </p>
            </div>

            <!-- Main Content -->
            <div class="max-w-7xl mx-auto">
                <!-- Flex container for chart and filters -->
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Chart Container -->
                    <div class="flex-grow">
                        <div
                            class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700 overflow-hidden"
                        >
                            <div
                                class="p-4 border-b border-gray-100 dark:border-neutral-700"
                            >
                                <h2
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    Price Comparison
                                </h2>
                            </div>
                            <div
                                ref="chartContainer"
                                class="h-96 w-full p-4"
                            ></div>
                            <div
                                ref="legendContainer"
                                class="flex flex-wrap justify-center gap-4 p-4 border-t border-gray-100 dark:border-neutral-700"
                            ></div>
                        </div>
                    </div>

                    <!-- Filters Panel -->
                    <div class="lg:w-80">
                        <div
                            class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700"
                        >
                            <div
                                class="p-4 border-b border-gray-100 dark:border-neutral-700"
                            >
                                <h2
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    Filters
                                </h2>
                            </div>
                            <div class="p-4 space-y-4">
                                <FilterSelect
                                    v-for="(filter, index) in filters"
                                    :key="index"
                                    v-model="filterValues[filter.key]"
                                    :label="filter.label"
                                    :options="filter.options"
                                    class="w-full"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="user && user.vip_status" class="mt-8">
                    <div
                        class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700 overflow-hidden"
                    >
                        <div
                            class="p-4 border-b border-gray-100 dark:border-neutral-700"
                        >
                            <h2
                                class="text-lg font-semibold text-gray-900 dark:text-white"
                            >
                                Detailed Listings
                            </h2>
                        </div>
                        <div
                            class="divide-y divide-gray-100 dark:divide-neutral-700"
                        >
                            <div
                                v-for="entry in filteredEntries"
                                :key="entry.id"
                                class="p-6 hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition-colors duration-200"
                            >
                                <div class="flex flex-col md:flex-row gap-6">
                                    <!-- Company and Product Image Section -->
                                    <div class="flex items-start space-x-6">
                                        <div
                                            class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0 bg-gradient-to-br from-blue-50 to-teal-50 dark:from-neutral-700 dark:to-neutral-600 p-2"
                                        >
                                            <img
                                                :src="logicon"
                                                alt="Timber log"
                                                class="w-full h-full object-contain"
                                            />
                                        </div>
                                        <div>
                                            <h3
                                                class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2"
                                            >
                                                <BuildingOffice2Icon
                                                    class="w-6 h-6 text-blue-500 dark:text-purple-400"
                                                />
                                                {{ entry.seller }}
                                            </h3>
                                            <div
                                                class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4"
                                            >
                                                <!-- Species -->
                                                <div
                                                    class="flex items-center space-x-2"
                                                >
                                                    <div
                                                        class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700"
                                                    >
                                                        <TreeIcon
                                                            class="w-5 h-5 text-blue-500 dark:text-purple-400"
                                                        />
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-sm text-gray-500 dark:text-gray-400"
                                                        >
                                                            Species
                                                        </div>
                                                        <div
                                                            class="font-medium text-gray-900 dark:text-white"
                                                        >
                                                            {{ entry.speacies }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Class -->
                                                <div
                                                    class="flex items-center space-x-2"
                                                >
                                                    <div
                                                        class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700"
                                                    >
                                                        <TagIcon
                                                            class="w-5 h-5 text-blue-500 dark:text-purple-400"
                                                        />
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-sm text-gray-500 dark:text-gray-400"
                                                        >
                                                            Class
                                                        </div>
                                                        <div
                                                            class="font-medium text-gray-900 dark:text-white"
                                                        >
                                                            {{ entry.class }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Type -->
                                                <div
                                                    class="flex items-center space-x-2"
                                                >
                                                    <div
                                                        class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700"
                                                    >
                                                        <Squares2X2Icon
                                                            class="w-5 h-5 text-blue-500 dark:text-purple-400"
                                                        />
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-sm text-gray-500 dark:text-gray-400"
                                                        >
                                                            Type
                                                        </div>
                                                        <div
                                                            class="font-medium text-gray-900 dark:text-white"
                                                        >
                                                            {{ entry.type }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diameter -->
                                                <div
                                                    class="flex items-center space-x-2"
                                                >
                                                    <div
                                                        class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700"
                                                    >
                                                        <ArrowsPointingOutIcon
                                                            class="w-5 h-5 text-blue-500 dark:text-purple-400"
                                                        />
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-sm text-gray-500 dark:text-gray-400"
                                                        >
                                                            Diameter
                                                        </div>
                                                        <div
                                                            class="font-medium text-gray-900 dark:text-white"
                                                        >
                                                            {{ entry.diameter }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Length -->
                                                <div
                                                    class="flex items-center space-x-2"
                                                >
                                                    <div
                                                        class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700"
                                                    >
                                                        <ArrowsRightLeftIcon
                                                            class="w-5 h-5 text-blue-500 dark:text-purple-400"
                                                        />
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-sm text-gray-500 dark:text-gray-400"
                                                        >
                                                            Length
                                                        </div>
                                                        <div
                                                            class="font-medium text-gray-900 dark:text-white"
                                                        >
                                                            {{ entry.length }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Location -->
                                                <div
                                                    class="flex items-center space-x-2"
                                                >
                                                    <div
                                                        class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700"
                                                    >
                                                        <MapPinIcon
                                                            class="w-5 h-5 text-blue-500 dark:text-purple-400"
                                                        />
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="text-sm text-gray-500 dark:text-gray-400"
                                                        >
                                                            Location
                                                        </div>
                                                        <div
                                                            class="font-medium text-gray-900 dark:text-white"
                                                        >
                                                            {{ entry.location }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price and Actions -->
                                    <div
                                        class="flex-grow flex flex-col md:items-end justify-between"
                                    >
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700"
                                            >
                                                <CurrencyDollarIcon
                                                    class="w-6 h-6 text-blue-500 dark:text-purple-400"
                                                />
                                            </div>
                                            <div
                                                class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 bg-clip-text text-transparent"
                                            >
                                                ${{ entry.price }}
                                            </div>
                                        </div>
                                        <div class="flex gap-3 mt-4">
                                            <button
                                                @click="saveMaterial(entry.id)"
                                                class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-500 dark:to-blue-600 text-white rounded-lg hover:opacity-90 transition-opacity duration-200"
                                            >
                                                <BookmarkIcon class="w-5 h-5" />
                                                Save
                                            </button>
                                            <a
                                                :href="entry.url"
                                                target="_blank"
                                                class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-neutral-700 text-gray-900 dark:text-white rounded-lg hover:opacity-90 transition-opacity duration-200"
                                            >
                                                <ArrowTopRightOnSquareIcon
                                                    class="w-5 h-5"
                                                />
                                                Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
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
import { defineProps, ref, computed, onMounted, watchEffect } from "vue";
import * as echarts from "echarts";
import { usePage } from "@inertiajs/vue3";
import FilterSelect from "@/Components/FilterSelect.vue";
import timberlog from "../icons/timber/logs.png";
import { useTheme } from "@/composables/useTheme";

const { isDark, gradients } = useTheme();

const logicon = computed(() => timberlog);
const { user } = usePage().props.auth;

const props = defineProps({
    entries: Array,
    species: String,
});

// Initialize entries as an empty array if undefined
const entries = ref(props.entries || []);
if (!Array.isArray(entries.value)) {
    entries.value = [];
    console.error("Entries is not an array:", props.entries);
}

const chartContainer = ref(null);
const legendContainer = ref(null);
const filterSeller = ref("");
const filterClass = ref("");
const filterDiameter = ref("");
const filterLength = ref("");
const filterLocation = ref("");
const filterType = ref("");

// Ensure data is sorted in descending order
function sortDescending(arr) {
    return arr.sort((a, b) => {
        if (typeof a === "string" && typeof b === "string") {
            return b.localeCompare(a);
        }
        return 0;
    });
}

// Compute filtered entries based on multiple criteria

const uniqueSellers = computed(() => {
    const sellers = new Set(entries.value.map((entry) => entry.seller));
    return sortDescending(Array.from(sellers));
});
const uniqueClass = computed(() => {
    const classs = new Set(entries.value.map((entry) => entry.class));
    return sortDescending(Array.from(classs));
});

const uniqueDiameter = computed(() => {
    const diameters = new Set(entries.value.map((entry) => entry.diameter));
    return sortDescending(Array.from(diameters));
});

const uniqueLength = computed(() => {
    const lengths = new Set(entries.value.map((entry) => entry.length));
    return sortDescending(Array.from(lengths));
});

const uniqueLocation = computed(() => {
    const locations = new Set(entries.value.map((entry) => entry.location));
    return sortDescending(Array.from(locations));
});

const uniqueType = computed(() => {
    const types = new Set(entries.value.map((entry) => entry.type));
    return sortDescending(Array.from(types));
});

const saveMaterial = async (timberSpeciesId) => {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    try {
        const response = await fetch("/api/save-material", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ liked_material: timberSpeciesId }),
        });

        if (!response.ok) {
            throw new Error(
                `Failed to save timber, status: ${response.status}`,
            );
        }

        const data = await response.json();
        console.log("Save successful:", data);
    } catch (error) {
        console.error("Error saving timber:", error);
    }
};

watchEffect(() => {
    updateChart();
});

onMounted(() => {
    updateChart();
});

function updateChart() {
    const container = chartContainer.value;
    const legendContainerElement = legendContainer.value;
    if (!container || !legendContainerElement) {
        console.error("Chart container or legend container not found");
        return;
    }

    // Clear the existing legend
    while (legendContainerElement.firstChild) {
        legendContainerElement.removeChild(legendContainerElement.firstChild);
    }

    const chart = echarts.init(container);

    const filteredData = filteredEntries.value;
    const xAxisData = filteredData.map((entry) => entry.seller);
    const yAxisData = filteredData.map((entry) => ({
        price: entry.price,
        class: entry.class,
        location: entry.location,
        length: entry.length,
        speacies: entry.speacies,
        diameter: entry.diameter,
        type: entry.type,
    }));

    const sellerColors = {};
    filteredData.forEach((entry) => {
        if (!sellerColors[entry.seller]) {
            sellerColors[entry.seller] = echarts.color.random();
        }
    });

    chart.setOption({
        tooltip: {
            trigger: "axis",
            axisPointer: {
                type: "shadow",
            },
            formatter: function (params) {
                const dataIndex = params[0].dataIndex;
                const tooltipContent = [
                    "Speacies: " + yAxisData[dataIndex].speacies,
                    "Length: " + yAxisData[dataIndex].length,
                    "Class: " + yAxisData[dataIndex].class,
                    "Diameter: " + yAxisData[dataIndex].diameter,
                    "Type: " + yAxisData[dataIndex].type,
                    "Location: " + yAxisData[dataIndex].location,
                    "Price: " + params[0].value,
                ];
                return tooltipContent.join("<br>");
            },
        },
        xAxis: {
            type: "category",
            data: xAxisData,
            axisLabel: {
                color: getCurrentTextColor(),
            },
        },
        yAxis: {
            type: "value",
            axisLabel: {
                color: getCurrentTextColor(),
            },
        },
        series: [
            {
                name: "Price",
                type: "bar",
                data: yAxisData.map((item, index) => ({
                    value: item.price,
                    itemStyle: { color: sellerColors[xAxisData[index]] },
                })),
            },
        ],
    });

    // Add legend manually below the chart
    Object.entries(sellerColors).forEach(([seller, color]) => {
        const legendItem = document.createElement("div");
        legendItem.style.display = "flex";
        legendItem.style.alignItems = "center";
        legendItem.style.margin = "0 10px";

        const colorBox = document.createElement("span");
        colorBox.style.display = "inline-block";
        colorBox.style.width = "12px";
        colorBox.style.height = "12px";
        colorBox.style.backgroundColor = color;
        colorBox.style.marginRight = "5px";

        const sellerName = document.createElement("span");
        sellerName.textContent = seller;
        sellerName.style.color = getCurrentTextColor();

        legendItem.appendChild(colorBox);
        legendItem.appendChild(sellerName);

        legendContainerElement.appendChild(legendItem);
    });
}

function getCurrentTextColor() {
    const body = document.body;
    if (body.classList.contains("dark")) {
        return "white";
    } else {
        return "black";
    }
}

const filters = computed(() => [
    { key: "seller", label: "Filter by Seller", options: uniqueSellers.value },
    { key: "type", label: "Filter by Type", options: uniqueType.value },
    { key: "class", label: "Filter by Class", options: uniqueClass.value },
    {
        key: "diameter",
        label: "Filter by Diameter",
        options: uniqueDiameter.value,
    },
    { key: "length", label: "Filter by Length", options: uniqueLength.value },
    {
        key: "location",
        label: "Filter by Location",
        options: uniqueLocation.value,
    },
]);

const filterValues = ref({
    seller: "",
    type: "",
    class: "",
    diameter: "",
    length: "",
    location: "",
});

// Update filteredEntries computed to use filterValues
const filteredEntries = computed(() => {
    return entries.value
        .filter(
            (entry) =>
                (!filterValues.value.seller ||
                    entry.seller
                        .toLowerCase()
                        .includes(filterValues.value.seller.toLowerCase())) &&
                (!filterValues.value.type ||
                    entry.type === filterValues.value.type) &&
                (!filterValues.value.class ||
                    entry.class === filterValues.value.class) &&
                (!filterValues.value.diameter ||
                    entry.diameter == filterValues.value.diameter) &&
                (!filterValues.value.length ||
                    entry.length == filterValues.value.length) &&
                (!filterValues.value.location ||
                    entry.location
                        .toLowerCase()
                        .includes(filterValues.value.location.toLowerCase())),
        )
        .sort((a, b) => b.seller.localeCompare(a.seller));
});
</script>
