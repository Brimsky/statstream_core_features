<template>
  <AuthenticatedLayout>
    <div class="flex flex-col items-center justify-center mx-auto">
      <h1 class="text-5xl font-bold py-10">{{ species }}</h1>
      <div>
        <div ref="chartContainer" style="width: 1000px; height: 600px;"></div>
      </div>
      <div class="space-y-4">
        <input v-model="filterSeller" placeholder="Filter by Seller">
        <input v-model.number="filterClass" placeholder="Filter by Class">
        <input v-model.number="filterDiameter" placeholder="Filter by Diameter (cm)">
        <input v-model.number="filterLength" placeholder="Filter by Length (m)">
        <input v-model="filterLocation" placeholder="Filter by Location">
      </div>
      <ul>
        <li v-for="entry in filteredEntries" :key="entry.id">
          Class: {{ entry.class }}, Diameter: {{ entry.diameter }} cm, Length: {{ entry.length }} m, Seller: {{ entry.seller }}, Location: {{ entry.location }}, Price: {{ entry.price }}, Date: {{ entry.date }}
        </li>
      </ul>
    </div>
  </AuthenticatedLayout>
</template>

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
  const yAxisData = filteredEntries.value.map(entry => entry.price);

  chart.setOption({
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
      data: yAxisData,
    }]
  });
}
</script>
