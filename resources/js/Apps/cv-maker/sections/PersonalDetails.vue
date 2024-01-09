<!-- PersonalDetails.vue -->
<template>
    <div class="mb-4 p-4 bg-white">
    <h2 class="text-lg font-semibold mb-2">Personal Details</h2>

    <!-- Use grid classes to create a two-column layout -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
      <div class="mb-4">
        <label class="block text-sm text-gray-600">Desired Job Title</label>
        <input v-model="details.desiredJobTitle" placeholder="e.g Accountant" :class="`${input}`" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">First Name</label>
        <input v-model="details.firstName" placeholder="" :class="input" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Middle Name</label>
        <input v-model="details.middleName" placeholder="" :class="input" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Last Name</label>
        <input v-model="details.lastName" placeholder="" :class="input" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Email</label>
        <input v-model="details.email" placeholder="" :class="input" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Nationality</label>
        <input v-model="details.nationality" placeholder="" :class="input" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Phone</label>
        <input v-model="details.phone" placeholder="" :class="input" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-600">Address</label>
        <input v-model="details.address" placeholder="" :class="input" />
      </div>
    </div>
  </div>
  </template>
  
  <script>
  import { computed, ref } from 'vue';
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

      const input = ref('border-none bg-gray-200 rounded-md')
  
      return { details, input };
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
  