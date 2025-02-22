<template>
    <div class="p-4">
      <div class="flex items-center justify-between mb-4">
        <button @click="previousMonth" class="px-4 py-2 bg-gray-900 rounded-lg">Previous</button>
        <h1 class="text-2xl font-bold">{{ currentMonth }}</h1>
        <button @click="nextMonth" class="px-4 py-2 bg-gray-900 rounded-lg">Next</button>
      </div>
      <div class="grid grid-cols-7 gap-4">
        <!-- Calendar Header -->
        <div v-for="day in daysOfWeek" :key="day" class="font-bold text-center">
          {{ day }}
        </div>
        <!-- Calendar Days -->
        <div
          v-for="day in calendarDays"
          :key="day.date"
          :class="[
            'p-4 h-40 text-left',
            { 'border rounded-lg': day.date, 'bg-gray-900 border border-gray-400': isCurrentDay(day.date) }
          ]"
        >
          <div>{{ day.day }}</div>

          <!-- Display meetings for the specific day -->
          <div v-if="day.date && meetingsForDay(day.date).length > 0" class="mt-2 text-sm text-white">
            <ul>
              <li v-for="meeting in meetingsForDay(day.date)" :key="meeting.id">
                {{ formatMeetingDatetime(meeting.datetime) }} - {{ meeting.title }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, computed, onMounted } from 'vue';

  // State variables
  const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  const currentDate = ref(new Date());
  const currentDay = ref(new Date()); // Current day for highlighting
  const meetings = ref([]); // Store meetings for the month

  const currentMonth = computed(() => {
    return currentDate.value.toLocaleString('default', { month: 'long', year: 'numeric' });
  });

  const calendarDays = computed(() => {
    const year = currentDate.value.getFullYear();
    const month = currentDate.value.getMonth();
    const firstDayOfMonth = new Date(year, month, 1);
    const lastDayOfMonth = new Date(year, month + 1, 0);
    const daysInMonth = lastDayOfMonth.getDate();
    const startingDay = firstDayOfMonth.getDay();

    const days = [];

    // Fill in the blanks for the days before the first day of the month
    for (let i = 0; i < startingDay; i++) {
      days.push({ day: '', date: null });
    }

    // Fill in the days of the month
    for (let i = 1; i <= daysInMonth; i++) {
      days.push({ day: i, date: new Date(year, month, i) });
    }

    return days;
  });

// Pass the selected month to the backend when fetching meetings
const fetchMeetings = async () => {
    const year = currentDate.value.getFullYear();
    const month = currentDate.value.getMonth() + 1; // month is 0-based, so add 1

    const response = await fetch(`/calendar/monthly?year=${year}&month=${month}`);
    const data = await response.json();
    meetings.value = data.meetings;
    console.log('Fetched meetings:', meetings.value);  // Log meetings data for debugging
};


  onMounted(() => {
    fetchMeetings(); // Fetch meetings when the component is mounted
  });

  // Navigate to the previous month
  const previousMonth = () => {
    currentDate.value = new Date(currentDate.value.setMonth(currentDate.value.getMonth() - 1));
    fetchMeetings(); // Re-fetch meetings after month change
  };

  // Navigate to the next month
  const nextMonth = () => {
    currentDate.value = new Date(currentDate.value.setMonth(currentDate.value.getMonth() + 1));
    fetchMeetings(); // Re-fetch meetings after month change
  };

  // Check if a day is the current day
  const isCurrentDay = (date) => {
    if (!date) return false;
    return date.toDateString() === currentDay.value.toDateString();
  };

  // Get meetings for a specific day
  const meetingsForDay = (date) => {
    // Only process dates that are valid (non-null)
    if (!date) return [];

    return meetings.value.filter(meeting => {
      const meetingDate = new Date(meeting.datetime);
      return meetingDate.toDateString() === date.toDateString();
    });
  };

  // Helper function to format meeting datetime
  const formatMeetingDatetime = (datetime) => {
    const meetingDate = new Date(datetime);
    return `${meetingDate.toLocaleDateString()} at ${meetingDate.toLocaleTimeString()}`;
  };
  </script>
