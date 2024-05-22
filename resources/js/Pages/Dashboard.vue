<template>
    <AuthenticatedLayout>
      <div class="dark:bg-neutral-800">

      </div>
    </AuthenticatedLayout>
</template>
  
  <script setup>
  import { computed } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import TimberCategory from './TimberCategory.vue';
  import TimberChart from './TimberChart.vue';
  
  </script>
  