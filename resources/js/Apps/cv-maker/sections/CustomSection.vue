<!-- Education.vue -->
<template>
    <div class="mb-4">
      <h2 class="text-lg font-semibold mb-2">Education</h2>
      <div v-for="(edu, index) in educations" :key="index" class="mb-4">
        <h3 class="text-md font-semibold mb-2">Education {{ index + 1 }}</h3>
        <input v-model="edu.school" placeholder="School" class="input" />
        <input v-model="edu.degree" placeholder="Degree" class="input" />
        <input v-model="edu.startDate" placeholder="Start Date (MM/YYYY)" class="input" />
        <input v-model="edu.endDate" placeholder="End Date (MM/YYYY)" class="input" />
        <textarea v-model="edu.description" placeholder="Description" class="textarea"></textarea>
      </div>
      <button @click="addEducation" class="btn">Add Education</button>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { useResumeStore } from '../stores/ResumeStore.js';
  
  export default {
    setup() {
      const resumeStore = useResumeStore();
  
      const educations = ref(resumeStore.cvData.education);
  
      const addEducation = () => {
        educations.value.push({
          school: '',
          degree: '',
          startDate: '',
          endDate: '',
          description: '',
        });
  
        resumeStore.updateCvData({ ...resumeStore.cvData, education: educations.value });
      };
  
      return { educations, addEducation };
    },
  };
  </script>
  
  <style>
  /* Add your styles here */
  </style>
  