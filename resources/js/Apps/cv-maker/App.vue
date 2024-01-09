<template>
    <div class="grid grid-cols-2 h-screen bg-gray-100">
      <FillingSection />
      <PreviewSection />
    </div>
  </template>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.9/tailwind.min.css" integrity="sha512-SvJR34InARUfJb279ipE/gjQqX11MDKaly9MNb0vevuWQJmZ23UH7F/65ScEsvLI+myKGbdfA1En82wVSCHQ8A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script>
  import { ref, onMounted } from 'vue';
  import { useResumeStore } from './stores/ResumeStore.js';
  import FillingSection from './components/FillingSection.vue';
  import PreviewSection from './components/PreviewSection.vue';
  
  export default {
    components: {
      FillingSection,
      PreviewSection,
    },
    setup() {
      const resumeStore = useResumeStore();
  
      // Fetch initial data or perform any other setup logic
  
      onMounted(() => {
        // Fetch initial data or perform any other setup logic
      });
  
      return { resumeStore };
    },
  };
  </script>
  
  <style>
  /* Add your global styles here */
  </style>
  