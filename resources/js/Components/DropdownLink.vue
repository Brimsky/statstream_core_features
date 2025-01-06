<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: {
        type: String,
        required: true,
    },
    as: {
        type: String,
        default: 'a',
    },
    method: {
        type: String,
        default: 'get',
    },
    preserve: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div>
        <Link
            v-if="as === 'a'"
            :href="href"
            :class="
                'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'
            "
        >
            <slot />
        </Link>

        <button
            v-else-if="as === 'button'"
            type="submit"
            :class="
                'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'
            "
            @click="
                $inertia.visit(href, {
                    method: method,
                    preserveScroll: preserve,
                })
            "
        >
            <slot />
        </button>
    </div>
</template>
