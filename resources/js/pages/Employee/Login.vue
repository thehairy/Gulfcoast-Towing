<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
                    Mitarbeiter Login
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
                    Melden Sie sich mit Ihrem Steam-Account an
                </p>
            </div>
            
            <div class="mt-8 space-y-6">
                <div v-if="$page.props.errors.steam" class="rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Anmeldung fehlgeschlagen
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                {{ $page.props.errors.steam }}
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <a :href="route('steam.redirect', { type: 'employee' })" 
                       class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                        </span>
                        Mit Steam anmelden
                    </a>
                </div>

                <div class="text-center">
                    <Link :href="route('home')" class="text-indigo-600 hover:text-indigo-500">
                        Zurück zur Startseite
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineOptions({
    layout: null
})
</script>
