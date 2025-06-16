<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <!-- Navigation -->
    <nav class="glass-nav sticky top-0 z-50 backdrop-blur-md bg-white/10 dark:bg-black/10 border-b border-white/20 dark:border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
              </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">GCT - Kundenportal</h1>
          </div>
          
          <div class="flex items-center space-x-4">
            <span class="text-white/80">Willkommen, Kunde</span>
            <Link :href="route('logout')" method="post" class="glass-button bg-red-500/20 hover:bg-red-500/30 text-red-400 border border-red-400/30 px-4 py-2 rounded-lg transition-all duration-300">
              Abmelden
            </Link>
          </div>
        </div>
      </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Navigation Tabs -->
      <div class="mb-8">
        <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-2">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
            <Link :href="route('customer.dashboard')" 
                  :class="[page.component === 'Customer/Dashboard' ? 'bg-orange-500/30 text-orange-400' : 'text-white/80 hover:text-white hover:bg-white/10']"
                  class="px-4 py-3 rounded-lg transition-all duration-300 text-center font-medium">
              Dashboard
            </Link>
            <Link :href="route('customer.orders')" 
                  :class="[page.component === 'Customer/Orders' ? 'bg-orange-500/30 text-orange-400' : 'text-white/80 hover:text-white hover:bg-white/10']"
                  class="px-4 py-3 rounded-lg transition-all duration-300 text-center font-medium">
              Meine Aufträge
            </Link>
            <Link :href="route('customer.request')" 
                  :class="[page.component === 'Customer/Request' ? 'bg-orange-500/30 text-orange-400' : 'text-white/80 hover:text-white hover:bg-white/10']"
                  class="px-4 py-3 rounded-lg transition-all duration-300 text-center font-medium">
              Neue Anfrage
            </Link>
          </div>
        </div>
      </div>

      <!-- Dashboard Content -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Welcome Card -->
          <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-8">
            <div class="text-center">
              <h2 class="text-3xl font-bold text-white mb-4">Willkommen bei Gulf Coast Towing</h2>
              <p class="text-white/80 text-lg">
                Ihr zuverlässiger Partner für Abschleppdienste in Los Santos. Wir sind 24/7 für Sie da.
              </p>
            </div>
          </div>

          <!-- Recent Orders -->
          <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
            <h3 class="text-xl font-bold text-white mb-4">Ihre letzten Aufträge</h3>
            <div v-if="recentOrders.length > 0" class="space-y-4">
              <div v-for="order in recentOrders" :key="order.id" class="flex items-center justify-between p-4 bg-white/5 rounded-lg">
                <div class="flex items-center space-x-4">
                  <div :class="getStatusColor(order.status)" class="w-3 h-3 rounded-full"></div>
                  <div>
                    <p class="text-white font-medium">Auftrag #{{ order.id }}</p>
                    <p class="text-white/80 text-sm">{{ order.service }} - {{ order.location }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-white font-medium">${{ order.amount }}</p>
                  <p class="text-white/80 text-sm">{{ order.date }}</p>
                </div>
              </div>
            </div>
            <div v-else class="text-center py-8">
              <svg class="w-16 h-16 text-white/40 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
              </svg>
              <p class="text-white/80">Sie haben noch keine Aufträge erstellt.</p>
              <Link :href="route('customer.request')" class="glass-button bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 border border-orange-400/30 px-6 py-2 rounded-lg transition-all duration-300 mt-4 inline-block">
                Ersten Auftrag erstellen
              </Link>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          <!-- Quick Info -->
          <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
            <h3 class="text-xl font-bold text-white mb-4">Notfall Kontakt</h3>
            <div class="space-y-4">
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-white font-medium">Notruf</p>
                  <p class="text-red-400 font-bold">333</p>
                </div>
              </div>
              <p class="text-white/80 text-sm">
                Bei Notfällen rufen Sie sofort die 333 an. Unser Team ist 24/7 verfügbar.
              </p>
            </div>
          </div>

          <!-- Service Status -->
          <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
            <h3 class="text-xl font-bold text-white mb-4">Service Status</h3>
            <div class="space-y-3">
              <div class="flex items-center justify-between">
                <span class="text-white/80">Verfügbarkeit</span>
                <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs">24/7 Online</span>
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
    case 'completed': return 'bg-green-400';
    case 'active': return 'bg-orange-400';
    case 'pending': return 'bg-yellow-400';
    default: return 'bg-gray-400';
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
