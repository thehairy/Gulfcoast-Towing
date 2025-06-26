<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Navigation -->
        <nav class="glass-nav sticky top-0 z-50 border-b border-white/20 bg-white/10 backdrop-blur-md dark:border-white/10 dark:bg-black/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 to-orange-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                ></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white">GCT - Kundenportal</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-white/80">Willkommen, Kunde</span>
                        <Link
                            :href="route('logout')"
                            method="post"
                            class="glass-button rounded-lg border border-red-400/30 bg-red-500/20 px-4 py-2 text-red-400 transition-all duration-300 hover:bg-red-500/30"
                        >
                            Abmelden
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Navigation Tabs -->
            <div class="mb-8">
                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-2 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-3">
                        <Link
                            :href="route('customer.dashboard')"
                            :class="[
                                page.component === 'Customer/Dashboard'
                                    ? 'bg-orange-500/30 text-orange-400'
                                    : 'text-white/80 hover:bg-white/10 hover:text-white',
                            ]"
                            class="rounded-lg px-4 py-3 text-center font-medium transition-all duration-300"
                        >
                            Dashboard
                        </Link>
                        <Link
                            :href="route('customer.orders')"
                            :class="[
                                page.component === 'Customer/Orders'
                                    ? 'bg-orange-500/30 text-orange-400'
                                    : 'text-white/80 hover:bg-white/10 hover:text-white',
                            ]"
                            class="rounded-lg px-4 py-3 text-center font-medium transition-all duration-300"
                        >
                            Meine Aufträge
                        </Link>
                        <Link
                            :href="route('customer.request')"
                            :class="[
                                page.component === 'Customer/Request'
                                    ? 'bg-orange-500/30 text-orange-400'
                                    : 'text-white/80 hover:bg-white/10 hover:text-white',
                            ]"
                            class="rounded-lg px-4 py-3 text-center font-medium transition-all duration-300"
                        >
                            Neue Anfrage
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                <div class="text-center">
                    <h2 class="mb-4 text-3xl font-bold text-white">Meine Aufträge</h2>
                    <p class="mb-6 text-lg text-white/80">Hier sehen Sie alle Ihre vergangenen und aktuellen Aufträge.</p>
                    <div class="text-white/60">
                        <p>Diese Seite wird in Kürze implementiert.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage();
</script>

<style scoped>
.glass-nav {
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}

.glass-card {
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}

.glass-button {
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    cursor: pointer;
}
</style>
