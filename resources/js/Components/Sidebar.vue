<script setup>
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <div class='h-screen py-12 mx-auto sm:px-6 lg:px-8 sm:rounded-lg'>
        <div class='px-4 py-4 text-left bg-gray-800'>
            <div class="flex flex-col space-y-4 sm:space-y-6 sm:flex sm:items-start">

                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Dashboard
                </NavLink>

                <NavLink :href="route('meetings.index')" :active="route().current('meetings.index')">
                    Meetings
                </NavLink>

                <NavLink :href="route('calendar.index')" :active="route().current('calendar.index')">
                    Calendar
                </NavLink>

                <NavLink :href="route('forums')" :active="route().current('forums')">
                    Forums
                </NavLink>

            </div>
        </div>
    </div>
</template>
