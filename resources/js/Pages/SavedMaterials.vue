<template>
    <AuthenticatedLayout>
      <div class="container mx-auto px-4 py-6">
        <h1 class="text-xl font-bold">Saved Materials</h1>
        <div v-if="savedMaterials.length">
          <ul>
            <li v-for="material in savedMaterials" :key="material.id" class="mb-2">
              <p><strong>Material ID:</strong> {{ material.id }}</p>
              <p><strong>Species:</strong> {{ material.timber_species.speacies }}</p>
              <p><strong>Class:</strong> {{ material.timber_species.class }}</p>
              <p><strong>Diameter:</strong> {{ material.timber_species.diameter }}</p>
              <p><strong>Length:</strong> {{ material.timber_species.length }}</p>
              <p><strong>Seller:</strong> {{ material.timber_species.seller }}</p>
              <p><strong>Location:</strong> {{ material.timber_species.location }}</p>
              <p><strong>Price:</strong> {{ material.timber_species.price }}</p>
              <p><strong>Date:</strong> {{ material.timber_species.date }}</p>
            </li>
          </ul>
        </div>
        <div v-else>
          <p>No materials saved yet.</p>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  
  const { props } = usePage();
  const savedMaterials = computed(() => props.savedMaterials ?? []);
  
  console.log('Props:', props);
  console.log('Saved materials:', savedMaterials.value);
  </script>
  