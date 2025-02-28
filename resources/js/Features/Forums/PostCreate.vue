<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <h1 class="mb-4 text-2xl font-bold">Create New Post</h1>
        <form @submit.prevent="createPost">
          <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
            <input
              type="text"
              v-model="form.title"
              id="title"
              class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              required
            />
          </div>
          <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
            <textarea
              v-model="form.content"
              id="content"
              class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              required
            ></textarea>
          </div>
          <div class="mb-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Category:</label>
            <select
              v-model="form.category"
              id="category"
              class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
              required
            >
              <option value="" disabled>Select a category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </option>
            </select>
          </div>
          <div class="flex justify-end gap-2">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
            >
              Create Post
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { router } from '@inertiajs/vue3';

  const props = defineProps({
    show: Boolean,
    categories: Array,
  });

  const emit = defineEmits(['close']);

  const form = ref({
    title: '',
    content: '',
    category: '',
  });

  const createPost = async () => {
  console.log('Submit button pressed!');
  console.log('Form data before submission:', form.value);

  form.value.category_id = String(form.value.category);
  delete form.value.category;

  try {
    await router.post('/forums', form.value, {
      onSuccess: () => {
        console.log('Post created successfully!');
        emit('close');
        form.value = { title: '', content: '', category: '' };
      },
      onError: (errors) => {
        console.error('Validation errors:', errors);
      },
    });
  } catch (error) {
    console.error('Error creating post:', error);
  }
};

  const closeModal = () => {
    emit('close');
  };
  </script>
