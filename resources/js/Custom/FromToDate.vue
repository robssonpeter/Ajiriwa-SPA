<!-- FromToDate.vue -->
<template>
    <div class="my-2">
      <span class="text-gray-500 text-md font-bold">{{ label }} <small class="text-green-400">Leave blank for any date</small></span>
      <div class="sm:flex rounded-lg shadow-sm">
        <input
          type="date"
          v-model="from"
          @change="controlDate('from')"
          class="text-gray-500 py-2 self-center px-4 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
        />
        <span class="py-2 px-4 inline-flex items-center min-w-fit w-full border border-gray-200 bg-gray-50 text-sm text-gray-500 -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:w-auto sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg dark:bg-gray-700 dark:border-gray-700 dark:text-gray-400">
          to
        </span>
        <input
          type="date"
          v-model="to"
          @change="controlDate('to')"
          class="text-gray-500 py-2 self-center px-4 pe-11 block w-full border-gray-200 shadow-sm -mt-px -ms-px first:rounded-t-lg last:rounded-b-lg sm:first:rounded-s-lg sm:mt-0 sm:first:ms-0 sm:first:rounded-se-none sm:last:rounded-es-none sm:last:rounded-e-lg text-sm relative focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600"
        />
      </div>
    </div>
  </template>
  
  <script>
  import { ref, inject, onBeforeMount } from 'vue';
  
  export default {
    name: 'FromToDate',
    props: ['label'],
    data(){
        return {
            from: '',
            to: ''
        }
    },
    methods: {
        controlDate(changed = 'from'){
            if (changed === 'from') {
            if (!this.to) {
                this.to = this.from;
            }
            }
            // You can emit an event here if needed
            this.$emit('changed', this.$data);
        }
    }
  };
  </script>
  