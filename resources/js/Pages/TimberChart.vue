
<template>
  <AuthenticatedLayout>
    <div class="container mx-auto px-6 py-6 bg-gray-200 rounded-lg">

      <!-- Flex container for the main content -->
      <div class="flex flex-row gap-4 items-start">

        <div class="flex-grow bg-white border-4 border-blue-500 rounded-lg shadow-md overflow-hidden">
          <div ref="chartContainer" class="h-96 y-96"></div> 
        </div>

        <div class="flex flex-col w-96 bg-white p-6 rounded-lg shadow-md h-full">
          <div class="text-5xl font-bold text-gray-800 mb-5">{{ species }}</div>

          <div class="space-y-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="filterSeller">Filter by Seller</label>
            <select v-model="filterSeller" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
              <option value="">All Sellers</option>
              <option v-for="seller in uniqueSellers" :key="seller" :value="seller">{{ seller }}</option>
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
    <ul class="container mx-auto px-6 py-6 bg-gray-200 rounded-lg space-y-8">
      <li v-for="entry in filteredEntries" :key="entry.id">
        Seller: {{ entry.seller }}, Price: {{ entry.price }}
        <button @click="saveMaterial(entry.id)" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
      </li>
    </ul>

  </AuthenticatedLayout>
</template>
<!-- <div ref="chartContainer" class="h-96">  -->
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps, onMounted, ref, computed, watchEffect } from 'vue';
import * as echarts from 'echarts';

const props = defineProps({
  entries: Array, // Assuming entries are passed from Laravel
  species: String,
});

const chartContainer = ref(null);
const entries = ref(props.entries);
const filterSeller = ref('');
const filterClass = ref('');
const filterDiameter = ref('');
const filterLength = ref('');
const filterLocation = ref('');

// Compute filtered entries based on multiple criteria
const filteredEntries = computed(() => {
  return entries.value.filter(entry =>
    (filterSeller.value === '' || entry.seller.toLowerCase().includes(filterSeller.value.toLowerCase())) &&
    (filterClass.value === '' || entry.class === filterClass.value) &&
    (filterDiameter.value === '' || entry.diameter === filterDiameter.value) &&
    (filterLength.value === '' || entry.length === filterLength.value) &&
    (filterLocation.value === '' || entry.location.toLowerCase().includes(filterLocation.value.toLowerCase()))
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



const csrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : null;

if (!csrfToken) {
  console.error('CSRF token not found');
} else {
  console.log('CSRF Token:', csrfToken); // You can remove this line once you confirm it's working
}


const saveMaterial = async (timberSpeciesId) => {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  try {
    const response = await fetch('/api/save-material', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken, // Use the CSRF token
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



// Watch effect to update the chart whenever any filter changes
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

  // Use filtered data for the chart
  const xAxisData = filteredEntries.value.map(entry => entry.seller);
  const yAxisData = filteredEntries.value.map(entry => ({
    price: entry.price,
    class: entry.class, // Include class data
    location: entry.location // Include location data
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
