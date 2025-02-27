<template>
    <MainLayout>
        <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-neutral-900">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Koku sugas</h1>
                    <button
                        @click="toggleTheme"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                        :class="isDark 
                            ? 'bg-neutral-700 text-gray-200 hover:bg-neutral-600' 
                            : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                    >
                        <SunIcon v-if="isDark" class="w-5 h-5 mr-2" />
                        <MoonIcon v-else class="w-5 h-5 mr-2" />
                        {{ isDark ? 'Gaišais režīms' : 'Tumšais režīms' }}
                    </button>
                </div>
                
                <div class="species-grid">
                    <Link
                        v-for="item in species"
                        :key="item.name"
                        :href="route('timber.show', { species: item.name })"
                        class="species-card"
                    >
                        <div class="icon-container">
                            <img :src="getSpeciesIcon(item.name)" :alt="item.name" />
                        </div>
                        <h2 class="species-name">
                            {{ item.name }}
                        </h2>
                    </Link>
                </div>

                <!-- Debug output -->
                <!-- <pre class="mt-8 p-4 bg-gray-100 dark:bg-neutral-800 rounded-lg overflow-auto">
                    {{ species }}
                </pre> -->
            </div>
        </div>
    </MainLayout>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { Link } from "@inertiajs/vue3";
import { defineProps, ref, onMounted } from "vue";
import { SunIcon, MoonIcon } from "@heroicons/vue/24/outline";
import birch from "@/icons/timber/birch.png";
import pine from "@/icons/timber/pine.png";
import spruce from "@/icons/timber/spruce.png";
import aspen from "@/icons/timber/aspen.png";
import oak from "@/icons/timber/oak.png";
import ash from "@/icons/timber/ash.png";
import alder from "@/icons/timber/alder.png";
import maple from "@/icons/timber/maple.png";
import logs from "@/icons/timber/logs.png";

const isDark = ref(document.documentElement.classList.contains('dark'));

const toggleTheme = () => {
    isDark.value = !isDark.value;
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
};

// Initialize theme from localStorage on mount
onMounted(() => {
    const theme = localStorage.getItem('theme');
    if (theme) {
        isDark.value = theme === 'dark';
        document.documentElement.classList.toggle('dark', isDark.value);
    }
});

const props = defineProps({
    species: {
        type: Array,
        required: true
    }
});

function getSpeciesIcon(speciesName) {
    const iconMap = {
        'Bērzs': birch,
        'Priede': pine,
        'Egle': spruce,
        'Apse': aspen,
        'Ozols': oak,
        'Osis': ash,
        'Alksnis': alder,
        'Kļava': maple
    };
    
    return iconMap[speciesName] || logs;
}
</script>

<style scoped>
.species-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
    padding: 1rem;
}

.species-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.species-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.icon-container {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-container img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.species-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1a1a1a;
}

/* Dark mode */
:root.dark .species-card {
    background: #1f2937;
}

:root.dark .species-name {
    color: white;
}
</style>
