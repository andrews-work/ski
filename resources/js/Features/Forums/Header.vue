<template>
    <div class="forum-header">
        <!-- Adjusting the layout with responsive classes -->
        <div class="flex flex-col gap-4 p-4 bg-gray-800 rounded-lg md:grid md:grid-cols-2 lg:grid-cols-1 justify-evenly">
            <!-- Search Bar -->
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Search posts..."
                class="px-4 py-2 text-sm text-gray-200 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500"
            />

            <!-- Sort Options -->
            <div class="flex gap-4">
                <!-- Sort by Date -->
                <button
                    @click="setSortBy('date')"
                    :class="{
                        'bg-blue-700 text-white': sortBy === 'date',
                        'bg-gray-700 text-gray-200': sortBy !== 'date',
                    }"
                    class="px-4 py-2 text-sm transition-colors rounded-lg hover:bg-blue-900"
                >
                    Sort by Date {{ sortDirection === 'asc' ? '↑' : '↓' }}
                </button>

                <!-- Sort by Author -->
                <button
                    @click="setSortBy('author')"
                    :class="{
                        'bg-blue-500 text-white': sortBy === 'author',
                        'bg-gray-700 text-gray-200': sortBy !== 'author',
                    }"
                    class="px-4 py-2 text-sm transition-colors rounded-lg hover:bg-blue-600"
                >
                    Sort by Author
                </button>

                <!-- Sort by Category -->
                <button
                    @click="setSortBy('category')"
                    :class="{
                        'bg-blue-500 text-white': sortBy === 'category',
                        'bg-gray-700 text-gray-200': sortBy !== 'category',
                    }"
                    class="px-4 py-2 text-sm transition-colors rounded-lg hover:bg-blue-600"
                >
                    Sort by Category
                </button>
            </div>

            <!-- My Posts Button -->
            <button
                @click="toggleMyPosts"
                :class="{
                    'bg-blue-500 text-white': showMyPosts,
                    'bg-gray-700 text-gray-200': !showMyPosts,
                }"
                class="px-4 py-2 text-sm transition-colors rounded-lg hover:bg-blue-600"
            >
                My Posts
            </button>

            <!-- Create New Post Button -->
            <Link href="/forums/create" class="px-4 py-2 text-sm text-center text-white transition-colors bg-green-800 rounded-lg hover:bg-green-600">
                Create New Post
            </Link>
        </div>
    </div>
</template>


<script setup>
import { ref, watch, defineEmits, defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

// Define props
const props = defineProps({
    sortDirection: {
        type: String,
        default: 'desc', // Default to descending
    },
});

const emit = defineEmits(['update:searchQuery', 'update:sortBy', 'update:showMyPosts']);

const searchQuery = ref('');
const sortBy = ref('date');
const showMyPosts = ref(false);

// Set the sorting criteria
const setSortBy = (criteria) => {
    if (criteria === 'date') {
        emit('update:sortBy', criteria);
    } else {
        emit('update:sortBy', criteria);
    }
};
</script>
