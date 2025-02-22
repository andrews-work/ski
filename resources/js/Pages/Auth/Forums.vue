<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ForumList from '@/Features/Forums/List.vue';
import Post from '@/Features/Forums/Post.vue'; // Import the Post component

// Define the props
const props = defineProps({
    posts: Object, // Paginated posts data (now an object)
    currentUser: Object,
    filters: Object, // Query parameters for sorting, filtering, etc.
    post: Object, // Single post data (optional)
});
</script>

<template>
    <Head title="Forums" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Forums
            </h2>
        </template>

        <div class="py-12">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- Conditionally render ForumList or Post -->
                        <ForumList
                            v-if="!post"
                            :key="posts.current_page"
                            :posts="posts"
                            :currentUser="currentUser"
                            :filters="filters"
                        />
                        <Post v-else :post="post" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
