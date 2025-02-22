<template>
    <div>
        <!-- Forum Header -->
        <ForumHeader
            :currentUser="currentUser"
            @update:searchQuery="handleSearchQuery"
            @update:sortBy="handleSort"
            @update:showMyPosts="handleMyPosts"
            :sortDirection="sortDirection"
        />

        <!-- List of Posts -->
        <ul>
            <li v-for="post in posts.data" :key="post.id">
                <Link :href="`/forums/${post.id}`">
                <div class="py-4 my-4 border border-gray-700">
                    <div class="mx-10">
                        <div class="flex justify-between">
                             <p class="text-lg font-bold">{{ post.title }}</p>
                            <p>Category: {{ post.category }}</p>
                        </div>
                        <p class="mt-5 text-sm">{{ truncateContent(post.content, 20) }}</p>
                        <div class="flex justify-between mt-4">
                            <p class="text-sm text-gray-400">{{ post.user.name }}</p>
                            <p class="text-sm text-gray-400">{{ formatDate(post.created_at) }}</p>

                        </div>

                    </div>
                </div>
                </Link>
            </li>
        </ul>

        <!-- Pagination -->
        <div class="flex justify-center gap-2 mt-6">
            <button
                @click="fetchPosts(posts.current_page - 1)"
                :disabled="posts.current_page === 1"
                class="px-4 py-2 text-gray-200 bg-gray-700 rounded-lg hover:bg-gray-600 disabled:opacity-50"
            >
                Previous
            </button>
            <span class="px-4 py-2 text-gray-200">
                Page {{ posts.current_page }} of {{ posts.last_page }}
            </span>
            <button
                @click="fetchPosts(posts.current_page + 1)"
                :disabled="posts.current_page === posts.last_page"
                class="px-4 py-2 text-gray-200 bg-gray-700 rounded-lg hover:bg-gray-600 disabled:opacity-50"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, watch } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import ForumHeader from '@/Features/Forums/Header.vue';

// Props
const props = defineProps({
    posts: Object, // Paginated posts data (now an object)
    currentUser: Object,
    filters: Object, // Query parameters for sorting, filtering, etc.
});

// Local state for sorting and filtering
const searchQuery = ref(props.filters?.search || ''); // Use optional chaining to avoid errors
const sortBy = ref(props.filters?.sort_by || 'date');
const sortDirection = ref(props.filters?.sort_direction || 'desc'); // Default to descending
const showMyPosts = ref(props.filters?.my_posts || false);

// Fetch posts for a specific page
const fetchPosts = (page) => {
    const params = {
        page: page,
        sort_by: sortBy.value, // Include sorting parameter
        sort_direction: sortDirection.value, // Include sort direction
    };

    console.log('Fetching posts with parameters:', params);

    router.get('/forums', params, {
        preserveState: true, // Preserve the current component state
        replace: true, // Replace the current history state
    });
};

// Watch for changes and fetch posts
watch([sortBy, sortDirection], () => {
    fetchPosts(1); // Reset to the first page when sorting changes
});

// Event handlers
const handleSearchQuery = (query) => {
    searchQuery.value = query;
};

const handleSort = (sort) => {
    if (sort === 'date') {
        // Toggle sort direction for date sorting
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        // Reset sort direction for other sorting criteria
        sortDirection.value = 'desc';
    }
    sortBy.value = sort;
};

const handleMyPosts = (value) => {
    showMyPosts.value = value;
};

// Truncate content to a maximum number of words
const truncateContent = (content, maxWords) => {
    const words = content.split(' ');
    if (words.length <= maxWords) {
        return content;
    }
    return words.slice(0, maxWords).join(' ') + '...';
};

// Format the date
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>
