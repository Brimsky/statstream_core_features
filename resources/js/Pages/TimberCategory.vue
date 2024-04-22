<template>
  <AuthenticatedLayout>
  <div>
    <h1>Available Species</h1>
    <ul>
      <li v-for="item in species" :key="item.speacies" >
        <Link :href="route('timber-chart.show', item.speacies)">{{ item.speacies }}</Link>
      </li>
    </ul>
  </div>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  species: Array
});
</script>
