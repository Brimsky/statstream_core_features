<template>
  <AuthenticatedLayout>
    <div>
      <h1>Details for Species: {{ species }}</h1>
      <ul>
        <li v-for="entry in entries" :key="entry.id">
          Class: {{ entry.class }}, Diameter: {{ entry.diameter }} cm, Length: {{ entry.length }} m, Seller: {{ entry.seller }}, Location: {{ entry.location }}, Price: {{ entry.price }}, Date: {{ entry.date }}
        </li>
      </ul>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';


const props = defineProps({
  entries: Array,
  species: String
});
</script>
