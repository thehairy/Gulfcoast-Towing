<template>
  <div
    class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <!-- Navigation -->
    <nav
      class="glass-nav sticky top-0 z-50 backdrop-blur-md bg-white/10 dark:bg-black/10 border-b border-white/20 dark:border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center space-x-3">
            <h1 class="text-2xl font-bold text-white">Gulfcoast Towing</h1>
          </div>
          <div class="hidden md:flex items-center space-x-6">
            <a href="#home" class="text-white/80 hover:text-orange-400 transition-colors duration-300">Start</a>
            <a href="#services"
              class="text-white/80 hover:text-orange-400 transition-colors duration-300">Dienstleistungen</a>
            <a href="#prices" class="text-white/80 hover:text-orange-400 transition-colors duration-300">Preise</a>
            <a href="#contact" class="text-white/80 hover:text-orange-400 transition-colors duration-300">Kontakt</a>
            <button @click="loginModalOpen = true"
              class="glass-button bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 border border-orange-400/30 px-4 py-2 rounded-lg transition-all duration-300">
            Anmelden
            </button>
          </div>

          <!-- Mobile menu button -->
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>

        <!-- Mobile menu -->
        <div v-if="mobileMenuOpen" class="md:hidden py-4 border-t border-white/20">
          <div class="flex flex-col space-y-3">
            <a href="#home" class="text-white/80 hover:text-orange-400 transition-colors duration-300">Start</a>
            <a href="#services"
              class="text-white/80 hover:text-orange-400 transition-colors duration-300">Dienstleistungen</a>
            <a href="#prices" class="text-white/80 hover:text-orange-400 transition-colors duration-300">Preise</a>
            <a href="#contact" class="text-white/80 hover:text-orange-400 transition-colors duration-300">Kontakt</a>
            <Link :href="route('steam.redirect', { type: 'employee' })"
              class="glass-button bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 border border-blue-400/30 px-4 py-2 rounded-lg transition-all duration-300 text-center">
            Mitarbeiter
            </Link>
            <button @click="loginModalOpen = true"
              class="glass-button bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 border border-orange-400/30 px-4 py-2 rounded-lg transition-all duration-300 text-center">
            Anmelden
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Login Modal -->
    <div v-if="loginModalOpen" class="fixed inset-0 z-50 flex items-center justify-center">
      <!-- Modal Background -->
      <div @click="loginModalOpen = false" 
           class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
      
      <!-- Modal Content -->
      <div class="relative z-10 glass-card bg-white/10 dark:bg-black/10 backdrop-blur-lg border border-white/20 dark:border-white/10 rounded-2xl p-8 mx-4 max-w-md w-full">
        <!-- Close Button -->
        <button @click="loginModalOpen = false" 
                class="absolute top-4 right-4 text-white/60 hover:text-white transition-colors cursor-pointer">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>

        <!-- Modal Header -->
        <h3 class="text-2xl font-bold text-white mb-6 text-center">Anmelden</h3>
        <p class="text-white/80 text-center mb-8">Wählen Sie Ihr Portal:</p>

        <!-- Login Options -->
        <div class="space-y-4">
          <a :href="route('steam.redirect', { type: 'customer' })"
             class="glass-button bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 border border-orange-400/30 px-6 py-3 rounded-lg transition-all duration-300 block text-center font-semibold">
            Kundenportal
          </a>
          <a :href="route('steam.redirect', { type: 'employee' })"
             class="glass-button bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 border border-blue-400/30 px-6 py-3 rounded-lg transition-all duration-300 block text-center font-semibold">
            Mitarbeiterportal
          </a>
        </div>

        <!-- Info Text -->
        <p class="text-white/60 text-sm text-center mt-6">
          Melden Sie sich mit Ihrem Steam Account an
        </p>
      </div>
    </div>

    <!-- Hero Section -->
    <section id="home" class="relative py-20 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto text-center">
        <div
          class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-3xl p-8 md:p-12">
          <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
            <span class="text-gradient bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
              Gulfcoast Towing
            </span>
          </h1>
          <p class="text-xl md:text-2xl text-white/80 mb-8 max-w-3xl mx-auto">
            Ihr zuverlässiger Partner für Reparaturen & Abschleppdienste in Gulfcoast County. 24/7 Service,
            professionelle Ausrüstung und erfahrene Mitarbeiter.
          </p>
          <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <button @click="scrollTo('#contact')"
              class="glass-button bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 border border-orange-400/30 px-8 py-3 rounded-lg transition-all duration-300 text-lg font-semibold">
              Jetzt Kontaktieren
            </button>
            <button @click="scrollTo('#services')"
              class="glass-button bg-white/5 hover:bg-white/10 text-white border border-white/20 px-8 py-3 rounded-lg transition-all duration-300 text-lg font-semibold">
              Mehr Erfahren
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Unsere Dienstleistungen</h2>
          <p class="text-xl text-white/80 max-w-2xl mx-auto">
            Professionelle Dienstleistungen für alle Fahrzeugtypen in Gulfcoast und Umgebung.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="service in services" :key="service.title"
            class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-6 hover:bg-white/10 transition-all duration-300">
            <div
              class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center mb-4">
              <component :is="service.icon" class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-xl font-bold text-white mb-3">{{ service.title }}</h3>
            <p class="text-white/80 mb-4">{{ service.description }}</p>
            <div class="text-orange-400 font-semibold">{{ service.price }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Prices Section -->
    <section id="prices" class="py-20 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Preisliste</h2>
          <p class="text-xl text-white/80 max-w-2xl mx-auto">
            Transparente und faire Preise für alle unsere Dienstleistungen.
          </p>
        </div>

        <div
          class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-8">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="border-b border-white/20">
                  <th class="text-left text-white font-semibold py-3 px-4">Dienstleistung</th>
                  <th class="text-left text-white font-semibold py-3 px-4">Beschreibung</th>
                  <th class="text-right text-white font-semibold py-3 px-4">Preis</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="price in prices" :key="price.service"
                  class="border-b border-white/10 hover:bg-white/5 transition-colors duration-200">
                  <td class="text-white py-3 px-4 font-medium">{{ price.service }}</td>
                  <td class="text-white/80 py-3 px-4">{{ price.description }}</td>
                  <td class="text-orange-400 py-3 px-4 text-right font-semibold">{{ price.price }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Kontakt</h2>
          <p class="text-xl text-white/80 max-w-3xl mx-auto">
            Benötigen Sie Hilfe? Kontaktieren Sie uns jederzeit - wir sind 24/7 für Sie da.
          </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <div
            class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">Kontaktinformationen</h3>
            <div class="space-y-4">
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                    </path>
                  </svg>
                </div>
                <div>
                  <p class="text-white font-medium">Hotline</p>
                  <p class="text-orange-400">333</p>
                </div>
              </div>

              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-white font-medium">Hauptsitz</p>
                  <p class="text-white/80">TBD</p>
                </div>
              </div>

              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center">
                  <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                  </svg>
                </div>
                <div>
                  <p class="text-white font-medium">Öffnungszeiten</p>
                  <p class="text-white/80">24/7 Verfügbar</p>
                </div>
              </div>
            </div>
          </div>

          <div
            class="glass-card bg-white/5 dark:bg-black/5 backdrop-blur-lg border border-white/10 dark:border-white/5 rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">Für Kunden & Mitarbeiter</h3>
            <div class="space-y-4">
              <a :href="route('steam.redirect', { type: 'customer' })"
                class="glass-button bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 border border-orange-400/30 px-6 py-3 rounded-lg transition-all duration-300 block text-center">
              Kundenportal
              </a>
              <a :href="route('steam.redirect', { type: 'employee' })"
                class="glass-button bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 border border-white/20 px-6 py-3 rounded-lg transition-all duration-300 block text-center">
              Mitarbeiterportal
              </a>
              <p class="text-white/80 text-sm text-center mt-4">
                Melden Sie sich mit Ihrem Steam Account an, um auf die Portale zuzugreifen.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black/20 backdrop-blur-md border-t border-white/10 py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <p class="text-white/60">
            © 2025 Gulfcoast Towing. Alle Rechte vorbehalten.
          </p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

import { TruckIcon, WrenchIcon, ShieldExclamationIcon, CogIcon, QueueListIcon } from '@heroicons/vue/24/outline';

const mobileMenuOpen = ref(false);
const loginModalOpen = ref(false);

const services = [
  {
    title: 'Pannenhilfe',
    description: 'Schnelle Hilfe bei Unfällen und Pannen vor Ort',
    price: 'Kostenlos',
    icon: WrenchIcon
  },
  {
    title: 'Abschleppdienst',
    description: 'Abschleppen von Unfallfahrzeugen und Schadensbeseitigung',
    price: 'ab $1.500',
    icon: TruckIcon
  },
  {
    title: 'Technische Hilfeleistung & Bergung',
    description: 'Bergungen von Fahrzeugen und technischen Hilfeleistungen',
    price: 'ab $1.000',
    icon: ShieldExclamationIcon
  },
  {
    title: 'Fahrzeugtransport',
    description: 'Sicherer Transport von Fahrzeugen aller Art',
    price: 'ab $2.500',
    icon: TruckIcon
  },
  {
    title: 'TÜV & Inspektion',
    description: 'Regelmäßige Fahrzeugprüfungen und Wartungen',
    price: 'auf Anfrage, ab $10.000',
    icon: CogIcon
  },
  {
    title: 'Sonstiges',
    description: 'Individuelle Dienstleistungen nach Kundenwunsch & Aufträge im Gulfcoast Desert',
    price: 'auf Anfrage, ab $15.000',
    icon: QueueListIcon
  }
];

const prices = [
  {
    service: 'Pannenhilfe vor Ort',
    description: 'Unfallreparatur und Pannenhilfe direkt am Fahrzeug',
    price: 'Kostenlos'
  },
  {
    service: 'Abschleppdienst zur Werkstatt',
    description: 'Abschleppen von Fahrzeugen zur nächsten Werkstatt',
    price: '$1.500'
  },
  {
    service: 'Abschleppdienst zum Wunschort',
    description: 'Abschleppen von Fahrezugen zu einem Ort Ihrer Wahl',
    price: '$2.500 + $25/km'
  },
  {
    service: 'Unfallbergung',
    description: 'Bergung nach Verkehrsunfällen und Schadensbeseitigung',
    price: '$2.000 + $1.500 bei Kran-Einsatz'
  },
  {
    service: 'Notfallbetankung',
    description: 'Betankung von Fahrzeugen in Notfällen',
    price: '$1.500'
  },
  {
    service: 'Fahrzeugtransport',
    description: 'Transport von Fahrzeugen aller Art',
    price: '$2.500 + $25/km'
  },
  {
    service: 'TÜV & Inspektion',
    description: 'Regelmäßige Fahrzeugprüfungen und Wartungen',
    price: 'ab $10.000'
  },
  {
    service: 'Aufträge im Gulfcoast Desert',
    description: 'Spezielle Aufträge und Dienstleistungen im Desert-Gebiet',
    price: 'zzgl. $15.000'
  },
  {
    service: 'Individuelle Dienstleistungen',
    description: 'Anpassbare Dienstleistungen nach Kundenwunsch',
    price: 'auf Anfrage'
  }
];

const scrollTo = (selector: string) => {
  const element = document.querySelector(selector);
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' });
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

.text-gradient {
  background: linear-gradient(to right, #fb923c, #ea580c);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
</style>
