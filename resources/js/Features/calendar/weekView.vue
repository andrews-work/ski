<template>
    <div :class="isVerticalView ? 'w-full bg-gray-900 p-6 text-center border rounded-lg' : 'w-[100vw] bg-gray-900 p-6 text-center border rounded-lg' ">
        <div class="flex space-x-2">
            <DayView
                v-for="(day, index) in week.weekDays"
                :key="index"
                :day="day"
                :is-vertical-view="isVerticalView"
                :meetings="meetings"
            />
        </div>
    </div>
</template>

<script setup>
import DayView from './dayView.vue';

defineProps({
    week: Object,
    isVerticalView: Boolean,
    meetings: Array,
});
</script>
