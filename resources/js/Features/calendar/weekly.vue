<template>
    <div class="p-4 h-[70vh]">
        <div class="flex items-center justify-between mb-4">
            <button @click="previousWeek" class="px-4 py-2 text-white bg-gray-900 rounded-lg" :disabled="currentWeekIndex === 0">Previous Week</button>
            <div class="flex items-center w-full ml-[30vw]">
                <h1 class="text-2xl font-bold mr-[2vw]">{{ currentWeekFormatted.left }}</h1>
                <h2 class="text-xl text-gray-300">{{ currentWeekFormatted.right }}</h2>
            </div>
            <button @click="nextWeek" class="px-4 py-2 text-white bg-gray-900 rounded-lg" :disabled="currentWeekIndex === weeks.length - 1">Next Week</button>
        </div>

        <div class="flex mb-4">
            <button @click="toggleView" class="px-4 py-2 text-white bg-gray-700 rounded-lg">
                Switch to {{ isVerticalView ? 'Vertical' : 'Horizontal' }} View
            </button>
        </div>

        <div
            class="overflow-x-auto h-[60vh] scroll-snap-x mandatory"
            ref="scrollContainer"
            @scroll="handleScroll"
            style="width: 100%;"
        >
            <div class="flex space-x-0">
                <WeekView
                    v-for="(week, index) in weeks"
                    :key="week.startDate"
                    :week="week"
                    :is-vertical-view="isVerticalView"
                    :meetings="meetings"
                    class="flex-none w-full scroll-snap-start"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import WeekView from './weekView.vue';

const weeks = ref([]);
const meetings = ref([]);
const isVerticalView = ref(true);
const currentWeekIndex = ref(0);  // Start at the first week
const currentWeekFormatted = ref({ left: '', right: '' });

// Fetch data for the weekly calendar
const fetchWeekData = async () => {
    try {
        const response = await fetch(`/calendar/weekly`);
        if (!response.ok) throw new Error('Failed to fetch week data');
        const data = await response.json();

        // Log data to check the structure of the response
        console.log("Fetched week data:", data);

        if (data.weeks && data.weeks.length > 0) {
            weeks.value = data.weeks;

            // Find the week that contains the current date
            const currentDate = new Date();
            currentWeekIndex.value = findCurrentWeekIndex(currentDate);

            // Update the current week display based on the currentWeekIndex
            updateWeekDisplay(weeks.value[currentWeekIndex.value]);
        }

        meetings.value = data.meetings;
    } catch (error) {
        console.error('Error fetching week data:', error);
    }
};

// Function to find the current week index by comparing the current date with the week ranges
const findCurrentWeekIndex = (currentDate) => {
    // Iterate over the weeks and find the one that includes the current date
    return weeks.value.findIndex((week) => {
        const startDate = new Date(week.startDate);
        const endDate = new Date(week.endDate);

        // Check if the current date is between the start and end of this week
        return currentDate >= startDate && currentDate <= endDate;
    });
};

// Format the display of the week range
const formatWeekDisplay = (startDate, endDate) => {
    const startDay = startDate.getDate();
    const endDay = endDate.getDate();
    const startMonth = startDate.toLocaleString('default', { month: 'long' });
    const year = startDate.getFullYear();

    const getDayWithSuffix = (day) => {
        if (day >= 11 && day <= 13) return day + 'th';
        switch (day % 10) {
            case 1: return day + 'st';
            case 2: return day + 'nd';
            case 3: return day + 'rd';
            default: return day + 'th';
        }
    };

    return {
        left: `${getDayWithSuffix(startDay)} - ${getDayWithSuffix(endDay)}`,
        right: `${startMonth} ${year}`
    };
};

// Update the display of the current week
const updateWeekDisplay = (week) => {
    const startDate = new Date(week.startDate);
    const endDate = new Date(week.endDate);
    currentWeekFormatted.value = formatWeekDisplay(startDate, endDate);
};

// Handle scroll behavior to keep the week in view
const handleScroll = () => {
    const scrollContainer = document.querySelector(".scroll-snap-x");
    const snapPoints = scrollContainer.querySelectorAll(".scroll-snap-start");
    let currentWeekIndexLocal = -1;

    snapPoints.forEach((snapPoint, index) => {
        const rect = snapPoint.getBoundingClientRect();
        if (rect.left <= 0 && rect.right > 0) {
            currentWeekIndexLocal = index;
        }
    });

    if (currentWeekIndexLocal !== -1 && currentWeekIndexLocal !== currentWeekIndex.value) {
        currentWeekIndex.value = currentWeekIndexLocal;
        updateWeekDisplay(weeks.value[currentWeekIndex.value]);
    }
};

// Navigate to the previous week
const previousWeek = () => {
    if (currentWeekIndex.value > 0) {
        currentWeekIndex.value--;
        updateWeekDisplay(weeks.value[currentWeekIndex.value]);
        scrollToWeek(currentWeekIndex.value);
    }
};

// Navigate to the next week
const nextWeek = () => {
    if (currentWeekIndex.value < weeks.value.length - 1) {
        currentWeekIndex.value++;
        updateWeekDisplay(weeks.value[currentWeekIndex.value]);
        scrollToWeek(currentWeekIndex.value);
    }
};

// Scroll to the selected week
const scrollToWeek = (index) => {
    const scrollContainer = document.querySelector(".scroll-snap-x");
    const weekElements = scrollContainer.querySelectorAll(".scroll-snap-start");
    if (weekElements[index]) {
        weekElements[index].scrollIntoView({ behavior: "smooth", block: "start" });
    }
};

// Toggle between vertical and horizontal views
const toggleView = () => {
    isVerticalView.value = !isVerticalView.value;
};

onMounted(() => {
    fetchWeekData(); // Fetch the weekly data when the component is mounted
});
</script>

<style scoped>
.overflow-x-auto {
    overflow-x: auto;
}
.scroll-snap-x {
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
}
.scroll-snap-start {
    scroll-snap-align: start;
}
</style>
