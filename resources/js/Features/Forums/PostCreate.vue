<template>
    <div>
      <h1>Create New Post</h1>
      <form @submit.prevent="createPost">
        <div>
          <label for="title">Title:</label>
          <input type="text" v-model="form.title" id="title" required />
        </div>
        <div>
          <label for="content">Content:</label>
          <textarea v-model="form.content" id="content" required></textarea>
        </div>
        <div>
          <label for="category">Category:</label>
          <select v-model="form.category" id="category" required>
            <option value="General">General</option>
            <option value="Support">Support</option>
            <option value="Off-Topic">Off-Topic</option>
          </select>
        </div>
        <button type="submit">Create Post</button>
      </form>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import forumService from '@/services/forum';

  const router = useRouter();
  const form = ref({
    title: '',
    content: '',
    category: 'General',
  });

  const createPost = async () => {
    try {
      await forumService.createPost(form.value);
      router.push('/forums');
    } catch (error) {
      console.error('Error creating post:', error);
    }
  };
  </script>
