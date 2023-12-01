<!-- FillingSection.vue -->
<template>
    <div class="flex-1 p-4">
      <PersonalDetails />
      <ProfessionalSummary />
      <EmploymentHistory />
      <Education />
      <!-- ... other sections ... -->
      <CustomSection />
    </div>
  </template>
  
  <script>
  import PersonalDetails from '../sections/PersonalDetails.vue';
  import ProfessionalSummary from '../sections/ProfessionalSummary.vue';
  import EmploymentHistory from '../sections/EmploymentHistory.vue';
  import Education from '../sections/Education.vue';
  import CustomSection from '../sections/CustomSection.vue';
  import { useResumeStore } from '../stores/ResumeStore.js';
  
  export default {
    components: {
      PersonalDetails,
      ProfessionalSummary,
      EmploymentHistory,
      Education,
      CustomSection,
      // ... other sections ...
    },
    setup() {
      const resumeStore = useResumeStore();
  
      return { resumeStore };
    },
  };
  </script>
  
  <style>
  /* Add your styles here */
  </style>
  