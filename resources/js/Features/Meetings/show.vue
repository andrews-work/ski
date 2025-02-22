<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

defineProps({
    meetings: Array,
});

const isEditing = ref(false);
const meetingBeingEdited = ref(null);
const timeSlots = ref([]);

const generateTimeSlots = () => {
    const hoursRange = Array.from({ length: 10 }, (_, i) => i + 9);
    const minutesRange = ['00', '15', '30', '45'];

    hoursRange.forEach((hour) => {
        minutesRange.forEach((minute) => {
            const formattedTime = `${String(hour).padStart(2, '0')}:${minute}`;
            timeSlots.value.push(formattedTime);
        });
    });
};

generateTimeSlots();

const toggleEdit = (meeting = null) => {
    isEditing.value = !isEditing.value;
    meetingBeingEdited.value = meeting ? meeting.id : null;

    if (meeting) {
        const time = new Date(meeting.datetime).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });
        meeting.time = time.replace('24:', '00:');
    }
};

const saveMeeting = ({ id, title, description, date, time, location }) => {
    router.put(route('meetings.update', { meetingId: id }), {
        title,
        description,
        date,
        time,
        location,
    }, {
        onSuccess: () => {
            console.log('Meeting updated successfully');
            toggleEdit();
        },
        onError: (error) => {
            console.error('Error updating meeting', error);
        },
    });
};

const deleteMeeting = (meetingId) => {
    if (confirm("Are you sure you want to delete this meeting?")) {
        router.delete(route('meetings.delete', { meetingId }), {
            onSuccess: () => {
                console.log('Meeting deleted successfully');
            },
            onError: (error) => {
                console.error('Error deleting meeting', error);
            },
        });
    }
};

const formattedDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
};

const formattedTime = (datetime) => {
    return new Date(datetime).toLocaleTimeString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });
};
</script>

<template>
    <div class="py-12">
        <div class="w-full mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="mb-4 text-2xl font-semibold">Meeting List</h3>

                    <div v-if="meetings.length === 0" class="text-gray-500">
                        <p>No meetings scheduled.</p>
                    </div>

                    <div v-else class="py-4 overflow-x-auto">
                        <div class="flex gap-6 flex-nowrap">
                            <div
                                v-for="meeting in meetings"
                                :key="meeting.id"
                                class="min-w-[22vw] p-6 border h-[60vh] border-gray-300 rounded-lg shadow-md bg-gray-50 dark:bg-gray-700"
                            >
                                <h3 class="text-xl font-semibold text-center text-blue-600">
                                    <input v-if="isEditing && meetingBeingEdited === meeting.id" type="date" v-model="meeting.date" class="p-2 bg-gray-100 border rounded-md dark:bg-gray-600" />
                                    <span v-else>
                                        {{ formattedDate(meeting.date) }}
                                    </span>
                                </h3>

                                <div class="space-y-2">
                                    <p><strong>Time:</strong>
                                        <select v-if="isEditing && meetingBeingEdited === meeting.id" v-model="meeting.time" class="p-2 bg-gray-100 border rounded-md dark:bg-gray-600">
                                            <option v-for="time in timeSlots" :key="time" :value="time">{{ time }}</option>
                                        </select>
                                        <span v-else>
                                            {{ formattedTime(meeting.datetime) }}
                                        </span>
                                    </p>

                                    <p><strong>Location:</strong>
                                        <input v-if="isEditing && meetingBeingEdited === meeting.id" type="text" v-model="meeting.location" class="p-2 bg-gray-100 border rounded-md dark:bg-gray-600" />
                                        <span v-else>{{ meeting.location }}</span>
                                    </p>

                                    <p><strong>Attendees:</strong>
                                        <select v-if="isEditing && meetingBeingEdited === meeting.id" v-model="meeting.attendees" class="p-2 bg-gray-100 border rounded-md dark:bg-gray-600">
                                        </select>
                                    </p>
                                </div>

                                <div class="flex-1 space-y-2">
                                    <p><strong>Description:</strong></p>
                                    <textarea v-if="isEditing && meetingBeingEdited === meeting.id" v-model="meeting.description" class="p-2 bg-gray-100 border rounded-md dark:bg-gray-600" rows="4"></textarea>
                                    <span v-else class="h-24 overflow-auto text-sm text-gray-700">{{ meeting.description }}</span>
                                </div>

                                <div class="flex-1 mt-4">
                                    <strong>Files:</strong>
                                    <span v-if="meeting.files">
                                        <a :href="`/storage/${meeting.files}`" class="text-blue-500 hover:underline" target="_blank">View Files</a>
                                    </span>
                                    <span v-else class="text-gray-500">No files attached</span>
                                </div>

                                <div class="flex justify-between mt-4">
                                    <div v-if="isEditing && meetingBeingEdited === meeting.id" class="flex justify-between w-full space-x-4">
                                        <button @click="toggleEdit" class="px-4 py-2 text-white bg-red-600 rounded-md">Cancel</button>
                                        <button @click="saveMeeting(meeting)" class="px-4 py-2 text-white bg-green-600 rounded-md">Save</button>
                                        <button @click="deleteMeeting(meeting.id)" class="px-4 py-2 text-white bg-red-600 rounded-md">Delete</button>
                                    </div>
                                    <div v-else>
                                        <button @click="toggleEdit(meeting)" class="px-4 py-2 text-white bg-blue-600 rounded-md">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
