<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const emit = defineEmits(['meetingCreated']); // Define the emit

const form = ref({
    title: '',
    description: '',
    date: '',
    time: '',
    location: '',
});

// Time slots array
const timeSlots = [];
const generateTimeSlots = () => {
    let startTime = new Date();
    startTime.setHours(9, 0, 0, 0);

    while (startTime.getHours() < 17 || (startTime.getHours() === 17 && startTime.getMinutes() <= 45)) {
        const hours = String(startTime.getHours()).padStart(2, '0');
        const minutes = String(startTime.getMinutes()).padStart(2, '0');
        const timeSlot = `${hours}:${minutes}`;
        timeSlots.push(timeSlot);
        startTime.setMinutes(startTime.getMinutes() + 15);
    }
};

generateTimeSlots();

// Function to handle form submission
const createMeeting = () => {
    console.log('Form data:', form.value);
    router.post('/meetings', form.value, {
        onSuccess: () => {
            emit('meetingCreated'); // Emit the event after successful submission
        },
    });
};
</script>

<template>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-2xl font-semibold text-center">Create Meeting</h3>

                    <form @submit.prevent="createMeeting" class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                            <input
                                v-model="form.title"
                                type="text"
                                id="title"
                                class="w-full p-3 mt-1 text-gray-900 bg-gray-100 border rounded-md dark:bg-gray-600 dark:text-gray-100"
                                required
                            />
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea
                                v-model="form.description"
                                id="description"
                                rows="4"
                                class="w-full p-3 mt-1 text-gray-900 bg-gray-100 border rounded-md dark:bg-gray-600 dark:text-gray-100"
                            ></textarea>
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                            <input
                                v-model="form.date"
                                type="date"
                                id="date"
                                class="w-full p-3 mt-1 text-gray-900 bg-gray-100 border rounded-md dark:bg-gray-600 dark:text-gray-100"
                                required
                            />
                        </div>

                        <!-- Time -->
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time</label>
                            <select
                                v-model="form.time"
                                id="time"
                                class="w-full p-3 mt-1 text-gray-900 bg-gray-100 border rounded-md dark:bg-gray-600 dark:text-gray-100"
                                required
                            >
                                <option v-for="time in timeSlots" :key="time" :value="time">
                                    {{ time }}
                                </option>
                            </select>
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Location</label>
                            <input
                                v-model="form.location"
                                type="text"
                                id="location"
                                class="w-full p-3 mt-1 text-gray-900 bg-gray-100 border rounded-md dark:bg-gray-600 dark:text-gray-100"
                                required
                            />
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button
                                type="submit"
                                class="w-full py-3 mt-4 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                            >
                                Create Meeting
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>