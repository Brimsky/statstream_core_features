<template>
  <AuthenticatedLayout>
    <body>
      <div class="container mx-auto px-4 py-10 rounded-lg space-y-6">
        <!-- Flex container for the main content -->
        <div class="flex flex-col md:flex-row gap-6 items-start">
          <!-- Chart Container -->
          <div class="flex-grow dark:bg-neutral-800 bg-white border border-blue-500 dark:border-purple-700 rounded-lg shadow-md overflow-hidden">
            <div ref="chartContainer" class="h-96 w-full"></div>
            <div ref="legendContainer" class="flex flex-wrap justify-center mt-4"></div>
          </div>
          <!-- Filters Container -->
          <div class="flex flex-col w-full md:w-96 dark:bg-neutral-800 bg-white p-6 rounded-lg shadow-md space-y-4">
            <div class="text-3xl font-semibold dark:text-white text-gray-800 mb-5">{{ species }}</div>
            <div class="space-y-4">
              <FilterSelect
                v-model="filterSeller"
                label="Filter by Seller"
                :options="uniqueSellers"
              />
              <FilterSelect
                v-model="filterType"
                label="Filter by Type"
                :options="uniqueType"
              />
              <FilterSelect
                v-model="filterClass"
                label="Filter by Class"
                :options="uniqueClass"
              />
              <FilterSelect
                v-model="filterDiameter"
                label="Filter by Diameter"
                :options="uniqueDiameter"
              />
              <FilterSelect
                v-model="filterLength"
                label="Filter by Length"
                :options="uniqueLength"
              />
              <FilterSelect
                v-model="filterLocation"
                label="Filter by Location"
                :options="uniqueLocation"
              />
            </div>
          </div>
        </div>
      </div>
      <ul v-if="user && user.vip_status" class="container mx-auto px-4 py-6 rounded-lg space-y-8 shadow-lg">
        <li v-for="entry in filteredEntries" :key="entry.id" class="flex flex-col md:flex-row dark:bg-neutral-800 bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 relative">
          <div class="flex items-center space-x-4 mb-4 md:mb-0">
            <div class="w-32 h-32 rounded-md flex-shrink-0">
              <img class="w-full h-full object-contain" :src="logicon">
            </div>
            <div>
              <h2 class="text-2xl font-bold dark:text-white text-black">{{ entry.seller }}</h2>
              <p class="text-sm dark:text-white text-black">Species: {{ entry.speacies }}</p>
              <p class="text-sm dark:text-white text-black">Class: {{ entry.class }}</p>
              <p class="text-sm dark:text-white text-black">Type: {{ entry.type }}</p>
              <p class="text-sm dark:text-white text-black">Diameter: {{ entry.diameter }}</p>
              <p class="text-sm dark:text-white text-black">Length: {{ entry.length }}</p>
            </div>
            <span class="text-xl font-semibold text-gray-600 dark:text-white absolute top-2 right-2">{{ entry.location }}</span>
          </div>
          <div class="flex-grow md:ml-6 flex flex-col justify-end">
            <div class="mt-4 md:mt-0 flex flex-col items-start md:items-end space-y-2 md:space-y-4">
              <p class="text-xl font-bold dark:text-white text-black">Price: ${{ entry.price }}</p>
              <div class="flex space-x-2 md:space-x-4">
                <button @click="saveMaterial(entry.id)" class="bg-blue-500 dark:bg-purple-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">Save</button>
                <a :href="entry.url" target="_blank" class="bg-blue-500 dark:bg-purple-500 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors duration-300">Find out more</a>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </body>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps, ref, computed, onMounted, watchEffect } from 'vue';
import * as echarts from 'echarts';
import { usePage } from '@inertiajs/vue3';
import FilterSelect from '@/Components/FilterSelect.vue';
import timberlog from '../icons/timber/logs.png';

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
  console.error('Entries is not an array:', props.entries);
}

const chartContainer = ref(null);
const legendContainer = ref(null);
const filterSeller = ref('');
const filterClass = ref('');
const filterDiameter = ref('');
const filterLength = ref('');
const filterLocation = ref('');
const filterType = ref('');

// Ensure data is sorted in descending order
function sortDescending(arr) {
  return arr.sort((a, b) => {
    if (typeof a === 'string' && typeof b === 'string') {
      return b.localeCompare(a);
    }
    return 0;
  });
}

// Compute filtered entries based on multiple criteria
const filteredEntries = computed(() => {
  console.log('Filtering entries:', entries.value);
  return entries.value.filter(entry =>
    (filterSeller.value === '' || entry.seller.toLowerCase().includes(filterSeller.value.toLowerCase())) &&
    (filterClass.value === '' || entry.class === filterClass.value) &&
    (filterDiameter.value === '' || entry.diameter == filterDiameter.value) &&
    (filterLength.value === '' || entry.length == filterLength.value) &&
    (filterLocation.value === '' || entry.location.toLowerCase().includes(filterLocation.value.toLowerCase())) &&
    (filterType.value === '' || entry.type === filterType.value)
  ).sort((a, b) => b.seller.localeCompare(a.seller));
});

const uniqueSellers = computed(() => {
  const sellers = new Set(entries.value.map(entry => entry.seller));
  return sortDescending(Array.from(sellers));
});
const uniqueClass = computed(() => {
  const classs = new Set(entries.value.map(entry => entry.class));
  return sortDescending(Array.from(classs));
});

const uniqueDiameter = computed(() => {
  const diameters = new Set(entries.value.map(entry => entry.diameter));
  return sortDescending(Array.from(diameters));
});

const uniqueLength = computed(() => {
  const lengths = new Set(entries.value.map(entry => entry.length));
  return sortDescending(Array.from(lengths));
});

const uniqueLocation = computed(() => {
  const locations = new Set(entries.value.map(entry => entry.location));
  return sortDescending(Array.from(locations));
});

const uniqueType = computed(() => {
  const types = new Set(entries.value.map(entry => entry.type));
  return sortDescending(Array.from(types));
});

const saveMaterial = async (timberSpeciesId) => {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  try {
    const response = await fetch('/api/save-material', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      },
      body: JSON.stringify({ liked_material: timberSpeciesId })
    });

    if (!response.ok) {
      throw new Error(`Failed to save timber, status: ${response.status}`);
    }

    const data = await response.json();
    console.log('Save successful:', data);
  } catch (error) {
    console.error('Error saving timber:', error);
  }
};

watchEffect(() => {
  console.log('Entries:', entries.value); // Log the entries to debug
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
  const xAxisData = filteredData.map(entry => entry.seller);
  const yAxisData = filteredData.map(entry => ({
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
      trigger: 'axis',
      axisPointer: {
        type: 'shadow'
      },
      formatter: function(params) {
        const dataIndex = params[0].dataIndex;
        const tooltipContent = [
          'Speacies: ' + yAxisData[dataIndex].speacies,
          'Length: ' + yAxisData[dataIndex].length,
          'Class: ' + yAxisData[dataIndex].class,
          'Diameter: ' + yAxisData[dataIndex].diameter,
          'Type: ' + yAxisData[dataIndex].type,
          'Location: ' + yAxisData[dataIndex].location,
          'Price: ' + params[0].value,
        ];
        return tooltipContent.join('<br>');
      }
    },
    xAxis: {
      type: 'category',
      data: xAxisData,
      axisLabel: {
        color: getCurrentTextColor()
      }
    },
    yAxis: {
      type: 'value',
      axisLabel: {
        color: getCurrentTextColor()
      }
    },
    series: [{
      name: 'Price',
      type: 'bar',
      data: yAxisData.map((item, index) => ({
        value: item.price,
        itemStyle: { color: sellerColors[xAxisData[index]] }
      })),
    }]
  });

  // Add legend manually below the chart
  Object.entries(sellerColors).forEach(([seller, color]) => {
    const legendItem = document.createElement('div');
    legendItem.style.display = 'flex';
    legendItem.style.alignItems = 'center';
    legendItem.style.margin = '0 10px';

    const colorBox = document.createElement('span');
    colorBox.style.display = 'inline-block';
    colorBox.style.width = '12px';
    colorBox.style.height = '12px';
    colorBox.style.backgroundColor = color;
    colorBox.style.marginRight = '5px';

    const sellerName = document.createElement('span');
    sellerName.textContent = seller;
    sellerName.style.color = getCurrentTextColor();

    legendItem.appendChild(colorBox);
    legendItem.appendChild(sellerName);

    legendContainerElement.appendChild(legendItem);
  });
}

function getCurrentTextColor() {
  const body = document.body;
  if (body.classList.contains('dark')) {
    return 'white';
  } else {
    return 'black';
  }
}
</script>
