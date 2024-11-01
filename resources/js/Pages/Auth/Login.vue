<template>
    <section
        class="min-h-screen flex items-center justify-center relative overflow-hidden"
        :class="[
            'bg-gradient-to-br',
            isDark
                ? 'from-neutral-900 to-neutral-800'
                : 'from-blue-50 via-white to-blue-50',
        ]"
    >
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -right-10 top-1/4 w-72 h-72 rounded-full blur-3xl animate-pulse"
                :class="isDark ? 'bg-purple-500/10' : 'bg-blue-500/5'"
            ></div>
            <div
                class="absolute -left-10 bottom-1/4 w-72 h-72 rounded-full blur-3xl animate-pulse delay-700"
                :class="isDark ? 'bg-blue-500/10' : 'bg-teal-500/5'"
            ></div>
        </div>

        <div
            class="flex flex-col items-center justify-center px-4 sm:px-6 py-8 mx-auto relative z-10 w-full"
        >
            <!-- Mobile Logo -->
            <a
                href="/"
                class="flex items-center mb-8 space-x-3 text-2xl font-bold md:hidden"
            >
                <img class="h-12 w-auto" :src="iconSrc" alt="Icon" />
                <span
                    class="bg-clip-text text-transparent"
                    :class="
                        isDark
                            ? 'bg-gradient-to-r from-purple-400 to-blue-500'
                            : 'bg-gradient-to-r from-blue-600 to-teal-500'
                    "
                >
                    STATSTREAM
                </span>
            </a>

            <!-- Login Card -->
            <div class="w-full max-w-md md:max-w-5xl transform transition-all">
                <div
                    class="rounded-2xl shadow-xl overflow-hidden border"
                    :class="
                        isDark
                            ? 'bg-neutral-800 border-neutral-700'
                            : 'bg-white/80 backdrop-blur-sm border-gray-100'
                    "
                >
                    <!-- Desktop layout -->
                    <div class="md:flex">
                        <!-- Left side - Branding -->
                        <div
                            class="hidden md:flex md:w-1/2 p-12 flex-col justify-center items-center text-white"
                            :class="
                                isDark
                                    ? 'bg-gradient-to-br from-purple-500 to-blue-600'
                                    : 'bg-gradient-to-br from-blue-600 to-teal-500'
                            "
                        >
                            <img
                                class="h-20 w-auto mb-8"
                                :src="iconSrc"
                                alt="Icon"
                            />
                            <h2 class="text-3xl font-bold mb-4 text-center">
                                Welcome Back to STATSTREAM
                            </h2>
                            <p
                                class="text-lg text-center"
                                :class="
                                    isDark ? 'text-purple-100' : 'text-blue-100'
                                "
                            >
                                Access your account to manage your timber
                                analytics and insights
                            </p>
                        </div>

                        <!-- Right side - Form -->
                        <div class="w-full md:w-1/2">
                            <div class="p-8 md:p-12 space-y-6">
                                <div class="text-center">
                                    <h1
                                        class="text-2xl font-bold bg-clip-text text-transparent"
                                        :class="
                                            isDark
                                                ? 'bg-gradient-to-r from-purple-400 to-blue-500'
                                                : 'bg-gradient-to-r from-blue-600 to-teal-500'
                                        "
                                    >
                                        Sign In
                                    </h1>
                                    <p
                                        class="mt-2 text-sm"
                                        :class="
                                            isDark
                                                ? 'text-gray-300'
                                                : 'text-gray-600'
                                        "
                                    >
                                        Access your STATSTREAM account
                                    </p>
                                </div>

                                <form
                                    @submit.prevent="submit"
                                    class="space-y-5"
                                >
                                    <!-- Email input -->
                                    <div class="space-y-2">
                                        <label
                                            for="email"
                                            class="text-sm font-medium"
                                            :class="
                                                isDark
                                                    ? 'text-gray-200'
                                                    : 'text-gray-700'
                                            "
                                        >
                                            Email
                                        </label>
                                        <div class="relative">
                                            <input
                                                type="email"
                                                id="email"
                                                v-model="form.email"
                                                class="w-full px-4 py-3 rounded-lg border transition-all"
                                                :class="[
                                                    isDark
                                                        ? 'border-neutral-600 bg-neutral-700 text-gray-100 focus:ring-purple-500'
                                                        : 'border-gray-200 bg-white/50 text-gray-700 focus:ring-blue-500',
                                                ]"
                                                placeholder="name@example.com"
                                                required
                                            />
                                        </div>
                                        <InputError
                                            :message="form.errors.email"
                                            class="mt-1"
                                        />
                                    </div>

                                    <!-- Password input -->
                                    <div class="space-y-2">
                                        <label
                                            for="password"
                                            class="text-sm font-medium"
                                            :class="
                                                isDark
                                                    ? 'text-gray-200'
                                                    : 'text-gray-700'
                                            "
                                        >
                                            Password
                                        </label>
                                        <div class="relative">
                                            <input
                                                type="password"
                                                id="password"
                                                v-model="form.password"
                                                class="w-full px-4 py-3 rounded-lg border transition-all"
                                                :class="[
                                                    isDark
                                                        ? 'border-neutral-600 bg-neutral-700 text-gray-100 focus:ring-purple-500'
                                                        : 'border-gray-200 bg-white/50 text-gray-700 focus:ring-blue-500',
                                                ]"
                                                placeholder="••••••••"
                                                required
                                            />
                                        </div>
                                        <InputError
                                            :message="form.errors.password"
                                            class="mt-1"
                                        />
                                    </div>

                                    <!-- Remember me and Forgot password -->
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <div
                                            class="flex items-center space-x-2"
                                        >
                                            <input
                                                type="checkbox"
                                                id="remember"
                                                class="w-4 h-4 rounded border transition-colors"
                                                :class="[
                                                    isDark
                                                        ? 'border-neutral-600 bg-neutral-700 text-purple-600 focus:ring-purple-500'
                                                        : 'border-gray-300 bg-white text-blue-600 focus:ring-blue-500',
                                                ]"
                                            />
                                            <label
                                                for="remember"
                                                class="text-sm"
                                                :class="
                                                    isDark
                                                        ? 'text-gray-300'
                                                        : 'text-gray-600'
                                                "
                                            >
                                                Remember me
                                            </label>
                                        </div>
                                        <a
                                            href="#"
                                            class="text-sm font-medium hover:underline"
                                            :class="
                                                isDark
                                                    ? 'text-purple-400'
                                                    : 'text-blue-600'
                                            "
                                        >
                                            Forgot password?
                                        </a>
                                    </div>

                                    <!-- Submit button -->
                                    <button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="group relative w-full py-3 px-4 rounded-lg font-medium text-white overflow-hidden transition-all duration-300"
                                    >
                                        <div
                                            class="absolute inset-0 transition-opacity"
                                            :class="[
                                                isDark
                                                    ? 'bg-gradient-to-r from-purple-600 to-blue-600'
                                                    : 'bg-gradient-to-r from-blue-600 to-teal-500',
                                            ]"
                                        ></div>
                                        <div
                                            class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity"
                                            :class="[
                                                isDark
                                                    ? 'bg-gradient-to-r from-blue-600 to-purple-600'
                                                    : 'bg-gradient-to-r from-teal-500 to-blue-600',
                                            ]"
                                        ></div>
                                        <span class="relative z-10">
                                            {{
                                                form.processing
                                                    ? "Signing in..."
                                                    : "Sign in"
                                            }}
                                        </span>
                                    </button>

                                    <!-- Sign up link -->
                                    <p
                                        class="text-center text-sm"
                                        :class="
                                            isDark
                                                ? 'text-gray-300'
                                                : 'text-gray-600'
                                        "
                                    >
                                        Don't have an account?
                                        <a
                                            href="/register"
                                            class="font-medium hover:underline"
                                            :class="
                                                isDark
                                                    ? 'text-purple-400'
                                                    : 'text-blue-600'
                                            "
                                        >
                                            Sign up
                                        </a>
                                    </p>
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

const isDark = useDark();
const iconSrc = computed(() => (isDark.value ? darkIcon : lightIcon));

const form = useForm({
    email: "",
    password: "",
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
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

/* Responsive adjustments */
@media (max-width: 768px) {
    .md\:p-12 {
        padding: 2rem;
    }
}
</style>
