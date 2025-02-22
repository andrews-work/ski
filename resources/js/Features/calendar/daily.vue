<template>
    <div class="flex flex-col items-center justify-between p-6 mx-auto space-y-6 bg-gray-800">
        <div class="flex justify-between w-full">
            <button @click="previousDay" class="px-4 py-2 text-white bg-gray-900 rounded-lg">Previous</button>
            <button @click="nextDay" class="px-4 py-2 text-white bg-gray-900 rounded-lg">Next</button>
        </div>

        <div class="flex flex-col items-center justify-center text-white">
            <h1 class="text-2xl font-semibold">{{ currentDayFormatted }}</h1>
        </div>

        <div class="flex justify-center space-x-4">
            <button
                @click="toggleView('horizontal')"
                :class="{'bg-gray-900': viewMode === 'horizontal', 'bg-gray-700': viewMode !== 'horizontal'}"
                class="px-4 py-2 text-white rounded-lg">
                Horizontal View
            </button>
            <button
                @click="toggleView('vertical')"
                :class="{'bg-gray-900': viewMode === 'vertical', 'bg-gray-700': viewMode !== 'vertical'}"
                class="px-4 py-2 text-white rounded-lg">
                Vertical View
            </button>
        </div>

        <div
            class="flex flex-col items-center justify-center border border-white rounded-lg h-[60vh] w-full p-6"
            :class="viewMode === 'horizontal' ? 'overflow-x-auto' : 'overflow-y-auto'">

            <div v-if="meetings.length === 0" class="text-xl text-white">
                No meetings today
            </div>

            <div v-if="viewMode === 'horizontal'" class="flex space-x-4">
                <div
                    v-for="(meeting, index) in meetings"
                    :key="index"
                    class="p-4 text-white border border-gray-500 rounded-lg h-[30vh] w-[20vw]">
                    <h3 class="font-semibold">{{ meeting.formatted_time }}</h3>
                    <p>{{ meeting.title }}</p>
                </div>
            </div>

            <div v-if="viewMode === 'vertical'" class="flex flex-col space-y-4 border-white">
                <div
                    v-for="(meeting, index) in meetings"
                    :key="index"
                    class="p-4 text-white border-b border-gray-500  h-[30vh] w-[20vw]">
                    <h3 class="font-semibold">{{ meeting.formatted_time }}</h3>
                    <p>{{ meeting.title }}</p>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const currentDate = ref(new Date());
const viewMode = ref('horizontal');
const meetings = ref([]);

const currentDayFormatted = computed(() => {
    return currentDate.value.toLocaleString('default', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
});

const fetchMeetings = async () => {
    const date = currentDate.value.toISOString().split('T')[0];
    const response = await fetch(`/calendar/daily?date=${date}`);
    const data = await response.json();
    meetings.value = data.meetings;
};

const previousDay = () => {
    currentDate.value = new Date(currentDate.value.setDate(currentDate.value.getDate() - 1));
    fetchMeetings();
};

const nextDay = () => {
    currentDate.value = new Date(currentDate.value.setDate(currentDate.value.getDate() + 1));
    fetchMeetings();
};

const toggleView = (mode) => {
    viewMode.value = mode;
};

onMounted(() => {
    fetchMeetings();
});
</script>
