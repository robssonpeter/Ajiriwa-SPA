<!-- PersonalDetails.vue -->
<template>
    <div class="mb-4 p-4 bg-white">
      <h2 class="text-lg font-semibold mb-2">Personal Details</h2>
  
      <!-- Use flex and flex-wrap classes for responsive layout -->
      <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 lg:w-1/2 mb-4 md:pr-2 lg:pr-2">
          <input v-model="details.desiredJobTitle" placeholder="Desired Job Title" class="input" />
        </div>
        <div class="w-full md:w-1/2 lg:w-1/2 mb-4 md:pl-2 lg:pl-2">
          <input v-model="details.firstName" placeholder="First Name" class="input" />
        </div>
        <div class="w-full md:w-1/2 lg:w-1/2 mb-4 md:pr-2 lg:pr-2">
          <input v-model="details.middleName" placeholder="Middle Name" class="input" />
        </div>
        <div class="w-full md:w-1/2 lg:w-1/2 mb-4 md:pl-2 lg:pl-2">
          <input v-model="details.lastName" placeholder="Last Name" class="input" />
        </div>
        <div class="w-full md:w-1/2 lg:w-1/2 mb-4 md:pr-2 lg:pr-2">
          <input v-model="details.email" placeholder="Email" class="input" />
        </div>
        <div class="w-full md:w-1/2 lg:w-1/2 mb-4 md:pl-2 lg:pl-2">
          <input v-model="details.nationality" placeholder="Nationality" class="input" />
        </div>
        <div class="w-full md:w-1/2 lg:w-1/2 mb-4 md:pr-2 lg:pr-2">
          <input v-model="details.phone" placeholder="Phone" class="input" />
        </div>
        <div class="w-full md:w-1/2 lg:w-1/2 mb-4 md:pl-2 lg:pl-2">
          <input v-model="details.address" placeholder="Address" class="input" />
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { computed } from 'vue';
  import { useResumeStore } from '../stores/ResumeStore.js';
  
  export default {
    setup() {
      const resumeStore = useResumeStore();
  
      const details = computed({
        get: () => resumeStore.cvData.personalDetails,
        set: (newValue) => {
          resumeStore.updateCvData({ ...resumeStore.cvData, personalDetails: newValue });
        },
      });
  
      return { details };
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
  </style>
  