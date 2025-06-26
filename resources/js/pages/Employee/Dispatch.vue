<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Navigation -->
        <nav class="glass-nav sticky top-0 z-50 border-b border-white/20 bg-white/10 backdrop-blur-md dark:border-white/10 dark:bg-black/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"
                                ></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white">GCT - Leitstelle</h1>
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
                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-2 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                        <Link
                            :href="route('employee.dashboard')"
                            :class="[
                                page.component === 'Employee/Dashboard'
                                    ? 'bg-orange-500/30 text-orange-400'
                                    : 'text-white/80 hover:bg-white/10 hover:text-white',
                            ]"
                            class="rounded-lg px-4 py-3 text-center font-medium transition-all duration-300"
                        >
                            Dashboard
                        </Link>
                        <Link
                            :href="route('employee.dispatch')"
                            :class="[
                                page.component === 'Employee/Dispatch'
                                    ? 'bg-blue-500/30 text-blue-400'
                                    : 'text-white/80 hover:bg-white/10 hover:text-white',
                            ]"
                            class="rounded-lg px-4 py-3 text-center font-medium transition-all duration-300"
                        >
                            Leitstelle
                        </Link>
                    </div>
                </div>
            </div>

            <!-- Status und Kontrollen -->
            <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Dienststatus -->
                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                    <h3 class="mb-4 text-xl font-bold text-white">Mein Status</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-white/80">Dienststatus:</span>
                            <select
                                v-model="currentDutyStatus"
                                @change="updateDutyStatus"
                                class="rounded-lg border border-white/20 bg-slate-800/90 px-3 py-2 text-white transition-all duration-300 focus:border-blue-400/50 focus:bg-slate-700/90"
                            >
                                <option value="off_duty" class="bg-slate-800 text-white">Nicht im Dienst</option>
                                <option value="available" class="bg-slate-800 text-white">Verfügbar</option>
                                <option value="in_service" class="bg-slate-800 text-white">Im Einsatz</option>
                                <option value="busy" class="bg-slate-800 text-white">Beschäftigt</option>
                                <option value="break" class="bg-slate-800 text-white">Pause</option>
                                <option value="out_of_service" class="bg-slate-800 text-white">Außer Dienst</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-white/80">Leitstelle:</span>
                            <button
                                @click="toggleDispatcher"
                                :class="[employee.is_dispatcher ? 'bg-blue-500/30 text-blue-400' : 'bg-gray-500/30 text-gray-400']"
                                class="cursor-pointer rounded-lg border border-current px-4 py-2 transition-all duration-300"
                            >
                                {{ employee.is_dispatcher ? 'Aktiv' : 'Inaktiv' }}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Aktuelle Leitstellen -->
                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                    <h3 class="mb-4 text-xl font-bold text-white">Aktive Leitstellen</h3>
                    <div class="space-y-2">
                        <div v-if="dispatchers.length === 0" class="py-4 text-center text-white/60">Keine aktiven Leitstellen</div>
                        <div v-for="dispatcher in dispatchers" :key="dispatcher.id" class="flex items-center space-x-3 rounded-lg bg-blue-500/20 p-3">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-500">
                                <span class="text-sm font-bold text-white">{{
                                    dispatcher.name
                                        .split(' ')
                                        .map((n) => n[0])
                                        .join('')
                                }}</span>
                            </div>
                            <div>
                                <div class="font-medium text-white">{{ dispatcher.name }}</div>
                                <div class="text-sm text-blue-400">{{ dispatcher.rank }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiken -->
                <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                    <h3 class="mb-4 text-xl font-bold text-white">Übersicht</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-white/80">Fahrzeuge gesamt:</span>
                            <span class="font-bold text-white">{{ vehicles.length }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-white/80">Verfügbar:</span>
                            <span class="font-bold text-green-400">{{ availableVehicles }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-white/80">Im Einsatz:</span>
                            <span class="font-bold text-blue-400">{{ inServiceVehicles }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-white/80">Zugewiesen:</span>
                            <span class="font-bold text-orange-400">{{ assignedVehicles }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fahrzeugübersicht -->
            <div class="glass-card mb-8 rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">Aktive Fahrzeuge</h3>
                    <button
                        v-if="employee.is_dispatcher && employee.duty_status !== 'off_duty'"
                        @click="openAddVehicleModal"
                        class="cursor-pointer rounded-lg border border-green-400/30 bg-green-500/20 px-4 py-2 text-sm text-green-400 transition-all duration-300 hover:bg-green-500/30"
                    >
                        + Fahrzeug hinzufügen
                    </button>
                </div>

                <div v-if="activeVehicles.length === 0" class="py-8 text-center text-white/60">
                    <div class="mb-4 text-6xl">🚗</div>
                    <p>Keine aktiven Fahrzeuge</p>
                    <p class="mt-2 text-sm" v-if="employee.is_dispatcher">Fügen Sie ein Fahrzeug hinzu, um es einem Mitarbeiter zuzuweisen</p>
                </div>

                <div v-else class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-3">
                    <div v-for="vehicle in activeVehicles" :key="vehicle.id" class="rounded-lg border border-white/10 bg-white/5 p-4">
                        <div class="mb-3 flex items-start justify-between">
                            <div>
                                <h4 class="font-semibold text-white">{{ vehicle.name }}</h4>
                                <p class="text-sm text-white/60">{{ vehicle.license_plate }}</p>
                            </div>
                            <span
                                :class="getDutyStatusClass(vehicle.current_driver.duty_status)"
                                class="rounded-full border border-current/30 bg-current/20 px-2 py-1 text-xs font-medium"
                            >
                                {{ getDutyStatusText(vehicle.current_driver.duty_status) }}
                            </span>
                        </div>

                        <div class="mb-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-white/80">Typ:</span>
                                <span class="text-white">{{ vehicle.type }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-white/80">Fahrer:</span>
                                <span class="text-white">{{ vehicle.current_driver.name }}</span>
                            </div>
                        </div>

                        <div v-if="employee.is_dispatcher && employee.duty_status !== 'off_duty'" class="flex space-x-2">
                            <button
                                @click="returnVehicle(vehicle)"
                                class="flex-1 cursor-pointer rounded-lg border border-red-400/30 bg-red-500/20 px-3 py-2 text-sm text-red-400 transition-all duration-300 hover:bg-red-500/30"
                            >
                                Zurückgeben
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mitarbeiterübersicht -->
            <div class="glass-card rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-lg dark:border-white/5 dark:bg-black/5">
                <h3 class="mb-6 text-xl font-bold text-white">Mitarbeiter im Dienst</h3>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <div v-for="emp in employees" :key="emp.id" class="rounded-lg border border-white/10 bg-white/5 p-4">
                        <div class="mb-3 flex items-center space-x-3">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-green-400 to-green-600">
                                <span class="text-sm font-bold text-white">{{
                                    emp.name
                                        .split(' ')
                                        .map((n) => n[0])
                                        .join('')
                                }}</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">
                                    {{ emp.name }}
                                    <p v-if="emp.is_dispatcher" class="inline text-blue-400">(Leitstelle)</p>
                                </h4>
                                <p class="text-sm text-white/60">{{ emp.rank }}</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-white/80">Status:</span>
                                <span :class="getDutyStatusClass(emp.duty_status)">
                                    {{ getDutyStatusText(emp.duty_status) }}
                                </span>
                            </div>
                            <div v-if="emp.current_vehicle" class="flex justify-between text-sm">
                                <span class="text-white/80">Fahrzeug:</span>
                                <span class="text-white">{{ emp.current_vehicle.name }}</span>
                            </div>
                            <div v-if="emp.current_location" class="flex justify-between text-sm">
                                <span class="text-white/80">Standort:</span>
                                <span class="text-white">{{ emp.current_location }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Assignment Modal -->
        <div v-if="showAssignModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div
                class="glass-card mx-4 w-full max-w-md rounded-2xl border border-white/20 bg-white/10 p-6 backdrop-blur-lg dark:border-white/10 dark:bg-black/10"
            >
                <h3 class="mb-4 text-xl font-bold text-white">Fahrzeug zuweisen</h3>
                <form @submit.prevent="assignVehicle">
                    <div class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm text-white/80">Fahrzeug:</label>
                            <div class="font-medium text-white">{{ selectedVehicle?.name }}</div>
                            <div class="text-sm text-white/60">{{ selectedVehicle?.license_plate }}</div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm text-white/80">Mitarbeiter:</label>
                            <select
                                v-model="assignForm.employee_id"
                                required
                                class="w-full rounded-lg border border-white/20 bg-slate-800/90 px-3 py-2 text-white transition-all duration-300 focus:border-blue-400/50 focus:bg-slate-700/90"
                            >
                                <option value="" class="bg-slate-800 text-white">Mitarbeiter auswählen</option>
                                <option v-for="emp in employees" :key="emp.id" :value="emp.id" class="bg-slate-800 text-white">
                                    {{ emp.name }} ({{ emp.rank }})
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm text-white/80">Notizen (optional):</label>
                            <textarea
                                v-model="assignForm.notes"
                                class="w-full rounded-lg border border-white/20 bg-white/10 px-3 py-2 text-white"
                                rows="3"
                                placeholder="Zusätzliche Informationen..."
                            ></textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <button
                            type="button"
                            @click="closeAssignModal"
                            class="flex-1 cursor-pointer rounded-lg border border-gray-400/30 bg-gray-500/20 px-4 py-2 text-gray-400 transition-all duration-300 hover:bg-gray-500/30"
                        >
                            Abbrechen
                        </button>
                        <button
                            type="submit"
                            class="flex-1 cursor-pointer rounded-lg border border-blue-400/30 bg-blue-500/20 px-4 py-2 text-blue-400 transition-all duration-300 hover:bg-blue-500/30"
                        >
                            Zuweisen
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Add Vehicle Modal -->
        <div v-if="showAddVehicleModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div
                class="glass-card mx-4 w-full max-w-md rounded-2xl border border-white/20 bg-white/10 p-6 backdrop-blur-lg dark:border-white/10 dark:bg-black/10"
            >
                <h3 class="mb-4 text-xl font-bold text-white">Fahrzeug erstellen</h3>
                <form @submit.prevent="addVehicle">
                    <div class="space-y-4">
                        <div>
                            <label class="mb-2 block text-sm text-white/80">Fahrzeugtyp:</label>
                            <select
                                v-model="addVehicleForm.vehicle_type"
                                required
                                class="w-full rounded-lg border border-white/20 bg-slate-800/90 px-3 py-2 text-white transition-all duration-300 focus:border-blue-400/50 focus:bg-slate-700/90"
                            >
                                <option value="" class="bg-slate-800 text-white">Fahrzeugtyp auswählen</option>
                                <option value="pannenservice" class="bg-slate-800 text-white">🔧 Pannenservice</option>
                                <option value="abschlepper_pkw" class="bg-slate-800 text-white">🚗 Abschleppwagen (PKW)</option>
                                <option value="abschlepper_lkw" class="bg-slate-800 text-white">🚛 Abschleppwagen (LKW)</option>
                                <option value="kranwagen" class="bg-slate-800 text-white">🏗️ Kranwagen</option>
                                <option value="helikopter" class="bg-slate-800 text-white">🚁 Helikopter</option>
                            </select>
                        </div>

                        <div v-if="addVehicleForm.vehicle_type" class="rounded-lg border border-blue-400/30 bg-blue-500/10 p-3">
                            <div class="mb-1 text-sm font-medium text-blue-400">Fahrzeug wird erstellt als:</div>
                            <div class="font-bold text-white">{{ getVehicleName(addVehicleForm.vehicle_type) }}</div>
                            <div class="text-sm text-white/60">{{ getVehicleLicensePlate(addVehicleForm.vehicle_type) }}</div>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm text-white/80">Mitarbeiter zuweisen:</label>
                            <select
                                v-model="addVehicleForm.employee_id"
                                required
                                class="w-full rounded-lg border border-white/20 bg-slate-800/90 px-3 py-2 text-white transition-all duration-300 focus:border-blue-400/50 focus:bg-slate-700/90"
                            >
                                <option value="" class="bg-slate-800 text-white">Mitarbeiter auswählen</option>
                                <option v-for="emp in availableEmployees" :key="emp.id" :value="emp.id" class="bg-slate-800 text-white">
                                    {{ emp.name }} ({{ emp.rank }})
                                </option>
                            </select>
                        </div>

                        <div class="rounded-lg border border-yellow-400/30 bg-yellow-500/10 p-3">
                            <div class="mb-1 text-xs font-medium text-yellow-400">ℹ️ Information</div>
                            <div class="text-xs text-white/80">
                                Das Fahrzeug wird automatisch in der Datenbank erstellt und nummeriert. Bei Rückgabe oder Dienstende wird es
                                automatisch entfernt.
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <button
                            type="button"
                            @click="closeAddVehicleModal"
                            class="flex-1 cursor-pointer rounded-lg border border-gray-400/30 bg-gray-500/20 px-4 py-2 text-gray-400 transition-all duration-300 hover:bg-gray-500/30"
                        >
                            Abbrechen
                        </button>
                        <button
                            type="submit"
                            class="flex-1 cursor-pointer rounded-lg border border-green-400/30 bg-green-500/20 px-4 py-2 text-green-400 transition-all duration-300 hover:bg-green-500/30"
                        >
                            Fahrzeug erstellen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="js">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    employee: Object,
    vehicles: Array,
    employees: Array,
    dispatchers: Array,
});

const page = usePage();
const currentDutyStatus = ref(props.employee.duty_status);
const showAssignModal = ref(false);
const showAddVehicleModal = ref(false);
const selectedVehicle = ref(null);
const assignForm = ref({
    vehicle_id: null,
    employee_id: '',
    notes: '',
});
const addVehicleForm = ref({
    vehicle_type: '',
    employee_id: '',
});

// Fahrzeug-Definitionen für GCT
const vehicleDefinitions = {
    pannenservice: {
        name: 'GCT Pannenservice',
        type: 'Pannenservice',
        prefix: 'PS',
    },
    abschlepper_pkw: {
        name: 'GCT Abschleppwagen PKW',
        type: 'Abschleppwagen',
        prefix: 'AS',
    },
    abschlepper_lkw: {
        name: 'GCT Abschleppwagen LKW',
        type: 'Schwerlastabschlepper',
        prefix: 'SA',
    },
    kranwagen: {
        name: 'GCT Kranwagen',
        type: 'Kranwagen',
        prefix: 'KW',
    },
    helikopter: {
        name: 'GCT Helikopter',
        type: 'Helikopter',
        prefix: 'H',
    },
};

// Computed properties für Statistiken
const activeVehicles = computed(() => props.vehicles.filter((v) => v.current_driver && v.current_driver.duty_status !== 'off_duty'));

const availableEmployees = computed(() => props.employees.filter((emp) => emp.duty_status !== 'off_duty' && !emp.current_vehicle));

const availableVehicles = computed(() => props.vehicles.filter((v) => !v.current_driver).length);

const inServiceVehicles = computed(() => props.vehicles.filter((v) => v.current_driver && v.current_driver.duty_status === 'in_service').length);

const assignedVehicles = computed(() => props.vehicles.filter((v) => v.current_driver).length);

/*// Status-Funktionen
const getStatusBadgeClass = (status) => {
    const classes = {
        available: 'bg-green-500/20 text-green-400',
        in_service: 'bg-blue-500/20 text-blue-400',
        maintenance: 'bg-yellow-500/20 text-yellow-400',
        offline: 'bg-red-500/20 text-red-400',
    };
    return classes[status] || 'bg-gray-500/20 text-gray-400';
};

const getStatusText = (status) => {
    const texts = {
        available: 'Verfügbar',
        in_service: 'Im Einsatz',
        maintenance: 'Wartung',
        offline: 'Offline',
    };
    return texts[status] || status;
};*/

const getDutyStatusClass = (status) => {
    const classes = {
        available: 'text-green-400',
        in_service: 'text-blue-400',
        busy: 'text-orange-400',
        break: 'text-yellow-400',
        out_of_service: 'text-purple-400',
        off_duty: 'text-gray-400',
    };
    return classes[status] || 'text-gray-400';
};

const getDutyStatusText = (status) => {
    const texts = {
        available: 'Verfügbar',
        in_service: 'Im Einsatz',
        busy: 'Beschäftigt',
        break: 'Pause',
        out_of_service: 'Außer Dienst',
        off_duty: 'Nicht im Dienst',
    };

    return texts[status] || status;
};

// Fahrzeug-Hilfsfunktionen
const getVehicleName = (vehicleType) => {
    if (!vehicleType || !vehicleDefinitions[vehicleType]) return '';

    const definition = vehicleDefinitions[vehicleType];
    const existingVehicles = props.vehicles.filter((v) => v.type === definition.type);
    const nextNumber = existingVehicles.length + 1;

    return `${definition.name} ${nextNumber}`;
};

const getVehicleLicensePlate = (vehicleType) => {
    if (!vehicleType || !vehicleDefinitions[vehicleType]) return '';

    const definition = vehicleDefinitions[vehicleType];
    const existingVehicles = props.vehicles.filter((v) => v.type === definition.type);
    const nextNumber = existingVehicles.length + 1;

    return `GCT-${definition.prefix}${nextNumber.toString().padStart(2, '0')}`;
};

/*const getVehicleCountByType = (vehicleType) => {
    if (!vehicleType || !vehicleDefinitions[vehicleType]) return 0;

    const definition = vehicleDefinitions[vehicleType];
    return props.vehicles.filter((v) => v.type === definition.type).length;
};*/

// Actions
const updateDutyStatus = () => {
    router.post(route('employee.dispatch.duty-status'), {
        duty_status: currentDutyStatus.value,
    });
};

const toggleDispatcher = () => {
    router.post(route('employee.dispatch.toggle'));
};

/*const openAssignModal = (vehicle) => {
    selectedVehicle.value = vehicle;
    assignForm.value.vehicle_id = vehicle.id;
    assignForm.value.employee_id = '';
    assignForm.value.notes = '';
    showAssignModal.value = true;
};*/

const closeAssignModal = () => {
    showAssignModal.value = false;
    selectedVehicle.value = null;
    assignForm.value = {
        vehicle_id: null,
        employee_id: '',
        notes: '',
    };
};

const assignVehicle = () => {
    router.post(route('employee.dispatch.assign'), assignForm.value, {
        onSuccess: () => closeAssignModal(),
    });
};

const openAddVehicleModal = () => {
    addVehicleForm.value = {
        vehicle_type: '',
        employee_id: '',
    };
    showAddVehicleModal.value = true;
};

const closeAddVehicleModal = () => {
    showAddVehicleModal.value = false;
    addVehicleForm.value = {
        vehicle_type: '',
        employee_id: '',
    };
};

const addVehicle = () => {
    // Erweitere das Form-Objekt mit generierten Daten
    const vehicleData = {
        ...addVehicleForm.value,
        name: getVehicleName(addVehicleForm.value.vehicle_type),
        license_plate: getVehicleLicensePlate(addVehicleForm.value.vehicle_type),
        type: vehicleDefinitions[addVehicleForm.value.vehicle_type]?.type || addVehicleForm.value.vehicle_type,
    };

    router.post(route('employee.dispatch.add-vehicle'), vehicleData, {
        onSuccess: () => closeAddVehicleModal(),
    });
};

const returnVehicle = (vehicle) => {
    if (confirm(`Fahrzeug "${vehicle.name}" wirklich zurückgeben?`)) {
        const assignment = vehicle.current_driver;
        console.log('Assignment data:', assignment);
        router.post(route('employee.dispatch.return'), {
            assignment_id: assignment.assignment_id,
        });
    }
};
</script>

<style scoped>
.glass-card {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

.glass-nav {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
}

.glass-button {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    cursor: pointer;
}
</style>
