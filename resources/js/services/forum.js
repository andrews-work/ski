import axios from 'axios';

const apiClient = axios.create({
  baseURL: '/forums',
  withCredentials: true,
  headers: {
    'Content-Type': 'application/json',
  },
});

export default {
  // Fetch all posts
  getPosts() {
    return apiClient.get('/');
  },

  // Fetch a single post
  getPost(id) {
    return apiClient.get(`/${id}`);
  },

  // Create a new post
  createPost(post) {
    return apiClient.post('/', post);
  },

  // Update a post
  updatePost(id, post) {
    return apiClient.put(`/${id}`, post);
  },

  // Delete a post
  deletePost(id) {
    return apiClient.delete(`/${id}`);
  },
};
