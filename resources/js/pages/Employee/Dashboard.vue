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
            <h1 class="text-2xl font-bold text-white">GCT - Mitarbeiterportal</h1>
          </div>
            <div class="flex items-center space-x-4">
            <div class="text-right">
              <div class="text-white font-medium">{{ employee.first_name }} {{ employee.last_name }}</div>
              <div class="text-white/60 text-sm">{{ employee.rank.name }}</div>
            </div>
            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
              <span class="text-white font-bold text-sm">{{ employee.first_name.charAt(0) }}{{ employee.last_name.charAt(0) }}</span>
            </div>
            <Link :href="route('employee.logout')" method="post" class="glass-button bg-red-500/20 hover:bg-red-500/30 text-red-400 border border-red-400/30 px-4 py-2 rounded-lg transition-all duration-300">
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
          <div class="grid grid-cols-1 md:grid-cols-3 gap-2">            <Link :href="route('employee.dashboard')" 
                  :class="[page.component === 'Employee/Dashboard' ? 'bg-orange-500/30 text-orange-400' : 'text-white/80 hover:text-white hover:bg-white/10']"
                  class="px-4 py-3 rounded-lg transition-all duration-300 text-center font-medium">
              Dashboard
            </Link>
            <Link :href="route('employee.orders')" 
                  :class="[page.component === 'Employee/Orders' ? 'bg-orange-500/30 text-orange-400' : 'text-white/80 hover:text-white hover:bg-white/10']"
                  class="px-4 py-3 rounded-lg transition-all duration-300 text-center font-medium">
              Aufträge
            </Link>
            <Link :href="route('employee.vehicles')" 
                  :class="[page.component === 'Employee/Vehicles' ? 'bg-orange-500/30 text-orange-400' : 'text-white/80 hover:text-white hover:bg-white/10']"
                  class="px-4 py-3 rounded-lg transition-all duration-300 text-center font-medium">
              Fahrzeuge
            </Link>
          </div>
        </div>
      </div>

      <!-- Dashboard Content -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Statistics Cards -->
        <div class="lg:col-span-2 space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-white/80 text-sm">Heutige Aufträge</p>
                  <p class="text-2xl font-bold text-white">{{ stats.todayOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center">
                  <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-white/80 text-sm">Aktive Aufträge</p>
                  <p class="text-2xl font-bold text-white">{{ stats.activeOrders }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                  <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                  </svg>
                </div>
              </div>
            </div>

            <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-white/80 text-sm">Einnahmen Heute</p>
                  <p class="text-2xl font-bold text-white">${{ stats.todayEarnings }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                  <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Orders -->
          <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
            <h3 class="text-xl font-bold text-white mb-4">Neueste Aufträge</h3>
            <div class="space-y-4">
              <div v-for="order in recentOrders" :key="order.id" class="flex items-center justify-between p-4 bg-white/5 rounded-lg">
                <div class="flex items-center space-x-4">
                  <div :class="getStatusColor(order.status)" class="w-3 h-3 rounded-full"></div>
                  <div>
                    <p class="text-white font-medium">{{ order.customerName }}</p>
                    <p class="text-white/80 text-sm">{{ order.location }}</p>
                  </div>
                </div>
                <div class="text-right">
                  <p class="text-white font-medium">${{ order.amount }}</p>
                  <p class="text-white/80 text-sm">{{ order.time }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          <!-- Quick Actions -->
          <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
            <h3 class="text-xl font-bold text-white mb-4">Schnellaktionen</h3>
            <div class="space-y-3">
              <button class="w-full glass-button bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 border border-orange-400/30 px-4 py-3 rounded-lg transition-all duration-300 text-left">
                Neuen Auftrag erstellen
              </button>
              <button class="w-full glass-button bg-green-500/20 hover:bg-green-500/30 text-green-400 border border-green-400/30 px-4 py-3 rounded-lg transition-all duration-300 text-left">
                Fahrzeug Status ändern
              </button>
              <button class="w-full glass-button bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 border border-blue-400/30 px-4 py-3 rounded-lg transition-all duration-300 text-left">
                Schichtbericht
              </button>
            </div>
          </div>

          <!-- Available Vehicles -->
          <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6">
            <h3 class="text-xl font-bold text-white mb-4">Verfügbare Fahrzeuge</h3>
            <div class="space-y-3">
              <div v-for="vehicle in availableVehicles" :key="vehicle.id" class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                <div>
                  <p class="text-white font-medium">{{ vehicle.name }}</p>
                  <p class="text-white/80 text-sm">{{ vehicle.type }}</p>
                </div>
                <div :class="vehicle.available ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'" class="px-2 py-1 rounded-full text-xs">
                  {{ vehicle.available ? 'Verfügbar' : 'Im Einsatz' }}
                </div>
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

interface Employee {
  id: number;
  steam_id: string;
  first_name: string;
  last_name: string;
  phone_number: string;
  rank_id: number;
  rank: {
    id: number;
    name: string;
  };
}

defineProps<{
  employee: Employee;
}>();

const page = usePage();

// Mock data - später durch echte API-Calls ersetzen
const stats = ref({
  todayOrders: 12,
  activeOrders: 3,
  todayEarnings: 1850
});

const recentOrders = ref([
  {
    id: 1,
    customerName: 'Max Mustermann',
    location: 'Downtown LS',
    amount: 150,
    time: '14:30',
    status: 'completed'
  },
  {
    id: 2,
    customerName: 'Anna Schmidt',
    location: 'Sandy Shores',
    amount: 220,
    time: '13:15',
    status: 'active'
  },
  {
    id: 3,
    customerName: 'Tom Weber',
    location: 'Paleto Bay',
    amount: 180,
    time: '12:45',
    status: 'pending'
  }
]);

const availableVehicles = ref([
  {
    id: 1,
    name: 'Abschleppwagen #1',
    type: 'Standard',
    available: true
  },
  {
    id: 2,
    name: 'Abschleppwagen #2',
    type: 'Schwerlast',
    available: false
  },
  {
    id: 3,
    name: 'Service Van #1',
    type: 'Pannenhilfe',
    available: true
  }
]);

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
