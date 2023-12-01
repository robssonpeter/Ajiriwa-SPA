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
  }),
  actions: {
    updateCvData(newData) {
      this.cvData = newData;
    },
  },
});
