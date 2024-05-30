<template>
  <AuthenticatedLayout>
    <div class="flex flex-col items-center justify-center mx-auto">
      <h1 class="text-5xl font-bold py-10 dark:text-white text-black">Available Species</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="item in species" :key="item.speacies" class="cursor-pointer transform hover:scale-105 transition-transform duration-300">
          <Link :href="route('timber-chart.show', { species: item.speacies })" class="block overflow-hidden dark:bg-neutral-800 bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 ease-in-out p-6 flex items-center justify-center">
            <h2 class="text-2xl font-bold tracking-tight dark:text-white text-black text-center">{{ item.speacies }}</h2>
          </Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  species: Array
});

// console.log(props.species);
</script>

<style scoped>
/* Enhance overall styles */
.grid {
  gap: 2rem;
}
h1 {
  font-family: 'Inter', sans-serif;
}
h2 {
  font-family: 'Inter', sans-serif;
}
@media (min-width: 768px) {
  .grid {
    gap: 3rem;
  }
}
</style>
