<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = usePage().props;
const savedMaterials = ref(props.savedMaterials || []); // Ensure it's always an array
</script>

<template>
    <AuthenticatedLayout>
        <div>
            <h1>Saved Materials</h1>
            <div v-if="savedMaterials.length">
                <ul>
                    <li v-for="material in savedMaterials" :key="material.id">
                    {{ material.material_name }} - Quantity: {{ material.quantity }}
                    </li>
                </ul>
            </div>
            <div v-else>
                <p>No materials saved yet.</p>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
