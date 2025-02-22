<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});

// For toggling the mobile menu
const isMobileMenuOpen = ref(false);
</script>

<template>
  <header class="w-full py-6 text-black bg-white">
    <div class="flex items-center justify-between max-w-5xl mx-auto">
      <!-- Left: Logo -->
      <div class="flex-shrink-0">
        <Link :href="route('home')" class="text-xl font-bold">
          <span class="text-black">Laravel</span>
        </Link>
      </div>

      <!-- Hamburger Icon (only visible on mobile) -->
      <div class="lg:hidden">
        <button @click="isMobileMenuOpen = !isMobileMenuOpen" class="text-black focus:outline-none">
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
      </div>

      <!-- Center: Navigation Links (visible on desktop, toggleable on mobile) -->
      <nav class="justify-center flex-1 hidden space-x-6 lg:flex">
        <Link
          :href="route('pricing')"
          class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        >
          Pricing
        </Link>
        <Link
          :href="route('features')"
          class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        >
          Features
        </Link>
        <Link
          :href="route('news')"
          class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        >
          News & Stories
        </Link>
        <Link
          :href="route('support')"
          class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        >
          Help & Support
        </Link>
      </nav>

      <!-- Right: Login/Register or Dashboard -->
      <div class="items-center hidden space-x-4 lg:flex">
        <Link
          v-if="!$page.props.auth.user"
          :href="route('login')"
          class="px-3 py-2 text-purple-600 rounded-md border border-purple-600 hover:text-[#FF2D20] transition"
        >
          Log in
        </Link>

        <Link
          v-if="!$page.props.auth.user"
          :href="route('register')"
          class="px-3 py-2 text-white bg-blue-400 rounded-md hover:text-[#FF2D20] transition"
        >
          Register
        </Link>

        <Link
          v-if="$page.props.auth.user"
          :href="route('dashboard')"
          class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        >
          Dashboard
        </Link>
      </div>
    </div>
  </header>

  <!-- Mobile Menu (only visible when toggled on) -->
  <div v-if="isMobileMenuOpen" class="absolute left-0 w-full bg-white shadow-lg lg:hidden top-20">
    <nav class="flex flex-col items-center py-4 space-y-4">
      <Link
        :href="route('pricing')"
        class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        @click="isMobileMenuOpen = false"
      >
        Pricing
      </Link>
      <Link
        :href="route('features')"
        class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        @click="isMobileMenuOpen = false"
      >
        Features
      </Link>
      <Link
        :href="route('news')"
        class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        @click="isMobileMenuOpen = false"
      >
        News & Stories
      </Link>
      <Link
        :href="route('support')"
        class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
        @click="isMobileMenuOpen = false"
      >
        Help & Support
      </Link>

      <!-- Right: Login/Register or Dashboard (Mobile version) -->
      <div class="flex flex-col items-center mt-4 space-y-4">
        <Link
          v-if="!$page.props.auth.user"
          :href="route('login')"
          class="px-3 py-2 text-purple-600 rounded-md border border-purple-600 hover:text-[#FF2D20] transition"
          @click="isMobileMenuOpen = false"
        >
          Log in
        </Link>

        <Link
          v-if="!$page.props.auth.user"
          :href="route('register')"
          class="px-3 py-2 text-white bg-blue-400 rounded-md hover:text-[#FF2D20] transition"
          @click="isMobileMenuOpen = false"
        >
          Register
        </Link>

        <Link
          v-if="$page.props.auth.user"
          :href="route('dashboard')"
          class="px-3 py-2 text-black hover:text-[#FF2D20] transition"
          @click="isMobileMenuOpen = false"
        >
          Dashboard
        </Link>
      </div>
    </nav>
  </div>
</template>
