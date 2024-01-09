import { defineStore } from 'pinia';

export const useResumeStore = defineStore({
  id: 'resume',
  state: () => ({
    cvData: {
      personalDetails: {},
      professionalSummary: '',
      employmentHistory: [],
      education: [],
      websitesAndSocialLinks: [],
      skills: [],
      languages: [],
      customSections: [],
    },
    input: 'border-none bg-gray-200 rounded-md',
  }),
  actions: {
    updateCvData(newData) {
      this.cvData = newData;
    },
  },
});
