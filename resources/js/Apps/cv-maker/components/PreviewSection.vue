<!-- PreviewSection.vue -->
<template>
    <div class="flex-1 p-4 bg-gray-200 sticky top-0">
      <h2 class="text-lg font-semibold mb-2">Preview</h2>
      <pre>{{ JSON.stringify(cvData, null, 2) }}</pre>
      <button @click="exportToPDF" class="btn">Export to PDF</button>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { useResumeStore } from '../stores/ResumeStore.js';
  
  export default {
    setup() {
      const resumeStore = useResumeStore();
  
      const exportToPDF = () => {
        // Implement PDF export logic here using resumeStore.cvData
        alert('Export to PDF clicked!');
      };
  
      return { cvData: resumeStore.cvData, exportToPDF };
    },
  };
  </script>
  
  <style>
  /* Add your styles here */
  </style>
  