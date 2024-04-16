<template>
  <div>
    <h1>Available Species</h1>
    <ul>
      <li v-for="item in species" :key="item.speacies">
        <InertiaLink :href="route('timber-chart.show', item.speacies)">{{ item.speacies }}</InertiaLink>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { InertiaLink } from '@inertiajs/inertia-vue3';

const props = defineProps({
  species: Array
});
</script>
