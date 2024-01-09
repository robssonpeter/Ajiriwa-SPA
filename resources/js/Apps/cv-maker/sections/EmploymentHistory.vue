<!-- EmploymentHistory.vue -->
<template>
    <div class="mb-4 p-4">
      <h2 class="text-lg font-semibold mb-2">Employment History</h2>
      <div v-for="(experience, index) in employmentHistory" :key="index" class="mb-4">
        <h3 class="text-md font-semibold mb-2">Experience {{ index + 1 }}</h3>
        <input v-model="experience.jobTitle" placeholder="Job Title" :class="`${input} w-full mb-2`" />
        <input v-model="experience.employerName" placeholder="Employer Name" :class="`${input} w-full mb-2`" />
        <div class="flex">
          <input v-model="experience.startDate" placeholder="Start Date (MM/YYYY)" :class="`${input} mb-2 flex-1 mr-2`" />
          <input v-model="experience.endDate" placeholder="End Date (MM/YYYY)" :class="`${input} mb-2 flex-1 ml-2`" />
        </div>
        <input v-model="experience.city" placeholder="City" :class="`${input} w-full mb-2`" />
        <textarea v-model="experience.description" placeholder="Description" :class="`${input} textarea`"></textarea>
      </div>
      <button @click="addExperience" class="btn">Add Experience</button>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import { useResumeStore } from '../stores/ResumeStore.js';
  
  export default {
    setup() {
      const resumeStore = useResumeStore();
  
      const employmentHistory = ref(resumeStore.cvData.employmentHistory);

      const input = ref(resumeStore.input);
  
      const addExperience = () => {
        employmentHistory.value.push({
          jobTitle: '',
          employerName: '',
          startDate: '',
          endDate: '',
          city: '',
          description: '',
        });
  
        resumeStore.updateCvData({ ...resumeStore.cvData, employmentHistory: employmentHistory.value });
      };
  
      return { employmentHistory, addExperience, input };
    },
  };
  </script>
  
  <style>
  /* Add your styles here */
  /* Example styles (you can customize these) */
  .input {
    margin-bottom: 1rem;
    padding: 0.5rem;
    width: 100%;
  }
  
  .textarea {
    margin-bottom: 1rem;
    padding: 0.5rem;
    width: 100%;
    resize: vertical;
  }
  
  .btn {
    background-color: #4caf50;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .btn:hover {
    background-color: #45a049;
  }
  </style>
  