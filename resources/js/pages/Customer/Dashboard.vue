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

            <!-- Dashboard Content -->
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Main Content -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Welcome Card -->
                    <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                        <div class="text-center">
                            <h2 class="mb-4 text-3xl font-bold text-white">Willkommen bei Gulf Coast Towing</h2>
                            <p class="text-lg text-white/80">
                                Ihr zuverlässiger Partner für Abschleppdienste in Los Santos. Wir sind 24/7 für Sie da.
                            </p>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                        <h3 class="mb-4 text-xl font-bold text-white">Ihre letzten Aufträge</h3>
                        <div v-if="recentOrders.length > 0" class="space-y-4">
                            <div v-for="order in recentOrders" :key="order.id" class="flex items-center justify-between rounded-lg bg-white/5 p-4">
                                <div class="flex items-center space-x-4">
                                    <div :class="getStatusColor(order.status)" class="h-3 w-3 rounded-full"></div>
                                    <div>
                                        <p class="font-medium text-white">Auftrag #{{ order.id }}</p>
                                        <p class="text-sm text-white/80">{{ order.service }} - {{ order.location }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium text-white">${{ order.amount }}</p>
                                    <p class="text-sm text-white/80">{{ order.date }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-else class="py-8 text-center">
                            <svg class="mx-auto mb-4 h-16 w-16 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                ></path>
                            </svg>
                            <p class="text-white/80">Sie haben noch keine Aufträge erstellt.</p>
                            <Link
                                :href="route('customer.request')"
                                class="glass-button mt-4 inline-block rounded-lg border border-orange-400/30 bg-orange-500/20 px-6 py-2 text-orange-400 transition-all duration-300 hover:bg-orange-500/30"
                            >
                                Ersten Auftrag erstellen
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Info -->
                    <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                        <h3 class="mb-4 text-xl font-bold text-white">Notfall Kontakt</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-500/20">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                        ></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-white">Notruf</p>
                                    <p class="font-bold text-red-400">333</p>
                                </div>
                            </div>
                            <p class="text-sm text-white/80">Bei Notfällen rufen Sie sofort die 333 an. Unser Team ist 24/7 verfügbar.</p>
                        </div>
                    </div>

                    <!-- Service Status -->
                    <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                        <h3 class="mb-4 text-xl font-bold text-white">Service Status</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-white/80">Verfügbarkeit</span>
                                <span class="rounded-full bg-green-500/20 px-2 py-1 text-xs text-green-400">24/7 Online</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-white/80">Durchschnittliche Ankunftszeit</span>
                                <span class="text-white">15-20 Min</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-white/80">Aktive Fahrzeuge</span>
                                <span class="text-white">{{ activeVehicles }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const page = usePage();

interface Order {
    id: number;
    service: string;
    location: string;
    amount: number;
    date: string;
    status: string;
}

// Mock data - später durch echte API-Calls ersetzen
const recentOrders = ref<Order[]>([
    // {
    //   id: 1001,
    //   service: 'Abschleppdienst',
    //   location: 'Downtown LS',
    //   amount: 150,
    //   date: '2025-06-14',
    //   status: 'completed'
    // }
]);

const activeVehicles = ref(5);

const getStatusColor = (status: string) => {
    switch (status) {
        case 'completed':
            return 'bg-green-400';
        case 'active':
            return 'bg-orange-400';
        case 'pending':
            return 'bg-yellow-400';
        default:
            return 'bg-gray-400';
    }
};
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
