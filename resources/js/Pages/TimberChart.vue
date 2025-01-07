<template>
    <MainLayout>
        <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-neutral-900">
            <div class="max-w-7xl mx-auto mb-8">
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 bg-clip-text text-transparent">
                    {{ species }} Analysis
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    Detailed market analysis and price comparison
                </p>
            </div>

            <div class="max-w-7xl mx-auto">
                <!-- Flex container for chart and filters -->
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Chart Container -->
                    <div class="flex-grow">
                        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 dark:border-neutral-700">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Price Comparison
                                </h2>
                            </div>
                            <div ref="chartContainer" class="h-96 w-full p-4"></div>
                            <div ref="legendContainer" class="flex flex-wrap justify-center gap-4 p-4 border-t border-gray-100 dark:border-neutral-700"></div>
                        </div>
                    </div>

                    <!-- Filters Panel -->
                    <div class="lg:w-80">
                        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700">
                            <div class="p-4 border-b border-gray-100 dark:border-neutral-700 flex justify-between items-center">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Filters
                                </h2>
                                <button 
                                    @click="clearFilters"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-600 rounded-lg border border-gray-200 dark:border-neutral-600 transition-colors duration-200"
                                >
                                    <XCircleIcon class="w-4 h-4 mr-1.5" />
                                    Clear Filters
                                </button>
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

                <div class="mt-8">
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700 overflow-hidden">
                        <div class="p-4 border-b border-gray-100 dark:border-neutral-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Detailed Listings
                            </h2>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-neutral-700">
                            <div v-for="entry in filteredEntries" :key="entry.id" class="p-6 hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition-colors duration-200">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <!-- Company and Product Image Section -->
                                    <div class="flex items-start space-x-6">
                                        <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0 bg-gradient-to-br from-blue-50 to-teal-50 dark:from-neutral-700 dark:to-neutral-600 p-2">
                                            <img :src="logicon" alt="Timber log" class="w-full h-full object-contain" />
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                                <BuildingOffice2Icon class="w-6 h-6 text-blue-500 dark:text-purple-400" />
                                                {{ entry.seller }}
                                            </h3>
                                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                <!-- Species -->
                                                <div class="flex items-center space-x-2">
                                                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700">
                                                        <PuzzlePieceIcon class="w-5 h-5 text-blue-500 dark:text-purple-400" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            Species
                                                        </div>
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            {{ entry.species }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Class -->
                                                <div class="flex items-center space-x-2">
                                                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700">
                                                        <TagIcon class="w-5 h-5 text-blue-500 dark:text-purple-400" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            Class
                                                        </div>
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            {{ entry.class }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Type -->
                                                <div class="flex items-center space-x-2">
                                                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700">
                                                        <Squares2X2Icon class="w-5 h-5 text-blue-500 dark:text-purple-400" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            Type
                                                        </div>
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            {{ entry.type }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Diameter -->
                                                <div class="flex items-center space-x-2">
                                                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700">
                                                        <ArrowsPointingOutIcon class="w-5 h-5 text-blue-500 dark:text-purple-400" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            Diameter
                                                        </div>
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            {{ entry.diameter }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Length -->
                                                <div class="flex items-center space-x-2">
                                                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700">
                                                        <ArrowsRightLeftIcon class="w-5 h-5 text-blue-500 dark:text-purple-400" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            Length
                                                        </div>
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            {{ entry.length }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Location -->
                                                <div class="flex items-center space-x-2">
                                                    <div class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700">
                                                        <MapPinIcon class="w-5 h-5 text-blue-500 dark:text-purple-400" />
                                                    </div>
                                                    <div>
                                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                                            Location
                                                        </div>
                                                        <div class="font-medium text-gray-900 dark:text-white">
                                                            {{ entry.location }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price and Actions -->
                                    <div class="flex-grow flex flex-col md:items-end justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="p-2 rounded-lg bg-blue-50 dark:bg-neutral-700">
                                                <CurrencyDollarIcon class="w-6 h-6 text-blue-500 dark:text-purple-400" />
                                            </div>
                                            <div class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 bg-clip-text text-transparent">
                                                €{{ entry.price }}
                                            </div>
                                        </div>
                                        <div class="flex gap-3 mt-4">
                                            <a :href="entry.url" target="_blank" class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-neutral-700 text-gray-900 dark:text-white rounded-lg hover:opacity-90 transition-opacity duration-200">
                                                <ArrowTopRightOnSquareIcon class="w-5 h-5" />
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
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { defineProps, ref, computed, onMounted, onUnmounted, watchEffect } from "vue";
import * as echarts from "echarts";
import FilterSelect from "@/Components/FilterSelect.vue";
import {
    BuildingOffice2Icon,
    PuzzlePieceIcon,
    TagIcon,
    Squares2X2Icon,
    ArrowsPointingOutIcon,
    ArrowsRightLeftIcon,
    MapPinIcon,
    CurrencyDollarIcon,
    ArrowTopRightOnSquareIcon,
    XCircleIcon,
} from "@heroicons/vue/24/outline";
import timberlog from "../icons/timber/logs.png";

const props = defineProps({
    entries: {
        type: Object,
        required: true,
        default: () => ({})
    },
    species: {
        type: String,
        required: true
    }
});

const chartContainer = ref(null);
const legendContainer = ref(null);
const filterValues = ref({
    seller: "",
    type: "",
    class: "",
    diameter: "",
    length: "",
    location: "",
});

const clearFilters = () => {
    filterValues.value = {
        seller: "",
        type: "",
        class: "",
        diameter: "",
        length: "",
        location: "",
    };
};

// Initialize entries as an empty array if undefined
const entries = ref(props.entries || []);
if (!Array.isArray(entries.value)) {
    entries.value = [];
    console.error("Entries is not an array:", props.entries);
}

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

const filters = computed(() => [
    { key: "seller", label: "Filter by Seller", options: uniqueSellers.value },
    { key: "type", label: "Filter by Type", options: uniqueTypes.value },
    { key: "class", label: "Filter by Class", options: uniqueClasses.value },
    {
        key: "diameter",
        label: "Filter by Diameter",
        options: uniqueDiameters.value,
    },
    { key: "length", label: "Filter by Length", options: uniqueLengths.value },
    {
        key: "location",
        label: "Filter by Location",
        options: uniqueLocations.value,
    },
]);

const uniqueSellers = computed(() => {
    const sellers = new Set(entries.value.map((entry) => entry.seller));
    return sortDescending(Array.from(sellers));
});

const uniqueTypes = computed(() => {
    const types = new Set(entries.value.map((entry) => entry.type));
    return sortDescending(Array.from(types));
});

const uniqueClasses = computed(() => {
    const classes = new Set(entries.value.map((entry) => entry.class));
    return sortDescending(Array.from(classes));
});

const uniqueDiameters = computed(() => {
    const diameters = new Set(entries.value.map((entry) => entry.diameter));
    return sortDescending(Array.from(diameters));
});

const uniqueLengths = computed(() => {
    const lengths = new Set(entries.value.map((entry) => entry.length));
    return sortDescending(Array.from(lengths));
});

const uniqueLocations = computed(() => {
    const locations = new Set(entries.value.map((entry) => entry.location));
    return sortDescending(Array.from(locations));
});

watchEffect(() => {
    updateChart();
});

onMounted(() => {
    updateChart();
});

function updateChart() {
    if (!chartContainer.value || !legendContainer.value) {
        console.error("Chart container or legend container not found");
        return;
    }

    const container = chartContainer.value;
    const legendContainerElement = legendContainer.value;

    // Clear the existing legend
    while (legendContainerElement.firstChild) {
        legendContainerElement.removeChild(legendContainerElement.firstChild);
    }

    const chart = echarts.init(container);

    // Get all entries and assign seller colors
    const data = filteredEntries.value;
    const uniqueSellers = [...new Set(data.map(entry => entry.seller))];
    
    // Fixed colors for sellers
    const colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf'];
    const sellerColors = {};
    uniqueSellers.forEach((seller, index) => {
        sellerColors[seller] = colors[index % colors.length];
    });

    // Group data by seller
    const groupedData = {};
    data.forEach(entry => {
        if (!groupedData[entry.seller]) {
            groupedData[entry.seller] = [];
        }
        groupedData[entry.seller].push(entry);
    });

    // Create series data
    const seriesData = [];
    let barIndex = 0;
    const xAxisLabels = [];
    const sellerPositions = {};

    Object.entries(groupedData).forEach(([seller, entries]) => {
        // Store the middle position for this seller's group
        sellerPositions[seller] = barIndex + entries.length / 2 - 0.5;
        
        entries.forEach(entry => {
            xAxisLabels.push('');  // Empty label for each bar
            seriesData.push({
                value: parseFloat(entry.price) || 0,
                itemStyle: {
                    color: sellerColors[seller]
                },
                entry: entry
            });
            barIndex++;
        });
    });

    chart.setOption({
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            },
            formatter: function(params) {
                const entry = params[0].data.entry;
                return `
                    <div style="margin-bottom: 10px;">
                        <strong>${entry.seller}</strong>
                    </div>
                    <div style="margin-bottom: 10px; padding-bottom: 10px;">
                        <div><strong>Price:</strong> €${entry.price}</div>
                        <div><strong>Class:</strong> ${entry.class || 'N/A'}</div>
                        <div><strong>Type:</strong> ${entry.type || 'N/A'}</div>
                        <div><strong>Diameter:</strong> ${entry.diameter || 'N/A'}</div>
                        <div><strong>Length:</strong> ${entry.length || 'N/A'}</div>
                        <div><strong>Location:</strong> ${entry.location || 'N/A'}</div>
                    </div>
                `;
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '15%',
            containLabel: true
        },
        xAxis: {
            type: 'category',
            data: xAxisLabels,
            axisLabel: {
                interval: 0,
                rotate: 45,
                color: getCurrentTextColor()
            },
            axisTick: {
                show: false
            },
            axisLine: {
                show: true
            }
        },
        yAxis: {
            type: 'value',
            name: 'Price (€)',
            axisLabel: {
                color: getCurrentTextColor(),
                formatter: '{value} €'
            }
        },
        series: [{
            name: 'Price',
            type: 'bar',
            data: seriesData,
            barWidth: '40%',
            emphasis: {
                itemStyle: {
                    shadowBlur: 10,
                    shadowOffsetX: 0,
                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
        }]
    });

    // Add seller labels
    Object.entries(sellerPositions).forEach(([seller, position]) => {
        chart.setOption({
            graphic: [{
                type: 'text',
                left: chart.convertToPixel({xAxis: 0}, position),
                top: chart.getHeight() - 40,
                style: {
                    text: seller,
                    textAlign: 'center',
                    fill: getCurrentTextColor(),
                    fontSize: 12
                },
                rotation: 0.25 * Math.PI  // 45 degrees
            }]
        });
    });

    // Add legend for sellers
    Object.entries(sellerColors).forEach(([seller, color]) => {
        const legendItem = document.createElement('div');
        legendItem.className = 'flex items-center space-x-2 px-2 py-1';
        
        const colorBox = document.createElement('span');
        colorBox.className = 'w-3 h-3 inline-block';
        colorBox.style.backgroundColor = color;
        
        const text = document.createElement('span');
        text.textContent = seller;
        text.className = 'text-sm';
        text.style.color = getCurrentTextColor();
        
        legendItem.appendChild(colorBox);
        legendItem.appendChild(text);
        legendContainerElement.appendChild(legendItem);
    });

    // Handle resize
    window.addEventListener('resize', () => {
        chart.resize();
    });

    return () => {
        chart.dispose();
        window.removeEventListener('resize', () => {
            chart.resize();
        });
    };
}

onUnmounted(() => {
    const container = chartContainer.value;
    if (container) {
        const chart = echarts.getInstanceByDom(container);
        if (chart) {
            chart.dispose();
        }
    }
});

function getCurrentTextColor() {
    const body = document.body;
    if (body.classList.contains("dark")) {
        return "white";
    } else {
        return "black";
    }
}

const logicon = computed(() => timberlog);
</script>