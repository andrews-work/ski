<script setup>
import { ref, onMounted } from 'vue';

// Track the current URL
const currentUrl = ref('');

// Set currentUrl to window.location.href when the component is mounted
onMounted(() => {
  currentUrl.value = window.location.href;
});
</script>

<template>
    <div class='h-screen py-12 mx-auto sm:px-6 lg:px-8 sm:rounded-lg'>
        <div class='px-4 py-4 text-left bg-gray-800'>
            <div class="flex flex-col space-y-4 sm:space-y-6 sm:flex sm:items-start">

                <!-- Default NavLinks based on currentUrl -->
                <template v-if="currentUrl.includes('dashboard')">
                    <button class="text-white">Dashboard</button>
                </template>

                <template v-if="currentUrl.includes('meetings')">
                    <button class="text-white">Meetings</button>
                </template>

                <template v-if="currentUrl.includes('calendar')">
                    <button class="text-white">Calendar</button>

                </template>

                <!-- Forums Section with Buttons instead of Links -->
                <template v-if="currentUrl.includes('forums')">
                    <button class="px-4 py-2 text-white rounded-md focus:outline-none hover:bg-gray-700">
                        Resorts
                    </button>
                    <button class="px-4 py-2 text-white rounded-md focus:outline-none hover:bg-gray-700">
                        Gear
                    </button>
                    <button class="px-4 py-2 text-white rounded-md focus:outline-none hover:bg-gray-700">
                        Posts
                    </button>
                    <button class="px-4 py-2 text-white rounded-md focus:outline-none hover:bg-gray-700">
                        Events
                    </button>
                    <button class="px-4 py-2 text-white rounded-md focus:outline-none hover:bg-gray-700">
                        Safety
                    </button>
                    <button class="px-4 py-2 text-white rounded-md focus:outline-none hover:bg-gray-700">
                        Technique
                    </button>
                </template>

                <template v-if="currentUrl.includes('marketplace')">
                    <button class="text-white">Marketplace</button>
                </template>

            </div>
        </div>
    </div>
</template>
