<template>
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
        <!-- Main Content -->
        <div class="max-w-7xl mx-auto">
            <!-- Flex container for chart and filters -->
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Chart Container -->
                <div class="flex-grow">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Price Comparison
                            </h2>
                        </div>
                        <div ref="chartContainer" class="h-96 w-full p-4"></div>
                        <div ref="legendContainer" class="flex flex-wrap justify-center gap-4 p-4 border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
                </div>

                <!-- Filters Panel -->
                <div class="lg:w-80">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Filters
                            </h2>
                        </div>
                        <div class="p-4 space-y-4">
                            <FilterSelect
                                v-for="filter in filters"
                                :key="filter.key"
                                :label="filter.label"
                                :options="filter.options"
                                v-model="filterValues[filter.key]"
                                class="text-gray-700 dark:text-gray-300"
                            />
                            <button 
                                @click="clearFilters"
                                class="w-full px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                            >
                                Clear Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Detailed Listings
                        </h2>
                    </div>
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        <div
                            v-for="entry in filteredEntries"
                            :key="entry.id"
                            class="p-6 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200"
                        >
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-grow">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        <div class="space-y-2">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Species</div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ entry.species }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Class</div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ entry.class }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Type</div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ entry.type }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Dimensions</div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ entry.diameter }}mm × {{ entry.length }}m</div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Location</div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ entry.location }}</div>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Price</div>
                                            <div class="font-medium text-gray-900 dark:text-white">€{{ entry.price }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watchEffect } from "vue";
import * as echarts from "echarts";
import FilterSelect from "@/Components/FilterSelect.vue";
import axios from "axios";

const props = defineProps({
    species: {
        type: String,
        required: false,
        default: null
    }
});

const entries = ref([]);
const chartContainer = ref(null);
const legendContainer = ref(null);
const chart = ref(null);
const filterValues = ref({
    seller: "",
    type: "",
    class: "",
});

// Fetch data
const fetchData = async () => {
    try {
        const response = await axios.get(`/api/public/timber-data${props.species ? '/' + props.species : ''}`);
        entries.value = response.data.entries;
    } catch (error) {
        console.error('Error fetching timber data:', error);
    }
};

// Computed properties for unique values
const uniqueSellers = computed(() => {
    const sellers = new Set(entries.value.map((entry) => entry.seller));
    return Array.from(sellers);
});

const uniqueType = computed(() => {
    const types = new Set(entries.value.map((entry) => entry.type));
    return Array.from(types);
});

const uniqueClass = computed(() => {
    const classes = new Set(entries.value.map((entry) => entry.class));
    return Array.from(classes);
});

// Filter entries based on selected values
const filteredEntries = computed(() => {
    return entries.value.filter((entry) => {
        const sellerMatch =
            !filterValues.value.seller || entry.seller === filterValues.value.seller;
        const typeMatch =
            !filterValues.value.type || entry.type === filterValues.value.type;
        const classMatch =
            !filterValues.value.class || entry.class === filterValues.value.class;

        return sellerMatch && typeMatch && classMatch;
    });
});

// Chart update function
const updateChart = () => {
    if (!chartContainer.value) return;

    if (!chart.value) {
        chart.value = echarts.init(chartContainer.value);
    }

    const data = filteredEntries.value.map((entry) => ({
        value: [entry.date, entry.price],
        itemStyle: {
            color: '#3B82F6'
        }
    }));

    const option = {
        tooltip: {
            trigger: 'axis',
            formatter: function(params) {
                const data = params[0].data;
                return `Date: ${data[0]}<br/>Price: €${data[1]}`;
            }
        },
        xAxis: {
            type: 'time',
            splitLine: {
                show: false
            }
        },
        yAxis: {
            type: 'value',
            name: 'Price (€)',
            splitLine: {
                show: true,
                lineStyle: {
                    type: 'dashed'
                }
            }
        },
        series: [{
            type: 'line',
            data: data,
            symbol: 'circle',
            symbolSize: 8,
            lineStyle: {
                width: 3
            }
        }]
    };

    chart.value.setOption(option);
};

// Filters setup
const filters = computed(() => [
    { key: "seller", label: "Filter by Seller", options: uniqueSellers.value },
    { key: "type", label: "Filter by Type", options: uniqueType.value },
    { key: "class", label: "Filter by Class", options: uniqueClass.value },
]);

const clearFilters = () => {
    filterValues.value = {
        seller: "",
        type: "",
        class: "",
    };
};

// Watch for changes and update chart
watchEffect(() => {
    updateChart();
});

// Initial setup
onMounted(() => {
    fetchData();
    window.addEventListener('resize', () => {
        chart.value?.resize();
    });
});
</script>
