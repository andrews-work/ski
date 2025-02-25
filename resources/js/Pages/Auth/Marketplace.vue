<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Accounts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Marketplace
            </h2>
        </template>

        <div class="py-12">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="flex p-6 text-gray-900 justify-evenly dark:text-gray-100 ">
                        <p class="w-20 h-20 text-center border border-white">Buy</p>
                        <p class="w-20 h-20 text-center border border-white">Sell</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
