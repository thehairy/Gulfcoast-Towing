<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Navigation -->
        <nav class="glass-nav sticky top-0 z-50 border-b border-white/20 bg-white/10 backdrop-blur-md dark:border-white/10 dark:bg-black/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 to-orange-600">
                            <Transition name="icon-rotate" mode="out-in">
                                <svg v-if="activeTab === 'dashboard'" key="dashboard" class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                                    ></path>
                                </svg>
                                <svg v-else key="regulations" class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                    ></path>
                                </svg>
                            </Transition>
                        </div>
                        <h1 class="text-2xl font-bold text-white">
                            <Transition name="slide-fade" mode="out-in">
                                <span v-if="activeTab === 'dashboard'" key="dashboard">GCT - Dashboard</span>
                                <span v-else key="regulations">GCT - Dienstvorschriften</span>
                            </Transition>
                        </h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="font-medium text-white">{{ employee.first_name }} {{ employee.last_name }}</div>
                            <div class="text-sm text-white/60">{{ employee.rank.name }}</div>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600">
                            <span class="text-sm font-bold text-white">{{ employee.first_name.charAt(0) }}{{ employee.last_name.charAt(0) }}</span>
                        </div>
                        <Link
                            :href="route('employee.logout')"
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
                <div class="glass-card relative rounded-2xl border border-white/10 bg-white/5 p-2 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                    <!-- Animated background indicator -->
                    <div 
                        class="absolute left-2 top-2 bottom-2 rounded-lg bg-orange-500/30 transition-all duration-500 ease-out"
                        :class="activeTab === 'dashboard' ? 'w-[calc(50%-4px)]' : 'w-[calc(50%-4px)] translate-x-[calc(100%+4px)]'"
                    ></div>
                    
                    <div class="relative grid grid-cols-1 gap-2 md:grid-cols-2">
                        <button
                            @click="activeTab = 'dashboard'"
                            :class="[
                                activeTab === 'dashboard'
                                    ? 'text-orange-400'
                                    : 'text-white/80 hover:text-white',
                            ]"
                            class="rounded-lg px-4 py-3 text-center font-medium transition-all duration-300 relative z-10"
                        >
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                                </svg>
                                <span>Dashboard</span>
                            </div>
                        </button>
                        <button
                            @click="activeTab = 'regulations'"
                            :class="[
                                activeTab === 'regulations'
                                    ? 'text-orange-400'
                                    : 'text-white/80 hover:text-white',
                            ]"
                            class="rounded-lg px-4 py-3 text-center font-medium transition-all duration-300 relative z-10"
                        >
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>Dienstvorschriften</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Wrapper with Transitions -->
            <div class="relative min-h-[600px]">
                <!-- Dashboard Content -->
                <Transition 
                    name="tab-slide"
                    enter-active-class="transition-all duration-500 ease-out"
                    leave-active-class="transition-all duration-500 ease-out"
                    enter-from-class="opacity-0 transform translate-x-8"
                    enter-to-class="opacity-100 transform translate-x-0"
                    leave-from-class="opacity-100 transform translate-x-0"
                    leave-to-class="opacity-0 transform -translate-x-8"
                >
                    <div v-if="activeTab === 'dashboard'" key="dashboard" class="absolute inset-0">
                        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                            <!-- Statistics Cards -->
                            <div class="space-y-6 lg:col-span-2">
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                    <div
                                        class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-105"
                                    >
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-white/80">Heutige Aufträge</p>
                                                <p class="text-2xl font-bold text-white">{{ stats.todayOrders }}</p>
                                            </div>
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500/20">
                                                <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-105"
                                    >
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-white/80">Aktive Aufträge</p>
                                                <p class="text-2xl font-bold text-white">{{ stats.activeOrders }}</p>
                                            </div>
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-500/20">
                                                <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-105"
                                    >
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm text-white/80">Einnahmen Heute</p>
                                                <p class="text-2xl font-bold text-white">${{ stats.todayEarnings }}</p>
                                            </div>
                                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/20">
                                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"
                                                    ></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Recent Orders -->
                                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                                    <h3 class="mb-4 text-xl font-bold text-white">Neueste Aufträge</h3>
                                    <div class="space-y-4">
                                        <div v-for="order in recentOrders" :key="order.id" class="flex items-center justify-between rounded-lg bg-white/5 p-4 transition-all duration-300 hover:bg-white/10">
                                            <div class="flex items-center space-x-4">
                                                <div :class="getStatusColor(order.status)" class="h-3 w-3 rounded-full"></div>
                                                <div>
                                                    <p class="font-medium text-white">{{ order.customerName }}</p>
                                                    <p class="text-sm text-white/80">{{ order.location }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="font-medium text-white">${{ order.amount }}</p>
                                                <p class="text-sm text-white/80">{{ order.time }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="space-y-6">
                                <!-- Quick Actions -->
                                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                                    <h3 class="mb-4 text-xl font-bold text-white">Schnellaktionen</h3>
                                    <div class="space-y-3">
                                        <button
                                            class="glass-button w-full rounded-lg border border-orange-400/30 bg-orange-500/20 px-4 py-3 text-left text-orange-400 transition-all duration-300 hover:bg-orange-500/30 hover:scale-105"
                                        >
                                            Neuen Auftrag erstellen
                                        </button>
                                        <button
                                            class="glass-button w-full rounded-lg border border-green-400/30 bg-green-500/20 px-4 py-3 text-left text-green-400 transition-all duration-300 hover:bg-green-500/30 hover:scale-105"
                                        >
                                            Fahrzeug Status ändern
                                        </button>
                                        <button
                                            class="glass-button w-full rounded-lg border border-blue-400/30 bg-blue-500/20 px-4 py-3 text-left text-blue-400 transition-all duration-300 hover:bg-blue-500/30 hover:scale-105"
                                        >
                                            Schichtbericht
                                        </button>
                                    </div>
                                </div>

                                <!-- Available Vehicles -->
                                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                                    <h3 class="mb-4 text-xl font-bold text-white">Verfügbare Fahrzeuge</h3>
                                    <div class="space-y-3">
                                        <div
                                            v-for="vehicle in availableVehicles"
                                            :key="vehicle.id"
                                            class="flex items-center justify-between rounded-lg bg-white/5 p-3 transition-all duration-300 hover:bg-white/10"
                                        >
                                            <div>
                                                <p class="font-medium text-white">{{ vehicle.name }}</p>
                                                <p class="text-sm text-white/80">{{ vehicle.type }}</p>
                                            </div>
                                            <div
                                                :class="vehicle.available ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'"
                                                class="rounded-full px-2 py-1 text-xs"
                                            >
                                                {{ vehicle.available ? 'Verfügbar' : 'Im Einsatz' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </Transition>

                <!-- Service Regulations Content -->
                <Transition 
                    name="tab-slide"
                    enter-active-class="transition-all duration-500 ease-out"
                    leave-active-class="transition-all duration-500 ease-out"
                    enter-from-class="opacity-0 transform translate-x-8"
                    enter-to-class="opacity-100 transform translate-x-0"
                    leave-from-class="opacity-100 transform translate-x-0"
                    leave-to-class="opacity-0 transform -translate-x-8"
                >
                    <div v-if="activeTab === 'regulations'" key="regulations" class="absolute inset-0">
                        <div class="grid grid-cols-1 gap-8">
                            <!-- Introduction Section -->
                            <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-[1.02]">
                                <div class="mb-6 flex items-center space-x-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500/20">
                                        <svg class="h-6 w-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-3xl font-bold text-white">Gulfcoast Towing - Dienstvorschriften</h2>
                                </div>
                                <p class="text-lg text-white/80 leading-relaxed">
                                    Diese Dienstvorschriften dienen als Leitfaden für alle Mitarbeiter der Gulfcoast Towing. 
                                    Bitte lesen Sie diese sorgfältig durch und befolgen Sie die Anweisungen, um einen 
                                    professionellen und sicheren Service zu gewährleisten.
                                </p>
                            </div>

                            <!-- Regulations Sections -->
                            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                                <!-- General Conduct -->
                                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-105">
                                    <div class="mb-4 flex items-center space-x-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/20">
                                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white">Allgemeines Verhalten</h3>
                                    </div>
                                    <ul class="space-y-3 text-white/80">
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-orange-400 flex-shrink-0"></span>
                                            <span>Höflicher und respektvoller Umgang mit Kunden und Kollegen</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-orange-400 flex-shrink-0"></span>
                                            <span>Pünktliches Erscheinen zum Dienst</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-orange-400 flex-shrink-0"></span>
                                            <span>Professionelle Arbeitskleidung tragen</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-orange-400 flex-shrink-0"></span>
                                            <span>Keine privaten Angelegenheiten während der Arbeitszeit</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Safety Regulations -->
                                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-105">
                                    <div class="mb-4 flex items-center space-x-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-500/20">
                                            <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white">Sicherheitsbestimmungen</h3>
                                    </div>
                                    <ul class="space-y-3 text-white/80">
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                                            <span>Fahrzeugkontrolle vor jedem Einsatz durchführen</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                                            <span>Verkehrsregeln und Geschwindigkeitsbegrenzungen beachten</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                                            <span>Sicherheitswesten bei Straßeneinsätzen tragen</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-red-400 flex-shrink-0"></span>
                                            <span>Unfälle sofort der Leitstelle melden</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Customer Service -->
                                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-105">
                                    <div class="mb-4 flex items-center space-x-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-500/20">
                                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white">Kundenservice</h3>
                                    </div>
                                    <ul class="space-y-3 text-white/80">
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-green-400 flex-shrink-0"></span>
                                            <span>Freundliche Begrüßung und Vorstellung</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-green-400 flex-shrink-0"></span>
                                            <span>Kosten transparent und vor Beginn kommunizieren</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-green-400 flex-shrink-0"></span>
                                            <span>Fahrzeug sorgfältig und schonend behandeln</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-green-400 flex-shrink-0"></span>
                                            <span>Bei Problemen Vorgesetzten kontaktieren</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Communication -->
                                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-105">
                                    <div class="mb-4 flex items-center space-x-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-500/20">
                                            <svg class="h-5 w-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-white">Kommunikation</h3>
                                    </div>
                                    <ul class="space-y-3 text-white/80">
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-purple-400 flex-shrink-0"></span>
                                            <span>Funk immer griffbereit halten</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-purple-400 flex-shrink-0"></span>
                                            <span>Status-Updates regelmäßig an Leitstelle</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-purple-400 flex-shrink-0"></span>
                                            <span>Klare und präzise Kommunikation</span>
                                        </li>
                                        <li class="flex items-start space-x-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-purple-400 flex-shrink-0"></span>
                                            <span>Notfälle sofort melden</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Emergency Procedures -->
                            <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-[1.02]">
                                <div class="mb-6 flex items-center space-x-3">
                                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-500/20">
                                        <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <h2 class="text-2xl font-bold text-white">Notfallverfahren</h2>
                                </div>
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <h4 class="mb-3 text-lg font-semibold text-white">Bei Unfällen:</h4>
                                        <ol class="space-y-2 text-white/80">
                                            <li class="flex items-start space-x-2">
                                                <span class="mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">1</span>
                                                <span>Sofortiger Stopp aller Aktivitäten</span>
                                            </li>
                                            <li class="flex items-start space-x-2">
                                                <span class="mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">2</span>
                                                <span>Erste Hilfe leisten</span>
                                            </li>
                                            <li class="flex items-start space-x-2">
                                                <span class="mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white">3</span>
                                                <span>Leitstelle informieren</span>
                                            </li>
                                        </ol>
                                    </div>
                                    <div>
                                        <h4 class="mb-3 text-lg font-semibold text-white">Bei Fahrzeugproblemen:</h4>
                                        <ol class="space-y-2 text-white/80">
                                            <li class="flex items-start space-x-2">
                                                <span class="mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-orange-500 text-xs font-bold text-white">1</span>
                                                <span>Fahrzeug sicher abstellen</span>
                                            </li>
                                            <li class="flex items-start space-x-2">
                                                <span class="mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-orange-500 text-xs font-bold text-white">2</span>
                                                <span>Leitstelle kontaktieren</span>
                                            </li>
                                            <li class="flex items-start space-x-2">
                                                <span class="mt-1 flex h-5 w-5 items-center justify-center rounded-full bg-orange-500 text-xs font-bold text-white">3</span>
                                                <span>Auf Anweisungen warten</span>
                                            </li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-[1.02]">
                                <div class="mb-4 flex items-center space-x-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500/20">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-white">Wichtige Kontakte</h3>
                                </div>
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div class="rounded-lg bg-white/5 p-4 transition-all duration-300 hover:bg-white/10">
                                        <div class="text-sm text-white/60">Leitstelle</div>
                                        <div class="font-medium text-white">Short: 333 | Long: 33.3</div>
                                    </div>
                                    <div class="rounded-lg bg-white/5 p-4 transition-all duration-300 hover:bg-white/10">
                                        <div class="text-sm text-white/60">Geschäftsführung</div>
                                        <div class="font-medium text-white">0659177288</div>
                                    </div>
                                    <div class="rounded-lg bg-white/5 p-4 transition-all duration-300 hover:bg-white/10">
                                        <div class="text-sm text-white/60">Notfall</div>
                                        <div class="font-medium text-white"><span style="color: rgba(0, 50, 255, 0.8); font-weight: bold;">911 (GCSD)</span> | <span style="color: rgba(255, 30, 0, 0.8); font-weight: bold;">912 (GCFD)</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { ref, Transition } from 'vue';

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

// Active tab state
const activeTab = ref<'dashboard' | 'regulations'>('dashboard');

// Mock data - später durch echte API-Calls ersetzen
const stats = ref({
    todayOrders: 12,
    activeOrders: 3,
    todayEarnings: 1850,
});

const recentOrders = ref([
    {
        id: 1,
        customerName: 'Max Mustermann',
        location: 'Downtown LS',
        amount: 150,
        time: '14:30',
        status: 'completed',
    },
    {
        id: 2,
        customerName: 'Anna Schmidt',
        location: 'Sandy Shores',
        amount: 220,
        time: '13:15',
        status: 'active',
    },
    {
        id: 3,
        customerName: 'Tom Weber',
        location: 'Paleto Bay',
        amount: 180,
        time: '12:45',
        status: 'pending',
    },
]);

const availableVehicles = ref([
    {
        id: 1,
        name: 'Abschleppwagen #1',
        type: 'Standard',
        available: true,
    },
    {
        id: 2,
        name: 'Abschleppwagen #2',
        type: 'Schwerlast',
        available: false,
    },
    {
        id: 3,
        name: 'Service Van #1',
        type: 'Pannenhilfe',
        available: true,
    },
]);

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

/* Tab slide transition */
.tab-slide-enter-active, 
.tab-slide-leave-active {
    transition: all 0.5s ease-out;
}

.tab-slide-enter-from {
    opacity: 0;
    transform: translateX(2rem);
}

.tab-slide-leave-to {
    opacity: 0;
    transform: translateX(-2rem);
}

/* Icon rotation transition */
.icon-rotate-enter-active,
.icon-rotate-leave-active {
    transition: all 0.3s ease-out;
}

.icon-rotate-enter-from {
    opacity: 0;
    transform: rotate(90deg) scale(0.8);
}

.icon-rotate-leave-to {
    opacity: 0;
    transform: rotate(-90deg) scale(0.8);
}

/* Slide fade transition for title */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s ease-out;
}

.slide-fade-enter-from {
    opacity: 0;
    transform: translateY(-0.5rem);
}

.slide-fade-leave-to {
    opacity: 0;
    transform: translateY(0.5rem);
}

/* Enhanced hover effects */
.glass-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

/* Smooth background indicator animation */
.glass-card > div:first-child {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
