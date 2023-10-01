<template>
    <div>
      <canvas ref="chart" width="400" height="200"></canvas>
    </div>
  </template>
  
  <script>
  import { Line } from 'vue-chartjs';
  
  export default {
    extends: Line,
    props: ['chartData'],
  
    mounted() {
      this.renderChart(this.chartData, {
        responsive: true,
        maintainAspectRatio: false,
      });
    },
  };
  </script>
  
  <style scoped>
  /* Add any component-specific styles here */
  </style>
  