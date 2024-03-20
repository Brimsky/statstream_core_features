<template>
    <GuestLayout>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-gray-200 to-gray-400 dark:from-neutral-700 dark:to-neutral-800">
      <form class="w-full max-w-2xl bg-white dark:bg-neutral-900 shadow-md px-8 pt-6 pb-8 mb-4 rounded-lg">
        <div class="mb-6">
          <h2 class="text-center text-5xl font-bold text-black dark:text-white">Login</h2>
        </div>
        <div class="mb-4">
          <label class="form-label">Email</label>
          <input type="text" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500" placeholder="Email">
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mb-4">
          <label class="form-label">Password</label>
          <input type="text" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500" placeholder="Password">
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        <div class="mb-4 flex items-center justify-center">
          <h4 class="text-black dark:text-gray-200">Don't have an account?<router-link to="/signup" class="ml-1 text-blue-500 hover:text-blue-800 dark:text-violet-500 dark:hover:text-violet-800">Click here!</router-link></h4>
        </div>
        <label class="flex items-center">
            <Checkbox name="remember" v-model:checked="form.remember" />
            <span class="ms-2 text-sm text-gray-600">Remember me</span>
        </label>
        <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >Forgot your password?
                </Link>
        </div>
        <div class="flex items-center justify-between pt-5">
          <button class="form-button" type="button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Login
          </button>
        </div>
      </form>
    </div>
</GuestLayout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>