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
                <div class="mb-8 text-center">
                    <h2 class="mb-4 text-3xl font-bold text-white">Neue Anfrage</h2>
                    <p class="text-lg text-white/80">
                        Benötigen Sie einen Abschleppdienst? Füllen Sie das Formular aus und wir kommen so schnell wie möglich zu Ihnen.
                    </p>
                </div>

                <!-- Request Form -->
                <div class="mx-auto max-w-2xl">
                    <form @submit.prevent="submitRequest" class="space-y-6">
                        <!-- Service Type -->
                        <div>
                            <label class="mb-2 block font-medium text-white">Art des Service</label>
                            <select
                                v-model="form.serviceType"
                                class="w-full rounded-lg border border-white/20 bg-white/5 px-4 py-3 text-white focus:border-transparent focus:ring-2 focus:ring-orange-500 focus:outline-none"
                            >
                                <option value="">Bitte wählen Sie einen Service</option>
                                <option value="towing">Fahrzeugabschleppdienst</option>
                                <option value="roadside">Pannenhilfe vor Ort</option>
                                <option value="accident">Unfallbergung</option>
                                <option value="transport">Fahrzeugtransport</option>
                                <option value="heavy">Schwerlastbergung</option>
                            </select>
                        </div>

                        <!-- Location -->
                        <div>
                            <label class="mb-2 block font-medium text-white">Standort</label>
                            <input
                                v-model="form.location"
                                type="text"
                                placeholder="Beschreiben Sie Ihren aktuellen Standort..."
                                class="w-full rounded-lg border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-white/50 focus:border-transparent focus:ring-2 focus:ring-orange-500 focus:outline-none"
                            />
                        </div>

                        <!-- Vehicle Info -->
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block font-medium text-white">Fahrzeugmarke</label>
                                <input
                                    v-model="form.vehicleMake"
                                    type="text"
                                    placeholder="z.B. BMW, Mercedes, Audi..."
                                    class="w-full rounded-lg border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-white/50 focus:border-transparent focus:ring-2 focus:ring-orange-500 focus:outline-none"
                                />
                            </div>
                            <div>
                                <label class="mb-2 block font-medium text-white">Fahrzeugmodell</label>
                                <input
                                    v-model="form.vehicleModel"
                                    type="text"
                                    placeholder="z.B. 3er, E-Klasse, A4..."
                                    class="w-full rounded-lg border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-white/50 focus:border-transparent focus:ring-2 focus:ring-orange-500 focus:outline-none"
                                />
                            </div>
                        </div>

                        <!-- Problem Description -->
                        <div>
                            <label class="mb-2 block font-medium text-white">Problembeschreibung</label>
                            <textarea
                                v-model="form.description"
                                rows="4"
                                placeholder="Beschreiben Sie das Problem mit Ihrem Fahrzeug..."
                                class="w-full rounded-lg border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-white/50 focus:border-transparent focus:ring-2 focus:ring-orange-500 focus:outline-none"
                            ></textarea>
                        </div>

                        <!-- Contact Info -->
                        <div>
                            <label class="mb-2 block font-medium text-white">Telefonnummer (optional)</label>
                            <input
                                v-model="form.phone"
                                type="tel"
                                placeholder="Ihre Telefonnummer für Rückfragen..."
                                class="w-full rounded-lg border border-white/20 bg-white/5 px-4 py-3 text-white placeholder-white/50 focus:border-transparent focus:ring-2 focus:ring-orange-500 focus:outline-none"
                            />
                        </div>

                        <!-- Priority -->
                        <div>
                            <label class="mb-2 block font-medium text-white">Dringlichkeit</label>
                            <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
                                <label
                                    class="flex cursor-pointer items-center space-x-3 rounded-lg border border-white/20 bg-white/5 px-4 py-3 transition-colors hover:bg-white/10"
                                >
                                    <input v-model="form.priority" type="radio" value="low" class="text-orange-500 focus:ring-orange-500" />
                                    <span class="text-white">Niedrig</span>
                                </label>
                                <label
                                    class="flex cursor-pointer items-center space-x-3 rounded-lg border border-white/20 bg-white/5 px-4 py-3 transition-colors hover:bg-white/10"
                                >
                                    <input v-model="form.priority" type="radio" value="medium" class="text-orange-500 focus:ring-orange-500" />
                                    <span class="text-white">Normal</span>
                                </label>
                                <label
                                    class="flex cursor-pointer items-center space-x-3 rounded-lg border border-white/20 bg-white/5 px-4 py-3 transition-colors hover:bg-white/10"
                                >
                                    <input v-model="form.priority" type="radio" value="high" class="text-orange-500 focus:ring-orange-500" />
                                    <span class="text-white">Dringend</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 text-center">
                            <button
                                type="submit"
                                :disabled="!isFormValid"
                                :class="[
                                    isFormValid
                                        ? 'border-orange-400/30 bg-orange-500/30 text-orange-400 hover:bg-orange-500/40'
                                        : 'cursor-not-allowed border-gray-500/30 bg-gray-500/20 text-gray-500',
                                ]"
                                class="glass-button rounded-lg border px-8 py-3 text-lg font-semibold transition-all duration-300"
                            >
                                Anfrage Senden
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();

interface RequestForm {
    serviceType: string;
    location: string;
    vehicleMake: string;
    vehicleModel: string;
    description: string;
    phone: string;
    priority: string;
}

const form = ref<RequestForm>({
    serviceType: '',
    location: '',
    vehicleMake: '',
    vehicleModel: '',
    description: '',
    phone: '',
    priority: 'medium',
});

const isFormValid = computed(() => {
    return form.value.serviceType && form.value.location && form.value.vehicleMake && form.value.description;
});

const submitRequest = () => {
    if (isFormValid.value) {
        // Hier würde die API-Anfrage gesendet werden
        alert('Anfrage wurde erfolgreich gesendet! Wir melden uns in Kürze bei Ihnen.');

        // Form zurücksetzen
        form.value = {
            serviceType: '',
            location: '',
            vehicleMake: '',
            vehicleModel: '',
            description: '',
            phone: '',
            priority: 'medium',
        };
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

/* Custom select arrow */
select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Custom radio buttons */
input[type='radio'] {
    appearance: none;
    width: 1rem;
    height: 1rem;
    border: 2px solid rgba(251, 146, 60, 0.5);
    border-radius: 50%;
    background-color: transparent;
    position: relative;
}

input[type='radio']:checked {
    border-color: #f97316;
    background-color: #f97316;
}

input[type='radio']:checked::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 0.375rem;
    height: 0.375rem;
    background-color: white;
    border-radius: 50%;
}
</style>
