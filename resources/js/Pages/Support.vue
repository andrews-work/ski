<template>
    <Header :can-login="canLogin" :can-register="canRegister" />
  <div>
    <h1>Support Page</h1>
  </div>
</template>

<script setup>
    import Header from '@/Components/Header.vue';
</script>
