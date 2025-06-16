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
            <span class="text-white/80">Willkommen, Mitarbeiter</span>
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
            <Link :href="route('employee.dashboard')" 
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

      <!-- Page Content -->
      <div class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-8">
        <div class="text-center">
          <h2 class="text-3xl font-bold text-white mb-4">Aufträge</h2>
          <p class="text-white/80 text-lg mb-6">
            Hier können Sie alle Aufträge verwalten und neue Aufträge erstellen.
          </p>
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
