<template>
    <div class="bg-gray-50 dark:bg-gray-800 relative text-neutral-800 dark:text-white">
        <div class="h-[1000px] overflow-y-100 ">
          <About />
        </div>
        <div class="h-screen overflow-y-auto ">
          <Services />
        </div>
        <div class="h-screen overflow-y-auto ">
          <Portfolio />
        </div>
        <div class="h-screen overflow-y-auto">
          <Contact />
        </div>
      </div>
</template>
    
<script setup>
import Start from './Home/Start.vue'; 
</script>