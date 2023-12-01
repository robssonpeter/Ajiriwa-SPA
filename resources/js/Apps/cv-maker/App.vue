<template>
    <div class="flex h-screen bg-gray-100">
      <FillingSection />
      <PreviewSection />
    </div>
  </template>
  
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
  