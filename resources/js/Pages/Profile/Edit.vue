<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { useTheme } from "@/composables/useTheme";
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';

const { isDark, gradients } = useTheme();

// Computed gradient text class
const gradientTextClass = computed(() => gradients.text.value);

const { user } = usePage().props.auth;

const toggleVip = () => {
    Inertia.post('/toggle-vip');
};

const vipStatus = computed(() => user?.vip_status);

defineProps({
    auth: {
        user: Object,
    },
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <AuthenticatedLayout>

        <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-neutral-800 rounded-xl shadow-lg">
    <div class="text-center dark:text-white text-black">
      <h2 class="text-2xl font-bold mb-4">Membership Status</h2>
      <p v-if="user && user.vip_status" class="mb-4 text-xl font-bold">You are a <span :class="gradientTextClass">VIP Member!</span></p>
      <p v-else class="mb-4 text-lg">You are not a VIP Member.</p>
      <button v-if="!user.vip_status" @click="toggleVip" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 transition duration-150">Become a VIP</button>
    </div>
  </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 dark:bg-neutral-800 bg-white shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 dark:bg-neutral-800 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 dark:bg-neutral-800 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
