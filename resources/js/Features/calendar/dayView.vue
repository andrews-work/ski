<template>
    <div
        :class="[
            isVerticalView ? 'w-full h-[40vh] p-2 text-center border rounded-lg' : 'w-[12vw] h-[50vh] p-2 text-center border rounded-lg',
            isCurrentDay ? 'bg-gray-700' : 'bg-gray-800'
        ]"
    >
        <div class="flex items-center justify-center text-center">
            <div class="mr-2 font-bold">{{ day.dayOfWeek }}</div>
            <div>{{ day.date }}</div>
        </div>

        <div v-if="meetingsForDay.length > 0" class="mt-2 text-sm text-white">
            <ul>
                <li v-for="meeting in meetingsForDay" :key="meeting.id" class="mb-1">
                    <span>{{ formatMeetingDatetime(meeting.datetime) }} - </span>
                    <strong>{{ meeting.title }}</strong>
                </li>
            </ul>
        </div>
        <div v-else class="mt-2 text-sm text-gray-400">No meetings scheduled</div>
    </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
    day: Object,
    isVerticalView: Boolean,
    meetings: Array,
});

// Check if the current day is the same as the displayed day
const isCurrentDay = computed(() => {
    const today = new Date();
    const dayDate = new Date(props.day.fullDate); // Use the full date from the day object
    return (
        today.getDate() === dayDate.getDate() &&
        today.getMonth() === dayDate.getMonth() &&
        today.getFullYear() === dayDate.getFullYear()
    );
});

const meetingsForDay = computed(() => {
    return props.meetings.filter(meeting => {
        const meetingDate = new Date(meeting.datetime);
        return meetingDate.getDate() === props.day.date;
    });
});

const formatMeetingDatetime = (datetime) => {
    const meetingDate = new Date(datetime);
    return `${meetingDate.toLocaleDateString()} at ${meetingDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}`;
};
</script>
