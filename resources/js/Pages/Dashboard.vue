<template>
    <app-layout title="Dashboard">
        <!--<template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>-->

        <div class="">
            <div class="">
                <div class="bg-white overflow-hidden shadow-xl ">
                    <div class="h-40 pt-32 pb-4 px-4 px-2 lg:px-4 z-40" id="banner" >
                        <div class="max-w-7xl mx-auto -mt-24 px-4 sm:px-6 px-2 sm:px-4 md:px-4 lg:px-4 xl:px-12">
                            <h1 class=" text-white font-bold text-4xl mb-3">Find a job</h1>
                            <div class="sm:flex sm:flex-row gap-10 space-y-6 sm:space-y-0">
                                <div class="flex-grow">
                                    <input class=" w-full border-2 rounded p-3 text-2xl text-gray-500" type="text" placeholder="Job Title">
                                </div>
                                <div class=" flex-grow">
                                    <input class=" w-full border-2 rounded p-3 text-2xl" type="text" placeholder="Location">
                                </div>
                                <button class="w-full sm:w-auto rounded py-3 sm:px-5 text-2xl bg-green-500 hover:bg-green-600 text-white">

                                    <span class="hidden sm:block">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 md:w-6 place-self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </span>
                                    <span class="uppercase block sm:hidden">Search</span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <section class="text-gray-500 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <span class="text-3xl ml-4">{{ $page.props.greeting }}, {{ $page.props.candidate.first_name }}</span>

                <div class="bg-white shadow-md p-4">
                    Jobs for you
                </div>
            </section>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Welcome from '@/Jetstream/Welcome.vue';
    import Dropdown from "@/Jetstream/Dropdown";
    import DropdownLink from "@/Jetstream/DropdownLink";
    //import carousel from 'vue-owl-carousel';

    export default {
        components: {
            AppLayout,
            Welcome,
            Dropdown,
            DropdownLink
            //carousel
        },
    }
</script>
<style scoped>
    #banner {
        /*background-image: url('https://www.ajiriwa.net/images/banner-home-01.jpg');*/
        /* background-color: aqua; */
        /* background-size: cover; */
        /* height: 7in; */
        z-index: initial;
        background-color: #dbe4e5;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E");
    }
</style>
