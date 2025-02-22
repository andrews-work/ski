<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Show from '@/Features/Meetings/show.vue';
import Create from '@/Features/Meetings/create.vue';

const props = defineProps({
    meetings: Array,
});

const isCreateFormVisible = ref(false);

const handleMeetingCreated = () => {
    isCreateFormVisible.value = false; 
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Meetings
            </h2>
        </template>

        <div class="py-12">
            <div class="w-full mx-auto sm:px-6 lg:px-">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="px-12 mt-8">
                            <button
                                @click="isCreateFormVisible = !isCreateFormVisible"
                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                            >
                                {{ isCreateFormVisible ? 'Cancel' : 'Create New Meeting' }}
                            </button>
                        </div>

                        <div v-if="isCreateFormVisible" class="mt-4">
                            <Create @meetingCreated="handleMeetingCreated" />
                        </div>

                        <div v-if="!isCreateFormVisible" class="mt-4">
                            <Show :meetings="meetings" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
