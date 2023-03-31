<template>
    <app-layout title="Dashboard">
        <!--<template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>-->

        <div class="">
            <!-- <div class="">
                <div class="bg-white overflow-hidden shadow-xl ">
                    <div class="md:h-40 pt-32 pb-4 px-4 md:px-2 lg:px-4 z-40" id="banner" >
                        <div class="max-w-7xl mx-auto -mt-24 px-2 sm:px-6  sm:px-4 md:px-2 lg:px-4 xl:px-12">
                            <h1 class=" text-white font-bold text-4xl mb-3">Find a job</h1>
                            <div class="sm:flex sm:flex-row gap-10 space-y-6 sm:space-y-0">
                                <div class="flex-grow">
                                    <input class=" w-full border-1 md:border-2 rounded p-3 text-2xl text-gray-500" type="text" placeholder="Job Title">
                                </div>
                                <div class=" flex-grow">
                                    <input class=" w-full border-1 md:border-2 rounded p-3 text-2xl" type="text" placeholder="Location">
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
            </div> -->
            <section class="text-gray-500 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 md:grid grid-cols-4">
                <Link :href="route('my-resume')">
                    <div class="hover:shadow-lg hover:bg-green-200 rounded-md bg-white shadow-md p-4 hidden md:block border border-green-400 mx-4 text-center flex flex-column"> 
                        <section class="flex flex-col">
                            <span class="text-green-400 font-bold">My Profile</span>   
                            <section class="flex flex">
                                <span class="flex-grow "></span>
                                <span class="mx-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-10 w-10 text-green-400 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </span>
                                <span class="flex-grow"></span>    
                            </section>
                        </section>
                    </div>
                </Link>
                <Link :href="route('jobs.browse')">
                    <div class="hover:shadow-lg hover:bg-green-200 rounded-md bg-white shadow-md p-4 hidden md:block mx-4 text-center flex flex-column border border-green-400">
                        <span class="text-green-400 font-bold">Browse Jobs</span>   
                        <section class="flex">
                            <span class="flex-grow "></span>
                            <span class="mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="h-10 w-10 text-green-400">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                </svg>
                            </span>
                            <span class="flex-grow"></span>    
                        </section>
                    </div>
                </Link>
                <Link :href="route('my-resume.edit')">
                    <div class="hover:shadow-lg hover:bg-green-200 rounded-md bg-white shadow-md p-4 hidden md:block mx-4 text-center flex flex-column border border-green-400">
                        <span class="text-green-400 font-bold">Update Profile</span>   
                        <section class="flex">
                            <span class="flex-grow "></span>
                            <span class="mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-green-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                            </span>
                            <span class="flex-grow"></span>    
                        </section>
                    </div>
                </Link>
                <Link :href="route('my-applications')">
                    <div class="hover:shadow-lg hover:bg-green-200 rounded-md bg-white shadow-md p-4 hidden md:block mx-4 text-center flex flex-column border border-green-400">
                        <span class="text-green-400 font-bold">View My Applications</span>   
                        <section class="flex">
                            <span class="flex-grow "></span>
                            <span class="mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-green-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                </svg>

                            </span>
                            <span class="flex-grow"></span>    
                        </section>
                    </div>
                </Link>
            </section>
            <section class="text-gray-500 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <span class="text-3xl ml-4">{{ $page.props.greeting }}, {{ $page.props.candidate.first_name }}</span>

                <div class="bg-white shadow-md p-4 hidden md:block mx-4">
                    <!-- <span>Jobs for you</span> -->
                    <ul class="md:grid grid-cols-4">
                        <li v-for="job in jobs" class="highlighted text-green-500 font-bold md:col-span-1 border border-gray-300 rounded-md p-2" style="width: 200px; display: block;"><Link :title="job.title" :href="route('jobs.browse')+'#'+job.slug">
                                        <p style="text-align: center; " class="text-sm"><strong>{{ job.title }}</strong></p></Link><div class="job-list-content"><Link :title="job.title" :href="route('jobs.browse')+'#'+job.slug">
                                        <img :src="job.company.logo_url" alt="Sr Financial and Business Consultants" class="bg-white" style="margin-left: auto; margin-right: auto; height: 150px; width:150px; border-radius: 5%;" draggable="false">	</Link>
                                        <div class="clearfix"></div>
                                    </div></li>
                    </ul>
                </div>
                <div class="md:hidden bg-white shadow-md rounded-md mt-2 mx-4" v-for="job in jobs"> 
                    <Link :href="route('jobs.browse')+'#'+job.slug" class="">
                        <section class="flex flex-row mb-2 mt-2">
                            <img :src="job.company.logo_url" class="rounded h-20">
                            <div class="flex flex-col px-4">
                                <span class="font-bold text-green-500 text-md">{{ job.title }}</span>
                                <span class="text-gray-600">{{ job.company.name }}</span>
                                <span class="text-gray-400">{{ job.location }}</span>
                            </div>
                        </section>
                        <span class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-gray-200 text-gray-700 rounded">Full-Time</span>
                        <small class="float-right text-gray-500">3 days ago</small>
                    </Link>
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
    import { Link } from '@inertiajs/inertia-vue3';
    //import carousel from 'vue-owl-carousel';

    export default {
        components: {
            AppLayout,
            Welcome,
            Dropdown,
            DropdownLink,
            Link
            //carousel
        },
        mounted(){
            console.log(this.jobs);
        },
        data(){
            return {
                jobs: this.$page.props.jobs
            }
        }
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
