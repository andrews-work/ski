<template>
    <div class="mt-8">
      <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Comments</h2>

      <div v-for="comment in comments" :key="comment.id" class="p-4 mt-4 rounded-lg">
        <p class="text-gray-700 dark:text-gray-300">{{ comment.content }}</p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          {{ comment.user.name }} - {{ formatDate(comment.created_at) }}
        </p>

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

      <div class="mt-4">
        <textarea
          v-model="form.content"
          class="w-full p-2 bg-gray-600 border-2 rounded-md"
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
  </template>

  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';

  const props = defineProps({
    comments: Array,
    currentUser: Object,
    postId: Number,
  });

  const form = useForm({
    content: '',
  });

  const emit = defineEmits(['comment-added', 'comment-edited', 'comment-deleted']);

  const submitComment = async () => {
    if (!form.content.trim()) return;

    form.post(`/posts/${props.postId}/comments`, {
      onSuccess: () => {
        emit('comment-added', {
          id: Math.random(),
          content: form.content,
          user: props.currentUser,
          created_at: new Date().toISOString(),
        });

        form.reset('content');
      },
    });
  };

  const editComment = async (comment) => {
    const updatedContent = prompt('Edit your comment:', comment.content);
    if (updatedContent !== null && updatedContent.trim() !== '') {
      await router.put(`/comments/${comment.id}`, {
        content: updatedContent,
      });

      emit('comment-edited', { id: comment.id, content: updatedContent });
    }
  };

  const deleteComment = async (comment) => {
    if (confirm('Are you sure you want to delete this comment?')) {
      await router.delete(`/comments/${comment.id}`);

      emit('comment-deleted', comment.id);
    }
  };

  const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString();
  };
  </script>
