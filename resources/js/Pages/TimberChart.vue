<template>
  <AuthenticatedLayout>
    <body class="bg-gray-100">
      <div class="container mx-auto px-4 py-6 bg-gray-200 rounded-lg space-y-6">
        <!-- Flex container for the main content -->
        <div class="flex flex-col md:flex-row gap-6 items-start">
          <!-- Chart Container -->
          <div class="flex-grow bg-white border-4 border-blue-500 rounded-lg shadow-md overflow-hidden">
            <div ref="chartContainer" class="h-96 w-full"></div>
          </div>
          <!-- Filters Container -->
          <div class="flex flex-col w-full md:w-96 bg-white p-6 rounded-lg shadow-md space-y-4">
            <div class="text-5xl font-bold text-gray-800 mb-5">{{ species }}</div>
            <div class="space-y-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="filterSeller">Filter by Seller</label>
              <select v-model="filterSeller" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="">All Sellers</option>
                <option v-for="seller in uniqueSellers" :key="seller" :value="seller">{{ seller }}</option>
              </select>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="filterType">Filter by Type</label>
              <select v-model="filterType" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="">All Types</option>
                <option v-for="type in uniqueType" :key="type" :value="type">{{ type }}</option>
              </select>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="filterClass">Filter by Class</label>
              <select v-model="filterClass" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="">All Classes</option>
                <option v-for="classs in uniqueclass" :key="classs" :value="classs">{{ classs }}</option>
              </select>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="filterDiameter">Filter by Diameter</label>
              <select v-model="filterDiameter" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="">All Diameters</option>
                <option v-for="diameter in uniqueDiameter" :key="diameter" :value="diameter">{{ diameter }}</option>
              </select>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="filterLength">Filter by Length</label>
              <select v-model="filterLength" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="">All Lengths</option>
                <option v-for="length in uniqueLength" :key="length" :value="length">{{ length }}</option>
              </select>
              <label class="block text-gray-700 text-sm font-bold mb-2" for="filterLocation">Filter by Location</label>
              <select v-model="filterLocation" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option value="">All Locations</option>
                <option v-for="location in uniqueLocation" :key="location" :value="location">{{ location }}</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <ul v-if="user && user.vip_status" class="container mx-auto px-4 py-6 bg-gray-200 rounded-lg space-y-8 shadow-lg">
        <li v-for="entry in filteredEntries" :key="entry.id" class="flex flex-col md:flex-row items-center bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
          <div class="w-16 h-16 bg-gray-300 rounded-md flex-shrink-0"></div>
          <div class="mt-4 md:mt-0 ml-0 md:ml-6 flex-grow">
            <div class="flex flex-col md:flex-row justify-between items-center">
              <h2 class="text-lg font-bold text-gray-800">{{ entry.seller }}</h2>
              <span class="text-lg font-semibold text-gray-600">{{ entry.location }}</span>
            </div>
            <p class="mt-2 text-sm text-gray-600">Price: {{ entry.price }}</p>
            <p class="text-sm text-gray-600">Class: {{ entry.class }}</p>
            <p class="text-sm text-gray-600">Type: {{ entry.type }}</p>
          </div>
          <div class="mt-4 md:mt-0 ml-0 md:ml-6 flex space-x-2 md:space-x-4">
            <button @click="saveMaterial(entry.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors duration-300">Save</button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-md transition-colors duration-300">Find out more</button>
          </div>
        </li>
      </ul>
    </body>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps, onMounted, ref, computed, watchEffect } from 'vue';
import * as echarts from 'echarts';
import { usePage } from '@inertiajs/vue3';

const { user } = usePage().props.auth;

const props = defineProps({
  entries: Array,
  species: String,
});

const chartContainer = ref(null);
const entries = ref(props.entries);
const filterSeller = ref('');
const filterClass = ref('');
const filterDiameter = ref('');
const filterLength = ref('');
const filterLocation = ref('');
const filterType = ref('');

// Compute filtered entries based on multiple criteria
const filteredEntries = computed(() => {
  return entries.value.filter(entry =>
    (filterSeller.value === '' || entry.seller.toLowerCase().includes(filterSeller.value.toLowerCase())) &&
    (filterClass.value === '' || entry.class === filterClass.value) &&
    (filterDiameter.value === '' || entry.diameter === filterDiameter.value) &&
    (filterLength.value === '' || entry.length === filterLength.value) &&
    (filterLocation.value === '' || entry.location.toLowerCase().includes(filterLocation.value.toLowerCase())) &&
    (filterType.value === '' || entry.type === filterType.value)
  );
});

const uniqueSellers = computed(() => {
  const sellers = new Set(entries.value.map(entry => entry.seller));
  return Array.from(sellers);
});
const uniqueclass = computed(() => {
  const classs = new Set(entries.value.map(entry => entry.class));
  return Array.from(classs);
});

const uniqueDiameter = computed(() => {
  const diameter = new Set(entries.value.map(entry => entry.diameter));
  return Array.from(diameter);
});

const uniqueLength = computed(() => {
  const length = new Set(entries.value.map(entry => entry.length));
  return Array.from(length);
});

const uniqueLocation = computed(() => {
  const location = new Set(entries.value.map(entry => entry.location));
  return Array.from(location);
});

const uniqueType = computed(() => {
  const type = new Set(entries.value.map(entry => entry.type));
  return Array.from(type);
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
  updateChart();
});

onMounted(() => {
  updateChart();
});

function updateChart() {
  const container = chartContainer.value;
  if (!container) {
    console.error("Chart container not found");
    return;
  }

  const chart = echarts.init(container);

  const xAxisData = filteredEntries.value.map(entry => entry.seller);
  const yAxisData = filteredEntries.value.map(entry => ({
    price: entry.price,
    class: entry.class,
    location: entry.location 
  }));

  chart.setOption({
    tooltip: {
      trigger: 'axis',
      axisPointer: {
        type: 'shadow'
      },
      formatter: function(params) {
        const dataIndex = params[0].dataIndex;
        const tooltipContent = [
          'Price: ' + params[0].value,
          'Class: ' + yAxisData[dataIndex].class,
          'Location: ' + yAxisData[dataIndex].location
        ];
        return tooltipContent.join('<br>');
      }
    },
    xAxis: {
      type: 'category',
      data: xAxisData
    },
    yAxis: {
      type: 'value'
    },
    series: [{
      name: 'Price',
      type: 'bar',
      data: yAxisData.map(item => item.price),
    }]
  });
}
</script>
