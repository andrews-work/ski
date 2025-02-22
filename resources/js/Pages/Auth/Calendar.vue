<script setup>
import { ref } from 'vue'; // Import ref for reactive state
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Daily from '@/Features/calendar/daily.vue';
import Weekly from '@/Features/calendar/weekly.vue';
import Monthly from '@/Features/calendar/monthly.vue';

// State to manage the active view
const activeView = ref('daily');

// Function to switch views
const setView = (view) => {
  activeView.value = view;
};
</script>

<template>
    <Head title="Calendar" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Calendar
            </h2>
        </template>

        <div class="py-12">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Navigation Buttons -->
                        <div class="flex mb-4 space-x-4">
                            <button
                                @click="setView('daily')"
                                :class="{ 'font-bold underline': activeView === 'daily' }"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100"
                            >
                                Daily
                            </button>
                            <button
                                @click="setView('weekly')"
                                :class="{ 'font-bold underline': activeView === 'weekly' }"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100"
                            >
                                Weekly
                            </button>
                            <button
                                @click="setView('monthly')"
                                :class="{ 'font-bold underline': activeView === 'monthly' }"
                                class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100"
                            >
                                Monthly
                            </button>
                        </div>

                        <!-- Conditional Rendering of Views -->
                        <Daily v-if="activeView === 'daily'" />
                        <Weekly v-if="activeView === 'weekly'" />
                        <Monthly v-if="activeView === 'monthly'" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>