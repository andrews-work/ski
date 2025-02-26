<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Reports" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Reports
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>List of resorts</p>
                        <p>click on resort and see a dashboard for the resort</p>
                        <p>opening + closing date</p>
                        <p>current weather</p>
                        <p>weather history</p>
                        <p> runs + gondolas + chairlifts</p>
                        <p>skiable terrain</p>
                        <p>instagram posts</p>
                        <p>forums for that resort</p>
                        <p>quietest time of year</p>
                        <p>restaurants</p>
                        <p>travel</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
