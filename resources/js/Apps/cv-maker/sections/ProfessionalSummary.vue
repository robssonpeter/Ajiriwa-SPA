<!-- ProfessionalSummary.vue -->
<template>
    <div class="mb-4">
      <h2 class="text-lg font-semibold mb-2">Professional Summary</h2>
      <div ref="quillEditor"></div>
    </div>
  </template>
  
  <script>
  import { onMounted, ref, watch } from 'vue';
  import { useResumeStore } from '../stores/ResumeStore.js';
  
  // Import Quill styles and modules
  import 'quill/dist/quill.snow.css';
  import Quill from 'quill';
  
  export default {
    setup() {
      const resumeStore = useResumeStore();
      const quillEditor = ref(null);
  
      // Initialize Quill editor
      onMounted(() => {
        const quill = new Quill(quillEditor.value, {
          theme: 'snow',
          modules: {
            toolbar: [
              [{ header: [1, 2, false] }],
              ['bold', 'italic', 'underline', 'strike'],
              [{ list: 'ordered' }, { list: 'bullet' }],
              ['link', 'image', 'video'],
            ],
          },
        });
  
        // Watch for changes in the Quill editor and update the store
        watch(
          () => quill.getText(),
          (newText) => {
            resumeStore.updateCvData({ ...resumeStore.cvData, professionalSummary: newText });
          }
        );
      });
  
      return { quillEditor };
    },
  };
  </script>
  
  <style>
  /* Add your styles here */
  /* Example styles (you can customize these) */
  /* You may want to style the Quill editor container */
  #app {
    display: flex;
  }
  
  /* Example styles for the Quill editor */
  .ql-container {
    border: 1px solid #ccc;
    min-height: 150px;
  }
  </style>
  