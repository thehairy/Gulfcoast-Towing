<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Navigation -->
        <nav class="glass-nav sticky top-0 z-50 border-b border-white/20 bg-white/10 backdrop-blur-md dark:border-white/10 dark:bg-black/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-3">
                        <h1 class="text-2xl font-bold text-white">Gulfcoast Towing</h1>
                    </div>
                    <div class="hidden items-center space-x-6 md:flex">
                        <a href="#home" class="text-white/80 transition-colors duration-300 hover:text-orange-400">Start</a>
                        <a href="#services" class="text-white/80 transition-colors duration-300 hover:text-orange-400">Dienstleistungen</a>
                        <a href="#prices" class="text-white/80 transition-colors duration-300 hover:text-orange-400">Preise</a>
                        <a href="#contact" class="text-white/80 transition-colors duration-300 hover:text-orange-400">Kontakt</a>
                        <button
                            @click="loginModalOpen = true"
                            class="glass-button rounded-lg border border-orange-400/30 bg-orange-500/20 px-4 py-2 text-orange-400 transition-all duration-300 hover:bg-orange-500/30"
                        >
                            Anmelden
                        </button>
                    </div>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white md:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile menu -->
                <div v-if="mobileMenuOpen" class="border-t border-white/20 py-4 md:hidden">
                    <div class="flex flex-col space-y-3">
                        <a href="#home" class="text-white/80 transition-colors duration-300 hover:text-orange-400">Start</a>
                        <a href="#services" class="text-white/80 transition-colors duration-300 hover:text-orange-400">Dienstleistungen</a>
                        <a href="#prices" class="text-white/80 transition-colors duration-300 hover:text-orange-400">Preise</a>
                        <a href="#contact" class="text-white/80 transition-colors duration-300 hover:text-orange-400">Kontakt</a>
                        <button
                            @click="loginModalOpen = true"
                            class="glass-button rounded-lg border border-orange-400/30 bg-orange-500/20 px-4 py-2 text-center text-orange-400 transition-all duration-300 hover:bg-orange-500/30"
                        >
                            Anmelden
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Login Modal -->
        <div v-if="loginModalOpen" class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- Modal Background -->
            <div @click="loginModalOpen = false" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>

            <!-- Modal Content -->
            <div
                class="glass-card relative z-10 mx-4 w-full max-w-md rounded-2xl border border-white/20 bg-white/10 p-8 backdrop-blur-lg dark:border-white/10 dark:bg-black/10"
            >
                <!-- Close Button -->
                <button
                    @click="loginModalOpen = false"
                    class="absolute top-4 right-4 cursor-pointer text-white/60 transition-colors hover:text-white"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Modal Header -->
                <h3 class="mb-6 text-center text-2xl font-bold text-white">Anmelden</h3>
                <p class="mb-8 text-center text-white/80">Wählen Sie Ihr Portal:</p>

                <!-- Login Options -->
                <div class="space-y-4">
                    <a
                        :href="route('steam.redirect', { type: 'customer' })"
                        @mouseenter="customerPortalHovered = true"
                        @mouseleave="customerPortalHovered = false"
                        @click.prevent
                        class="work-in-progress glass-button block rounded-lg border border-orange-400/30 bg-orange-500/20 px-6 py-3 text-center font-semibold text-orange-400 transition-all duration-300 hover:bg-orange-500/30"
                    >
                        {{ customerPortalHovered ? 'Work in Progress' : 'Kundenportal' }}
                    </a>
                    <a
                        :href="route('steam.redirect', { type: 'employee' })"
                        class="glass-button block rounded-lg border border-blue-400/30 bg-blue-500/20 px-6 py-3 text-center font-semibold text-blue-400 transition-all duration-300 hover:bg-blue-500/30"
                    >
                        Mitarbeiterportal
                    </a>
                </div>

                <!-- Info Text -->
                <p class="mt-6 text-center text-sm text-white/60">Melden Sie sich mit Ihrem Steam Account an</p>
            </div>
        </div>

        <!-- Hero Section -->
        <section id="home" class="relative px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl text-center">
                <div
                    class="glass-card rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur-lg md:p-12 dark:border-white/5 dark:bg-black/5"
                >
                    <h1 class="mb-6 text-4xl font-bold text-white md:text-6xl">
                        <span class="text-gradient bg-gradient-to-r from-orange-400 to-orange-600 bg-clip-text text-transparent">
                            Gulfcoast Towing
                        </span>
                    </h1>
                    <p class="mx-auto max-w-3xl text-xl text-white/80 md:text-2xl">
                        Ihr zuverlässiger Partner für Reparaturen & Co in Gulfcoast County.
                    </p>
                    <p class="mx-auto mb-4 max-w-3xl text-xl text-white/80 md:text-2xl">
                        24/7 Service, professionelle Ausrüstung und
                        erfahrene Mitarbeiter.
                    </p>
                    <p class="mx-auto mb-8 max-w-3xl text-xl text-white/80 md:text-2xl">Nicht alle Helden tragen Uniform. Manche fahren Abschlepper.</p>
                    <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
                        <button
                            @click="scrollTo('#contact')"
                            class="glass-button rounded-lg border border-orange-400/30 bg-orange-500/20 px-8 py-3 text-lg font-semibold text-orange-400 transition-all duration-300 hover:bg-orange-500/30"
                        >
                            Jetzt Kontaktieren
                        </button>
                        <button
                            @click="scrollTo('#services')"
                            class="glass-button rounded-lg border border-white/20 bg-white/5 px-8 py-3 text-lg font-semibold text-white transition-all duration-300 hover:bg-white/10"
                        >
                            Mehr Erfahren
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">Unsere Dienstleistungen</h2>
                    <p class="mx-auto max-w-2xl text-xl text-white/80">
                        Professionelle Dienstleistungen für alle Fahrzeugtypen in Gulfcoast und Umgebung.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="service in services"
                        :key="service.title"
                        class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg transition-all duration-300 hover:bg-white/10 dark:border-white/5 dark:bg-black/5"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-orange-400 to-orange-600">
                            <component :is="service.icon" class="h-6 w-6 text-white" />
                        </div>
                        <h3 class="mb-3 text-xl font-bold text-white">{{ service.title }}</h3>
                        <p class="mb-4 text-white/80">{{ service.description }}</p>
                        <div class="font-semibold text-orange-400">{{ service.price }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Prices Section -->
        <section id="prices" class="px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">Preisliste</h2>
                    <p class="mx-auto max-w-2xl text-xl text-white/80">Transparente und faire Preise für alle unsere Dienstleistungen.</p>
                </div>

                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-white/20">
                                    <th class="px-4 py-3 text-left font-semibold text-white">Dienstleistung</th>
                                    <th class="px-4 py-3 text-left font-semibold text-white">Beschreibung</th>
                                    <th class="px-4 py-3 text-right font-semibold text-white">Preis</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="price in prices"
                                    :key="price.service"
                                    class="border-b border-white/10 transition-colors duration-200 hover:bg-white/5"
                                >
                                    <td class="px-4 py-3 font-medium text-white">{{ price.service }}</td>
                                    <td class="px-4 py-3 text-white/80">{{ price.description }}</td>
                                    <td class="px-4 py-3 text-right font-semibold text-orange-400">{{ price.price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="mb-16 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">Kontakt</h2>
                    <p class="mx-auto max-w-3xl text-xl text-white/80">
                        Benötigen Sie Hilfe? Kontaktieren Sie uns jederzeit - wir sind 24/7 für Sie da.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                        <h3 class="mb-6 text-2xl font-bold text-white">Kontaktinformationen</h3>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-500/20">
                                    <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                        ></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-white">Hotline</p>
                                    <p class="text-orange-400">333</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-500/20">
                                    <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                        ></path>
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                        ></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-white">Hauptsitz</p>
                                    <p class="text-white/80">Northern Boulevard 17, 27070 West Pittston</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-500/20">
                                    <svg class="h-5 w-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-white">Geschäftsführung</p>
                                    <p class="text-white/80">Sam White</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                        <h3 class="mb-6 text-2xl font-bold text-white">Für Kunden & Mitarbeiter</h3>
                        <div class="space-y-4">
                            <a 
                                @mouseenter="customerPortalHovered = true"
                                @mouseleave="customerPortalHovered = false"
                                @click.prevent
                                :href="route('steam.redirect', { type: 'customer' })"
                                class="work-in-progress glass-button block rounded-lg border border-orange-400/30 bg-orange-500/20 px-6 py-3 text-center text-orange-400 transition-all duration-300 hover:bg-orange-500/30"
                            >
                                {{ customerPortalHovered ? 'Work in Progress' : 'Kundenportal' }}
                            </a>
                            <a
                                :href="route('steam.redirect', { type: 'employee' })"
                                class="glass-button block rounded-lg border border-white/20 bg-blue-500/20 px-6 py-3 text-center text-blue-400 transition-all duration-300 hover:bg-blue-500/30"
                            >
                                Mitarbeiterportal
                            </a>
                            <p class="mt-4 text-center text-sm text-white/80">
                                Melden Sie sich mit Ihrem Steam Account an, um auf die Portale zuzugreifen.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-white/10 bg-black/20 py-8 backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-white/60">© 2025 Gulfcoast Towing. Alle Rechte vorbehalten.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

import { CogIcon, QueueListIcon, ShieldExclamationIcon, TruckIcon, WrenchIcon } from '@heroicons/vue/24/outline';

const mobileMenuOpen = ref(false);
const loginModalOpen = ref(false);
const customerPortalHovered = ref(false);

const services = [
    {
        title: 'Pannenhilfe',
        description: 'Schnelle Hilfe bei Unfällen und Pannen vor Ort',
        price: 'Kostenlos',
        icon: WrenchIcon,
    },
    {
        title: 'Abschleppdienst',
        description: 'Abschleppen von Unfallfahrzeugen und Schadensbeseitigung',
        price: 'ab $1.500',
        icon: TruckIcon,
    },
    {
        title: 'Technische Hilfeleistung & Bergung',
        description: 'Bergungen von Fahrzeugen und technischen Hilfeleistungen',
        price: 'ab $1.000',
        icon: ShieldExclamationIcon,
    },
    {
        title: 'Fahrzeugtransport',
        description: 'Sicherer Transport von Fahrzeugen aller Art',
        price: 'ab $2.500',
        icon: TruckIcon,
    },
    {
        title: 'TÜV & Inspektion',
        description: 'Regelmäßige Fahrzeugprüfungen und Wartungen',
        price: 'auf Anfrage, ab $10.000',
        icon: CogIcon,
    },
    {
        title: 'Sonstiges',
        description: 'Individuelle Dienstleistungen nach Kundenwunsch & Aufträge im Gulfcoast Desert',
        price: 'auf Anfrage, ab $15.000',
        icon: QueueListIcon,
    },
];

const prices = [
    {
        service: 'Pannenhilfe vor Ort',
        description: 'Unfallreparatur und Pannenhilfe direkt am Fahrzeug',
        price: 'Kostenlos',
    },
    {
        service: 'Abschleppdienst zur Werkstatt',
        description: 'Abschleppen von Fahrzeugen zur nächsten Werkstatt',
        price: '$1.500',
    },
    {
        service: 'Abschleppdienst zum Wunschort',
        description: 'Abschleppen von Fahrezugen zu einem Ort Ihrer Wahl',
        price: '$2.500 + $25/km',
    },
    {
        service: 'Unfallbergung',
        description: 'Bergung nach Verkehrsunfällen und Schadensbeseitigung',
        price: '$2.000 + $1.500 bei Kran-Einsatz',
    },
    {
        service: 'Notfallbetankung',
        description: 'Betankung von Fahrzeugen in Notfällen',
        price: '$1.500',
    },
    {
        service: 'Fahrzeugtransport',
        description: 'Transport von Fahrzeugen aller Art',
        price: '$2.500 + $25/km',
    },
    {
        service: 'TÜV & Inspektion',
        description: 'Regelmäßige Fahrzeugprüfungen und Wartungen',
        price: 'ab $10.000',
    },
    {
        service: 'Aufträge im Gulfcoast Desert',
        description: 'Spezielle Aufträge und Dienstleistungen im Desert-Gebiet',
        price: 'zzgl. $15.000',
    },
    {
        service: 'Individuelle Dienstleistungen',
        description: 'Anpassbare Dienstleistungen nach Kundenwunsch',
        price: 'auf Anfrage',
    },
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

.glass-button.disabled {
    cursor: not-allowed;
    pointer-events: none;
    opacity: 0.6;
}

.glass-button.work-in-progress {
    cursor: not-allowed;
    opacity: 0.6;
    filter: grayscale(0.3);
}

.disabled {
    cursor: not-allowed;
    pointer-events: none;
    opacity: 0.6;
    filter: grayscale(0.3);
}

.text-gradient {
    background: linear-gradient(to right, #fb923c, #ea580c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
