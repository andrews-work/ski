<template>
    <div class="space-y-4">
        <!-- Post Content -->
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
            <template v-if="isEditing">
                <input
                    v-model="editedPost.title"
                    class="text-2xl font-bold text-gray-800 border-b-2 dark:text-gray-200"
                    placeholder="Title"
                />
            </template>
            <template v-else>
                {{ post.title }}
            </template>
        </h1>

        <p class="text-gray-700 dark:text-gray-300">
            <template v-if="isEditing">
                <textarea
                    v-model="editedPost.content"
                    class="w-full p-2 border-2 rounded-md"
                    placeholder="Content"
                ></textarea>
            </template>
            <template v-else>
                {{ post.content }}
            </template>
        </p>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Category:
            <template v-if="isEditing">
                <input
                    v-model="editedPost.category"
                    class="border-b-2"
                    placeholder="Category"
                />
            </template>
            <template v-else>
                {{ post.category }}
            </template>
        </p>

        <p class="text-sm text-gray-500 dark:text-gray-400">Posted by: {{ post.user.name }}</p>

        <!-- Post Actions (Edit, Save, Cancel, Delete) -->
        <div class="flex gap-2">
            <template v-if="canEdit">
                <button
                    v-if="!isEditing"
                    @click="startEditing"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                >
                    Edit
                </button>
                <button
                    v-if="isEditing"
                    @click="saveChanges"
                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700"
                >
                    Save
                </button>
                <button
                    v-if="isEditing"
                    @click="cancelEditing"
                    class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700"
                >
                    Cancel
                </button>
            </template>

            <button
                v-if="canDelete"
                @click="deletePost"
                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
            >
                Delete
            </button>
        </div>

        <!-- Comments Section -->
        <div class="mt-8">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Comments</h2>

            <!-- Display Comments -->
            <div v-for="comment in comments" :key="comment.id" class="p-4 mt-4 border rounded-lg">
                <p class="text-gray-700 dark:text-gray-300">{{ comment.content }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    By {{ comment.user.name }} on {{ formatDate(comment.created_at) }}
                </p>

                <!-- Comment Actions (Edit, Delete) -->
                <div v-if="currentUser.id === comment.user_id" class="flex gap-2 mt-2">
                    <button
                        @click="editComment(comment)"
                        class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700"
                    >
                        Edit
                    </button>
                    <button
                        @click="deleteComment(comment)"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                    >
                        Delete
                    </button>
                </div>
            </div>

            <!-- Add Comment Form -->
            <div class="mt-4">
                <textarea
                    v-model="form.content"
                    class="w-full p-2 border-2 rounded-md"
                    placeholder="Write a comment..."
                ></textarea>
                <button
                    @click="submitComment"
                    class="px-4 py-2 mt-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
                >
                    Add Comment
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue';
import { usePage, router, useForm } from '@inertiajs/vue3';

const post = usePage().props.post;
const currentUser = usePage().props.currentUser;

// Local state for comments
const comments = ref([...post.comments]);

// Form for adding a comment
const form = useForm({
    content: '',
});

// Log the post and comments when the component is mounted
onMounted(() => {
    console.log('Post:', post);
    console.log('Comments:', comments.value);
});

// Post Editing Logic
const isEditing = ref(false);
const editedPost = ref({ ...post });

const canEdit = computed(() => currentUser.id === post.user_id);
const canDelete = computed(() => currentUser.id === post.user_id);

const startEditing = () => {
    isEditing.value = true;
};

const saveChanges = async () => {
    await router.put(`/forums/${post.id}`, editedPost.value);
    isEditing.value = false;
    post.title = editedPost.value.title;
    post.content = editedPost.value.content;
    post.category = editedPost.value.category;
};

const cancelEditing = () => {
    isEditing.value = false;
    editedPost.value = { ...post };
};

const deletePost = async () => {
    if (confirm('Are you sure you want to delete this post?')) {
        await router.delete(`/forums/${post.id}`);
    }
};

// Add a new comment
const submitComment = async () => {
    if (!form.content.trim()) return;

    form.post(`/posts/${post.id}/comments`, {
        onSuccess: () => {
            // Add the new comment to the local state
            comments.value.push({
                id: Math.random(), // Temporary ID (replaced by the server response)
                content: form.content,
                user: currentUser,
                created_at: new Date().toISOString(),
            });

            // Clear the form
            form.reset('content');
        },
    });
};

// Edit a comment
const editComment = async (comment) => {
    const updatedContent = prompt('Edit your comment:', comment.content);
    if (updatedContent !== null && updatedContent.trim() !== '') {
        await router.put(`/comments/${comment.id}`, {
            content: updatedContent,
        });

        // Update the comment in the local state
        const index = comments.value.findIndex((c) => c.id === comment.id);
        if (index !== -1) {
            comments.value[index].content = updatedContent;
        }
    }
};

// Delete a comment
const deleteComment = async (comment) => {
    if (confirm('Are you sure you want to delete this comment?')) {
        await router.delete(`/comments/${comment.id}`);

        // Remove the comment from the local state
        comments.value = comments.value.filter((c) => c.id !== comment.id);
    }
};

// Helper Function to Format Date
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString();
};
</script>