<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '@/Components/Header.vue';
import Section1 from '@/Sections/Section1.vue';
import Section2 from '@/Sections/Section2.vue';
import Section3 from '@/Sections/Section3.vue';


defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
});

function handleImageError() {
  document.getElementById('screenshot-container')?.classList.add('!hidden');
  document.getElementById('docs-card')?.classList.add('!row-span-1');
  document.getElementById('docs-card-content')?.classList.add('!flex-row');
  document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
  <Head title="Welcome" />
    <div class="w-full">
      <!-- Header section at the top -->
      <Header :can-login="canLogin" :can-register="canRegister" />

      <!-- Main content area -->
      <main class="bg-grey-900">
        <Section3 />
        <Section2 />
        <Section1 />
      </main>

      <!-- Footer section at the bottom -->
      <footer class="py-16 text-sm text-center text-black dark:text-white/70">
        Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
      </footer>
    </div>
</template>
