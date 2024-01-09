<!-- PreviewSection.vue -->
<template>
  <div class="w-[50%] p-4 bg-gray-600 sticky top-0 px-8">
    <!-- Use a container with a fixed aspect ratio (e.g., 8.5x11 for letter-sized paper) -->
    <div class="bg-white p-4 rounded shadow aspect-ratio-container overflow-auto relative">
      <h2 class="text-lg font-semibold mb-2">Preview</h2>
      <!-- Display the content from the Filling section -->
      <pre>{{ JSON.stringify(cvData, null, 2) }}</pre>

      <!-- Indicator for multiple pages (adjust the arrow and styles as needed) -->
      <div v-if="isOverflowing" class="absolute bottom-0 left-1/2 transform -translate-x-1/2">
        <div class="arrow-down"></div>
      </div>
      
      <button @click="exportToPDF" class="btn mt-4">Export to PDF</button>
    </div>
    <span id="prolonger">This is the text that is supposed to help the div to display at full width and I think its going to work well</span>
  </div>
</template>

<script>
import { ref, watch, nextTick } from 'vue';
import { useResumeStore } from '../stores/ResumeStore';

export default {
  setup() {
    const resumeStore = useResumeStore();
    const isOverflowing = ref(false);

    // Check if the content overflows the paper container
    const checkOverflow = () => {
      const container = document.querySelector('.aspect-ratio-container');
      isOverflowing.value = container.scrollHeight > container.clientHeight;
    };

    // Watch for changes in the content and check for overflow
    watch(
      () => resumeStore.cvData,
      () => {
        nextTick(checkOverflow);
      }
    );

    const exportToPDF = () => {
      // Implement PDF export logic here using resumeStore.cvData
      alert('Export to PDF clicked!');
    };

    return { cvData: resumeStore.cvData, exportToPDF, isOverflowing };
  },
};
</script>

<style>
/* Add your styles here */
/* Example styles (you can customize these) */
#prolonger {
    visibility: hidden;
  }
.aspect-ratio-container {
  aspect-ratio: 8.5 / 11; /* Adjust the aspect ratio based on your paper size preference */
  width: 100%; /* Ensure the container takes up 100% width */
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

/* Example styles for the arrow indicator (customize as needed) */
.arrow-down {
  border: solid black;
  border-width: 0 3px 3px 0;
  display: inline-block;
  padding: 3px;
  transform: rotate(45deg);
}
</style>
