<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Navigation -->
        <nav class="glass-nav sticky top-0 z-50 border-b border-white/20 bg-white/10 backdrop-blur-md dark:border-white/10 dark:bg-black/10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 to-orange-600">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h1 class="text-2xl font-bold text-white">GCT - Mitarbeiterliste</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link :href="route('employee.dashboard')" class="glass-button rounded-lg border border-blue-400/30 bg-blue-500/20 px-4 py-2 text-blue-400 transition-all duration-300 hover:bg-blue-500/30">
                            Dashboard
                        </Link>
                        <Link :href="route('employee.logout')" method="post" class="glass-button rounded-lg border border-red-400/30 bg-red-500/20 px-4 py-2 text-red-400 transition-all duration-300 hover:bg-red-500/30">
                            Abmelden
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- Search and Filter -->
            <div class="mb-8 rounded-2xl border border-white/10 bg-white/5 p-6 dark:border-white/5 dark:bg-black/5 backdrop-blur-20 shadow-lg transition-all duration-300 hover:bg-white/8 dark:hover:bg-black/8">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Suche</label>
                        <input
                            v-model="searchTerm"
                            type="text"
                            placeholder="Name oder Steam ID suchen..."
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white placeholder-white/50 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Rang Filter</label>
                        <select
                            v-model="rankFilter"
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 [&>option]:bg-slate-800 [&>option]:text-white"
                        >
                            <option value="">Alle Ränge</option>
                            <option v-for="rank in ranks" :key="rank.id" :value="rank.id">{{ rank.name }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Status Filter</label>
                        <select
                            v-model="statusFilter"
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 [&>option]:bg-slate-800 [&>option]:text-white"
                        >
                            <option value="">Alle Status</option>
                            <option value="available">Verfügbar</option>
                            <option value="busy">Beschäftigt</option>
                            <option value="break">Pause</option>
                            <option value="off_duty">Außer Dienst</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Employee List -->
            <div class="space-y-6">
                <div
                    v-for="employee in filteredEmployees"
                    :key="employee.id"
                    class="employee-card rounded-2xl border border-white/10 bg-white/5 p-6 dark:border-white/5 dark:bg-black/5 transform transition-all duration-300 hover:scale-[1.02]"
                >
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <!-- Employee Info -->
                        <div class="lg:col-span-1">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-blue-400 to-blue-600">
                                    <span class="text-lg font-bold text-white">
                                        {{ employee.first_name.charAt(0) }}{{ employee.last_name.charAt(0) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">{{ employee.first_name }} {{ employee.last_name }}</h3>
                                    <p class="text-orange-400 font-medium">{{ employee.rank.name }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-white/60">Steam ID:</span>
                                    <span class="text-white">{{ employee.steam_id }}</span>
                                </div>
                                <div v-if="employee.phone_number" class="flex justify-between">
                                    <span class="text-white/60">Telefon:</span>
                                    <span class="text-white">{{ employee.phone_number }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-white/60">Status:</span>
                                    <span :class="getStatusColor(employee.duty_status)">{{ getStatusText(employee.duty_status) }}</span>
                                </div>
                                <div v-if="employee.is_dispatcher" class="flex justify-between">
                                    <span class="text-white/60">Leitstelle:</span>
                                    <span class="text-green-400">Berechtigt</span>
                                </div>
                                <div v-if="employee.current_location" class="flex justify-between">
                                    <span class="text-white/60">Standort:</span>
                                    <span class="text-white">{{ employee.current_location }}</span>
                                </div>
                            </div>

                            <!-- Internal Notes (nur für COO/CEO) -->
                            <div v-if="permissions.canEditEmployees && employee.internal_notes" class="mt-4 p-3 rounded-lg bg-yellow-500/10 border border-yellow-500/30">
                                <h4 class="text-sm font-medium text-yellow-400 mb-1">Interne Notizen:</h4>
                                <p class="text-white/80 text-sm">{{ employee.internal_notes }}</p>
                            </div>

                            <!-- Edit Button (nur für COO/CEO) -->
                            <div v-if="permissions.canEditEmployees" class="mt-4">
                                <button
                                    @click="openEditModal(employee)"
                                    class="glass-button w-full rounded-lg border border-blue-400/30 bg-blue-500/20 px-4 py-2 text-blue-400 transition-all duration-300 hover:bg-blue-500/30"
                                >
                                    Mitarbeiter bearbeiten
                                </button>
                            </div>
                        </div>

                        <!-- Trainings -->
                        <div class="lg:col-span-2">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-lg font-semibold text-white">Ausbildungen</h4>
                                <button
                                    v-if="permissions.canManageTrainings"
                                    @click="openTrainingModal(employee)"
                                    class="glass-button rounded-lg border border-green-400/30 bg-green-500/20 px-3 py-1 text-green-400 transition-all duration-300 hover:bg-green-500/30"
                                >
                                    Ausbildung hinzufügen
                                </button>
                            </div>

                            <div class="grid grid-cols-2 gap-3 md:grid-cols-3 lg:grid-cols-4">
                                <div
                                    v-for="training in trainings"
                                    :key="training.id"
                                    class="relative rounded-lg p-3 transition-all duration-300"
                                    :class="hasTraining(employee, training.code) ? 
                                        (isTrainingExpired(employee, training.code) ? 'bg-red-500/20 border border-red-500/50' : 'bg-green-500/20 border border-green-500/50') : 
                                        'bg-gray-500/20 border border-gray-500/50'"
                                >
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-sm font-medium" :class="hasTraining(employee, training.code) ? 
                                                (isTrainingExpired(employee, training.code) ? 'text-red-400' : 'text-green-400') : 
                                                'text-gray-400'">
                                                {{ training.code }}
                                            </div>
                                            <div class="text-xs" :class="hasTraining(employee, training.code) ? 
                                                (isTrainingExpired(employee, training.code) ? 'text-red-300/80' : 'text-green-300/80') : 
                                                'text-gray-300/80'">
                                                {{ training.name }}
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <svg
                                                v-if="hasTraining(employee, training.code)"
                                                class="h-4 w-4"
                                                :class="isTrainingExpired(employee, training.code) ? 'text-red-400' : 'text-green-400'"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    v-if="!isTrainingExpired(employee, training.code)"
                                                    fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"
                                                />
                                                <path
                                                    v-else
                                                    fill-rule="evenodd"
                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                            <button
                                                v-if="permissions.canManageTrainings && hasTraining(employee, training.code)"
                                                @click="removeTraining(employee, training)"
                                                class="text-red-400 hover:text-red-300 transition-colors"
                                                title="Ausbildung entfernen"
                                            >
                                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Training Details -->
                                    <div v-if="hasTraining(employee, training.code)" class="mt-2 text-xs text-white/60">
                                        <div v-if="getTrainingDetails(employee, training.code)">
                                            <div v-if="isTrainingExpired(employee, training.code)">
                                                Abgelaufen am: {{ formatDate(getTrainingDetails(employee, training.code)?.expires_at ?? '') }}
                                            </div>
                                            <div v-else>
                                                Abgeschlossen: {{ formatDate(getTrainingDetails(employee, training.code)?.completed_at ?? '') }}
                                                <div v-if="getTrainingDetails(employee, training.code)?.expires_at">
                                                    Läuft ab: {{ formatDate(getTrainingDetails(employee, training.code)?.expires_at ?? '') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Employee Modal -->
        <div v-if="editModal.show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="glass-card max-w-2xl w-full mx-4 rounded-2xl border border-white/10 bg-white/5 p-6 dark:border-white/5 dark:bg-black/5">
                <h3 class="text-xl font-bold text-white mb-6">Mitarbeiter bearbeiten</h3>
                
                <form @submit.prevent="updateEmployee" class="space-y-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-white/80 mb-2">Vorname</label>
                            <input
                                v-model="editModal.data.first_name"
                                type="text"
                                required
                                class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white placeholder-white/50 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                            />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-white/80 mb-2">Nachname</label>
                            <input
                                v-model="editModal.data.last_name"
                                type="text"
                                required
                                class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white placeholder-white/50 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                            />
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Telefonnummer</label>
                        <input
                            v-model="editModal.data.phone_number"
                            type="text"
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white placeholder-white/50 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Rang</label>
                        <select
                            v-model="editModal.data.rank_id"
                            required
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 [&>option]:bg-slate-800 [&>option]:text-white"
                        >
                            <option v-for="rank in ranks" :key="rank.id" :value="rank.id">{{ rank.name }}</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center">
                        <input
                            v-model="editModal.data.is_dispatcher"
                            type="checkbox"
                            class="rounded border-white/20 bg-white/10 text-orange-400 focus:ring-orange-400"
                        />
                        <label class="ml-2 text-sm text-white/80">Leitstellen-Berechtigung</label>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Interne Notizen</label>
                        <textarea
                            v-model="editModal.data.internal_notes"
                            rows="3"
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white placeholder-white/50 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                        ></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4">
                        <button
                            type="button"
                            @click="editModal.show = false"
                            class="glass-button rounded-lg border border-gray-400/30 bg-gray-500/20 px-4 py-2 text-gray-400 transition-all duration-300 hover:bg-gray-500/30"
                        >
                            Abbrechen
                        </button>
                        <button
                            type="submit"
                            class="glass-button rounded-lg border border-green-400/30 bg-green-500/20 px-4 py-2 text-green-400 transition-all duration-300 hover:bg-green-500/30"
                        >
                            Speichern
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Training Modal -->
        <div v-if="trainingModal.show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
            <div class="glass-card max-w-lg w-full mx-4 rounded-2xl border border-white/10 bg-white/5 p-6 dark:border-white/5 dark:bg-black/5">
                <h3 class="text-xl font-bold text-white mb-6">Ausbildung hinzufügen</h3>
                
                <form @submit.prevent="addTraining" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Ausbildung</label>
                        <select
                            v-model="trainingModal.data.training_id"
                            required
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50 [&>option]:bg-slate-800 [&>option]:text-white"
                        >
                            <option v-for="training in availableTrainings" :key="training.id" :value="training.id">
                                {{ training.name }} ({{ training.code }})
                            </option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Abschlussdatum</label>
                        <input
                            v-model="trainingModal.data.completed_at"
                            type="date"
                            required
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Ablaufdatum (optional)</label>
                        <input
                            v-model="trainingModal.data.expires_at"
                            type="date"
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                        />
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white/80 mb-2">Notizen</label>
                        <textarea
                            v-model="trainingModal.data.notes"
                            rows="3"
                            class="w-full rounded-lg border border-white/20 bg-white/10 px-4 py-2 text-white placeholder-white/50 focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-400/50"
                        ></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4">
                        <button
                            type="button"
                            @click="trainingModal.show = false"
                            class="glass-button rounded-lg border border-gray-400/30 bg-gray-500/20 px-4 py-2 text-gray-400 transition-all duration-300 hover:bg-gray-500/30"
                        >
                            Abbrechen
                        </button>
                        <button
                            type="submit"
                            class="glass-button rounded-lg border border-green-400/30 bg-green-500/20 px-4 py-2 text-green-400 transition-all duration-300 hover:bg-green-500/30"
                        >
                            Hinzufügen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface Rank {
    id: number;
    name: string;
}

interface Training {
    id: number;
    name: string;
    code: string;
    description: string;
    is_required: boolean;
}

interface EmployeeTraining {
    id: number;
    name: string;
    code: string;
    completed_at: string;
    expires_at: string | null;
    trainer_id: number;
    notes: string | null;
    is_expired: boolean;
}

interface Employee {
    id: number;
    steam_id: string;
    first_name: string;
    last_name: string;
    phone_number: string | null;
    rank: Rank;
    is_dispatcher: boolean;
    duty_status: string;
    duty_started_at: string | null;
    current_location: string | null;
    internal_notes: string | null;
    trainings: EmployeeTraining[];
}

interface Permissions {
    canManageTrainings: boolean;
    canEditEmployees: boolean;
}

const props = defineProps<{
    employees: Employee[];
    trainings: Training[];
    ranks: Rank[];
    permissions: Permissions;
}>();

// Filter states
const searchTerm = ref('');
const rankFilter = ref('');
const statusFilter = ref('');

// Modal states
const editModal = ref({
    show: false,
    employeeId: null as number | null,
    data: {
        first_name: '',
        last_name: '',
        phone_number: '',
        rank_id: null as number | null,
        is_dispatcher: false,
        internal_notes: '',
    }
});

const trainingModal = ref({
    show: false,
    employeeId: null as number | null,
    data: {
        training_id: null as number | null,
        completed_at: '',
        expires_at: '',
        notes: '',
    }
});

// Computed
const filteredEmployees = computed(() => {
    return props.employees.filter(employee => {
        const matchesSearch = searchTerm.value === '' || 
            employee.first_name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            employee.last_name.toLowerCase().includes(searchTerm.value.toLowerCase()) ||
            employee.steam_id.toLowerCase().includes(searchTerm.value.toLowerCase());
        const matchesRank = rankFilter.value === '' || employee.rank.id.toString() === rankFilter.value.toString();
        const matchesStatus = statusFilter.value === '' || employee.duty_status === statusFilter.value;

        return matchesSearch && matchesRank && matchesStatus;
    });
});

const availableTrainings = computed(() => {
    if (!trainingModal.value.employeeId) return props.trainings;
    
    const employee = props.employees.find(emp => emp.id === trainingModal.value.employeeId);
    if (!employee) return props.trainings;
    
    // Nur Ausbildungen anzeigen, die der Mitarbeiter noch nicht hat
    return props.trainings.filter(training => 
        !employee.trainings.some(empTraining => empTraining.code === training.code)
    );
});

// Methods
const getStatusColor = (status: string) => {
    switch (status) {
        case 'available':
            return 'text-green-400';
        case 'busy':
            return 'text-orange-400';
        case 'break':
            return 'text-yellow-400';
        case 'off_duty':
            return 'text-gray-400';
        default:
            return 'text-gray-400';
    }
};

const getStatusText = (status: string) => {
    switch (status) {
        case 'available':
            return 'Verfügbar';
        case 'busy':
            return 'Beschäftigt';
        case 'break':
            return 'Pause';
        case 'off_duty':
            return 'Außer Dienst';
        default:
            return 'Unbekannt';
    }
};

const hasTraining = (employee: Employee, trainingCode: string) => {
    return employee.trainings.some(t => t.code === trainingCode);
};

const isTrainingExpired = (employee: Employee, trainingCode: string) => {
    const training = employee.trainings.find(t => t.code === trainingCode);
    return training ? training.is_expired : false;
};

const getTrainingDetails = (employee: Employee, trainingCode: string) => {
    return employee.trainings.find(t => t.code === trainingCode);
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('de-DE');
};

const openEditModal = (employee: Employee) => {
    editModal.value = {
        show: true,
        employeeId: employee.id,
        data: {
            first_name: employee.first_name,
            last_name: employee.last_name,
            phone_number: employee.phone_number || '',
            rank_id: employee.rank.id,
            is_dispatcher: employee.is_dispatcher,
            internal_notes: employee.internal_notes || '',
        }
    };
};

const openTrainingModal = (employee: Employee) => {
    trainingModal.value = {
        show: true,
        employeeId: employee.id,
        data: {
            training_id: null,
            completed_at: new Date().toISOString().split('T')[0],
            expires_at: '',
            notes: '',
        }
    };
};

const updateEmployee = () => {
    router.put(`/employee-list/${editModal.value.employeeId}`, editModal.value.data, {
        onSuccess: () => {
            editModal.value.show = false;
        }
    });
};

const addTraining = () => {
    router.post(`/employee-list/${trainingModal.value.employeeId}/training`, trainingModal.value.data, {
        onSuccess: () => {
            trainingModal.value.show = false;
        }
    });
};

const removeTraining = (employee: Employee, training: Training) => {
    if (confirm(`Möchten Sie die Ausbildung "${training.name}" von ${employee.first_name} ${employee.last_name} entfernen?`)) {
        router.delete(`/employee-list/${employee.id}/training/${training.id}`);
    }
};
</script>

<style scoped>

.glass-button {
    cursor: pointer;
}
</style>
