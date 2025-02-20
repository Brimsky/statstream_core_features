<template>
    <MainLayout>
        <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-neutral-900">
            <div class="max-w-7xl mx-auto mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white bg-clip-text">
                            {{ species }}
                        </h1>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                            Detalizēta tirgus analīze un cenu salīdzinājums
                        </p>
                    </div>
                    <button
                        @click="toggleTheme"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                        :class="isDark 
                            ? 'bg-neutral-700 text-gray-200 hover:bg-neutral-600' 
                            : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                    >
                        <SunIcon v-if="isDark" class="w-5 h-5 mr-2" />
                        <MoonIcon v-else class="w-5 h-5 mr-2" />
                        {{ isDark ? 'Gaišais režīms' : 'Tumšais režīms' }}
                    </button>
                </div>
            </div>

            <div class="max-w-7xl mx-auto">
                <!-- Flex container for chart and filters -->
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Chart Container -->
                    <div class="flex-grow">
                        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700 overflow-hidden">
                            <div class="p-4 border-b border-gray-100 dark:border-neutral-700">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Cenu salīdzinājums
                                </h2>
                            </div>
                            <div ref="chartContainer" class="h-96 w-full p-4"></div>
                            <div ref="legendContainerRef" class="flex flex-wrap justify-center gap-4 p-4 border-t border-gray-100 dark:border-neutral-700"></div>
                        </div>
                    </div>

                    <!-- Filters Panel -->
                    <div class="lg:w-80">
                        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700">
                            <div class="p-4 border-b border-gray-100 dark:border-neutral-700">
                                <div class="flex justify-between items-center">
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Filtri
                                    </h2>
                                    <button
                                        @click="clearFilters"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-600 rounded-lg border border-gray-200 dark:border-neutral-600 transition-colors duration-200"
                                    >
                                        <XCircleIcon class="w-4 h-4 mr-1.5" />
                                        Notīrīt filtri
                                    </button>
                                </div>
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
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                                        Diametra diapazons (cm)
                                    </label>
                                    <div class="flex gap-4 items-center max-w-xs">
                                        <div class="flex-1">
                                            <input
                                                type="number"
                                                v-model.number="diameterRange.min"
                                                placeholder="Min"
                                                min="0"
                                                step="1"
                                                class="block w-full px-3 py-2 text-base border-gray-300 dark:border-neutral-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-neutral-800 dark:text-white"
                                            />
                                        </div>
                                        <span class="text-gray-500 dark:text-gray-400">līdz</span>
                                        <div class="flex-1">
                                            <input
                                                type="number"
                                                v-model.number="diameterRange.max"
                                                placeholder="Maks"
                                                min="0"
                                                step="1"
                                                class="block w-full px-3 py-2 text-base border-gray-300 dark:border-neutral-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-neutral-800 dark:text-white"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-lg border border-gray-100 dark:border-neutral-700 overflow-hidden">
                        <div class="p-4 border-b border-gray-100 dark:border-neutral-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Detalizēti piedāvājumi
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
                                                            Suga
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
                                                            Klase
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
                                                            Tips
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
                                                            Diametrs
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
                                                            Garums
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
                                                            Atrašanās vieta
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
                                                {{ entry.price }} €/m³
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <a
                                                :href="entry.url"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 dark:bg-purple-500 hover:bg-blue-700 dark:hover:bg-purple-600 rounded-lg transition-colors duration-200"
                                            >
                                                <ArrowTopRightOnSquareIcon class="w-5 h-5 mr-1.5" />
                                                Detalizēti
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
    SunIcon,
    MoonIcon
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
const legendContainerRef = ref(null);

const entriesArray = computed(() => {
    return Object.values(props.entries || {});
});

// Ensure data is sorted in descending order
function sortDescending(arr) {
    return arr.sort((a, b) => {
        if (typeof a === "string" && typeof b === "string") {
            return b.localeCompare(a);
        }
        return 0;
    });
}

const filterValues = ref({
    seller: "",
    type: "",
    class: "",
    diameter: "",
    length: "",
    location: ""
});

const diameterRange = ref({
    min: null,
    max: null
});

const uniqueSellers = computed(() => {
    const sellers = new Set(entriesArray.value.map((entry) => entry.seller));
    return sortDescending(Array.from(sellers));
});

const uniqueClass = computed(() => {
    const classs = new Set(entriesArray.value.map((entry) => entry.class));
    return sortDescending(Array.from(classs));
});

const uniqueDiameter = computed(() => {
    const diameters = new Set(entriesArray.value.map((entry) => entry.diameter));
    return sortDescending(Array.from(diameters));
});

const uniqueLength = computed(() => {
    const lengths = new Set(entriesArray.value.map((entry) => entry.length));
    return sortDescending(Array.from(lengths));
});

const uniqueLocation = computed(() => {
    const locations = new Set(entriesArray.value.map((entry) => entry.location));
    return sortDescending(Array.from(locations));
});

const uniqueType = computed(() => {
    const types = new Set(entriesArray.value.map((entry) => entry.type));
    return sortDescending(Array.from(types));
});

// Compute filtered entries based on multiple criteria
const filteredEntries = computed(() => {
    let filtered = entriesArray.value;

    // Apply diameter range filter if either min or max is set
    if (diameterRange.value.min !== null || diameterRange.value.max !== null) {
        filtered = filtered.filter(entry => {
            const diameter = parseFloat(entry.diameter);
            const minOk = diameterRange.value.min === null || diameter >= diameterRange.value.min;
            const maxOk = diameterRange.value.max === null || diameter <= diameterRange.value.max;
            return minOk && maxOk;
        });
    }

    // Apply other filters except diameter
    filtered = filtered.filter(
        (entry) =>
            (!filterValues.value.seller ||
                entry.seller === filterValues.value.seller) &&
            (!filterValues.value.type ||
                entry.type === filterValues.value.type) &&
            (!filterValues.value.class ||
                entry.class === filterValues.value.class) &&
            (!filterValues.value.length ||
                entry.length == filterValues.value.length) &&
            (!filterValues.value.location ||
                entry.location === filterValues.value.location)
    );

    return filtered;
});

// Remove the diameter filter from the regular filters
const filters = computed(() => {
    return [
        { key: "seller", label: "Pārdevēji", options: uniqueSellers.value },
        { key: "type", label: "Tipi", options: uniqueType.value },
        { key: "class", label: "Klases", options: uniqueClass.value },
        {
            key: "length",
            label: "Garumi",
            options: uniqueLength.value,
        },
        {
            key: "location",
            label: "Atrašanās vietas",
            options: uniqueLocation.value,
        },
    ];
});

function clearFilters() {
    Object.keys(filterValues.value).forEach(key => {
        filterValues.value[key] = '';
    });
    diameterRange.value.min = null;
    diameterRange.value.max = null;
}

let chart = null;

watchEffect(() => {
    updateChart();
});

onMounted(() => {
    updateChart();
});

function updateChart() {
    const container = chartContainer.value;
    const legendContainerElement = legendContainerRef.value;
    if (!container || !legendContainerElement) {
        console.error("Chart container or legend container not found");
        return;
    }

    // Initialize chart if not exists
    if (!chart) {
        chart = echarts.init(container);
    }

    // Clear the existing legend
    while (legendContainerElement.firstChild) {
        legendContainerElement.removeChild(legendContainerElement.firstChild);
    }

    const filteredData = filteredEntries.value;
    const isDarkMode = document.documentElement.classList.contains('dark');
    
    // Define a fixed color palette with better visibility in both themes
    const colorPalette = isDarkMode ? [
        '#60a5fa', // bright blue
        '#f87171', // bright red
        '#34d399', // bright green
        '#fbbf24', // bright amber
        '#a78bfa', // bright purple
        '#f472b6', // bright pink
        '#2dd4bf', // bright teal
        '#fb923c', // bright orange
        '#818cf8', // bright indigo
        '#a3e635'  // bright lime
    ] : [
        '#2563eb', // dark blue
        '#dc2626', // dark red
        '#059669', // dark green
        '#d97706', // dark amber
        '#7c3aed', // dark purple
        '#db2777', // dark pink
        '#0d9488', // dark teal
        '#ea580c', // dark orange
        '#4f46e5', // dark indigo
        '#65a30d'  // dark lime
    ];

    // Create seller color mapping
    const sellerColors = {};
    uniqueSellers.value.forEach((seller, index) => {
        sellerColors[seller] = colorPalette[index % colorPalette.length];
    });

    const textColor = isDarkMode ? '#e5e7eb' : '#374151';
    const axisLineColor = isDarkMode ? '#4b5563' : '#d1d5db';
    const tooltipBackgroundColor = isDarkMode ? 'rgba(17, 24, 39, 0.95)' : 'rgba(255, 255, 255, 0.95)';
    const tooltipBorderColor = isDarkMode ? '#374151' : '#e5e7eb';

    chart.setOption({
        backgroundColor: 'transparent',
        tooltip: {
            trigger: "axis",
            axisPointer: {
                type: "shadow",
                shadowStyle: {
                    color: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                }
            },
            backgroundColor: tooltipBackgroundColor,
            borderColor: tooltipBorderColor,
            textStyle: {
                color: textColor
            },
            formatter: function (params) {
                const entry = filteredData[params[0].dataIndex];
                return `
                    <div style="margin-bottom: 10px;">
                        <strong style="color: ${textColor}">${entry.seller}</strong>
                    </div>
                    <div style="margin-bottom: 10px; padding-bottom: 10px;">
                        <div style="color: ${textColor}"><strong>Cena:</strong> €${entry.price}</div>
                        <div style="color: ${textColor}"><strong>Klase:</strong> ${entry.class || 'N/A'}</div>
                        <div style="color: ${textColor}"><strong>Tips:</strong> ${entry.type || 'N/A'}</div>
                        <div style="color: ${textColor}"><strong>Diametrs:</strong> ${entry.diameter || 'N/A'}</div>
                        <div style="color: ${textColor}"><strong>Garums:</strong> ${entry.length || 'N/A'}</div>
                        <div style="color: ${textColor}"><strong>Atrašanās vieta:</strong> ${entry.location || 'N/A'}</div>
                    </div>
                `;
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '5%',
            containLabel: true
        },
        xAxis: {
            type: "category",
            data: filteredData.map((_, index) => index + 1),
            axisLabel: {
                show: false
            },
            axisTick: {
                show: false
            },
            axisLine: {
                lineStyle: {
                    color: axisLineColor
                }
            }
        },
        yAxis: {
            type: "value",
            name: 'Cena (€)',
            nameTextStyle: {
                color: textColor
            },
            axisLabel: {
                color: textColor,
                formatter: '{value} €'
            },
            splitLine: {
                lineStyle: {
                    color: isDarkMode ? 'rgba(75, 85, 99, 0.3)' : 'rgba(209, 213, 219, 0.5)'
                }
            },
            axisLine: {
                lineStyle: {
                    color: axisLineColor
                }
            }
        },
        series: [
            {
                name: "Cena",
                type: "bar",
                barWidth: '40%',
                data: filteredData.map(entry => ({
                    value: entry.price,
                    itemStyle: { 
                        color: sellerColors[entry.seller],
                        borderRadius: [4, 4, 0, 0]
                    }
                })),
                emphasis: {
                    itemStyle: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: isDarkMode ? 'rgba(255, 255, 255, 0.3)' : 'rgba(0, 0, 0, 0.3)'
                    }
                }
            }
        ]
    });

    // Create custom legend with theme-aware styles
    Object.entries(sellerColors).forEach(([seller, color]) => {
        const legendItem = document.createElement("div");
        legendItem.style.display = "flex";
        legendItem.style.alignItems = "center";
        legendItem.style.margin = "0 10px";
        legendItem.style.padding = "8px";
        legendItem.style.borderRadius = "6px";
        legendItem.style.cursor = "pointer";
        legendItem.style.transition = "background-color 0.2s";

        const colorBox = document.createElement("span");
        colorBox.style.display = "inline-block";
        colorBox.style.width = "12px";
        colorBox.style.height = "12px";
        colorBox.style.backgroundColor = color;
        colorBox.style.marginRight = "8px";
        colorBox.style.borderRadius = "3px";

        const sellerName = document.createElement("span");
        sellerName.textContent = seller;
        sellerName.style.color = textColor;
        sellerName.style.fontSize = "14px";

        legendItem.appendChild(colorBox);
        legendItem.appendChild(sellerName);

        // Hover effect
        legendItem.addEventListener('mouseenter', () => {
            legendItem.style.backgroundColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
        });
        legendItem.addEventListener('mouseleave', () => {
            legendItem.style.backgroundColor = 'transparent';
        });

        legendContainerElement.appendChild(legendItem);
    });
}

// Watch for theme changes
const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
        if (mutation.attributeName === 'class' && chart) {
            updateChart();
        }
    });
});

const isDark = ref(document.documentElement.classList.contains('dark'));

const toggleTheme = () => {
    isDark.value = !isDark.value;
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
};

// Initialize theme from localStorage on mount
onMounted(() => {
    const theme = localStorage.getItem('theme');
    if (theme) {
        isDark.value = theme === 'dark';
        document.documentElement.classList.toggle('dark', isDark.value);
    }
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['class']
    });
    updateChart();
});

onUnmounted(() => {
    observer.disconnect();
    if (chart) {
        chart.dispose();
    }
});

const logicon = computed(() => timberlog);
</script>