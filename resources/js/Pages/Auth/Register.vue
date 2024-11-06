<template>
    <section
        class="min-h-screen flex items-center justify-center relative overflow-hidden bg-gradient-to-br from-white to-blue-50 dark:from-neutral-900 dark:to-neutral-800"
    >
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -right-10 top-1/4 w-72 h-72 bg-blue-500/5 dark:bg-purple-500/10 rounded-full blur-3xl animate-pulse"
            ></div>
            <div
                class="absolute -left-10 bottom-1/4 w-72 h-72 bg-teal-500/5 dark:bg-blue-500/10 rounded-full blur-3xl animate-pulse delay-700"
            ></div>
        </div>

        <div
            class="flex flex-col items-center justify-center px-4 sm:px-6 py-8 mx-auto relative z-10 w-full"
        >
            <!-- Logo section - Only visible on mobile -->
            <a
                href="/"
                class="flex items-center mb-8 space-x-3 text-2xl font-bold md:hidden"
            >
                <img class="h-12 w-auto" :src="iconSrc" alt="Icon" />
                <span
                    class="bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 bg-clip-text text-transparent"
                >
                    STATSTREAM
                </span>
            </a>

            <!-- Registration form card -->
            <div class="w-full max-w-md md:max-w-5xl transform transition-all">
                <div
                    class="bg-white/80 dark:bg-neutral-800 backdrop-blur-sm rounded-2xl shadow-xl dark:shadow-2xl overflow-hidden border border-gray-100 dark:border-neutral-700"
                >
                    <!-- Desktop layout -->
                    <div class="md:flex">
                        <!-- Left side - Branding (Only visible on desktop) -->
                        <div
                            class="hidden md:flex md:w-1/2 bg-gradient-to-br from-blue-600 to-teal-500 dark:from-purple-500 dark:to-blue-600 p-12 flex-col justify-center items-center text-white"
                        >
                            <img
                                class="h-20 w-auto mb-8"
                                :src="iconSrc"
                                alt="Icon"
                            />
                            <h2 class="text-3xl font-bold mb-4 text-center">
                                Welcome to STATSTREAM
                            </h2>
                            <p
                                class="text-lg text-center text-blue-100 dark:text-purple-100"
                            >
                                Join our community and start analyzing timber
                                data like never before
                            </p>
                        </div>

                        <!-- Right side - Registration form -->
                        <div class="w-full md:w-1/2">
                            <div class="p-8 md:p-12">
                                <div class="text-center mb-8">
                                    <h1
                                        class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-400 dark:to-blue-500 bg-clip-text text-transparent"
                                    >
                                        Create Your Account
                                    </h1>
                                    <p
                                        class="mt-2 text-sm text-gray-600 dark:text-gray-300"
                                    >
                                        Join STATSTREAM and unlock powerful
                                        timber analytics
                                    </p>
                                </div>

                                <form
                                    @submit.prevent="submit"
                                    class="space-y-6"
                                >
                                    <!-- Name fields row -->
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                                    >
                                        <div class="space-y-2">
                                            <label
                                                for="FirstName"
                                                class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                            >
                                                First Name
                                            </label>
                                            <input
                                                type="text"
                                                id="FirstName"
                                                v-model="form.name"
                                                class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-600 bg-white/50 dark:bg-neutral-700 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all"
                                                placeholder="John"
                                            />
                                            <InputError
                                                :message="form.errors.name"
                                            />
                                        </div>

                                        <div class="space-y-2">
                                            <label
                                                for="LastName"
                                                class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                            >
                                                Last Name
                                            </label>
                                            <input
                                                type="text"
                                                id="LastName"
                                                v-model="form.surname"
                                                class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-600 bg-white/50 dark:bg-neutral-700 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all"
                                                placeholder="Doe"
                                            />
                                        </div>
                                    </div>

                                    <!-- Email field -->
                                    <div class="space-y-2">
                                        <label
                                            for="Email"
                                            class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                        >
                                            Email
                                        </label>
                                        <input
                                            type="email"
                                            id="Email"
                                            v-model="form.email"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-600 bg-white/50 dark:bg-neutral-700 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all"
                                            placeholder="you@example.com"
                                        />
                                        <InputError
                                            :message="form.errors.email"
                                        />
                                    </div>

                                    <!-- Password fields -->
                                    <div
                                        class="grid grid-cols-1 sm:grid-cols-2 gap-4"
                                    >
                                        <div class="space-y-2">
                                            <label
                                                for="Password"
                                                class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                            >
                                                Password
                                            </label>
                                            <input
                                                type="password"
                                                id="Password"
                                                v-model="form.password"
                                                class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-600 bg-white/50 dark:bg-neutral-700 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all"
                                                placeholder="••••••••"
                                            />
                                            <InputError
                                                :message="form.errors.password"
                                            />
                                        </div>

                                        <div class="space-y-2">
                                            <label
                                                for="PasswordConfirmation"
                                                class="text-sm font-medium text-gray-700 dark:text-gray-200"
                                            >
                                                Confirm Password
                                            </label>
                                            <input
                                                type="password"
                                                id="PasswordConfirmation"
                                                v-model="
                                                    form.password_confirmation
                                                "
                                                class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-neutral-600 bg-white/50 dark:bg-neutral-700 text-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 dark:focus:ring-purple-500 focus:border-transparent transition-all"
                                                placeholder="••••••••"
                                            />
                                        </div>
                                    </div>

                                    <!-- Terms and conditions -->
                                    <div
                                        class="text-sm text-gray-600 dark:text-gray-300"
                                    >
                                        By creating an account, you agree to our
                                        <a
                                            href="#"
                                            class="font-medium text-blue-600 dark:text-purple-400 hover:underline"
                                            >Terms of Service</a
                                        >
                                        and
                                        <a
                                            href="#"
                                            class="font-medium text-blue-600 dark:text-purple-400 hover:underline"
                                            >Privacy Policy</a
                                        >.
                                    </div>

                                    <!-- Submit button -->
                                    <div
                                        class="flex flex-col sm:flex-row items-center justify-between gap-4"
                                    >
                                        <button
                                            type="submit"
                                            :disabled="form.processing"
                                            class="w-full sm:w-auto group relative px-8 py-3 font-medium text-white overflow-hidden rounded-lg transition-all duration-300"
                                        >
                                            <!-- Button background with gradient -->
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-teal-500 dark:from-purple-600 dark:to-blue-600"
                                            ></div>
                                            <!-- Hover gradient -->
                                            <div
                                                class="absolute inset-0 bg-gradient-to-r from-teal-500 to-blue-600 dark:from-blue-600 dark:to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity"
                                            ></div>
                                            <!-- Button text -->
                                            <span class="relative z-10">
                                                {{
                                                    form.processing
                                                        ? "Creating Account..."
                                                        : "Create Account"
                                                }}
                                            </span>
                                        </button>

                                        <p
                                            class="text-sm text-gray-600 dark:text-gray-300"
                                        >
                                            Already have an account?
                                            <a
                                                href="/login"
                                                class="font-medium text-blue-600 dark:text-purple-400 hover:underline"
                                            >
                                                Sign in
                                            </a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";
import { useDark } from "@vueuse/core";
import InputError from "@/Components/InputError.vue";
import lightIcon from "@/icons/Logo/icon.png";
import darkIcon from "@/icons/Logo/darkicon.png";

import { useTheme } from "@/Components/useTheme.js";

const { isDark, toggleTheme } = useTheme();
const iconSrc = computed(() => (isDark.value ? darkIcon : lightIcon));

const form = useForm({
    name: "",
    surname: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<style scoped>
@keyframes pulse {
    0%,
    100% {
        opacity: 0.1;
    }
    50% {
        opacity: 0.3;
    }
}

.animate-pulse {
    animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.delay-700 {
    animation-delay: 700ms;
}

/* Focus styles */
input:focus {
    outline: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .md\:p-12 {
        padding: 2rem;
    }
}
</style>
