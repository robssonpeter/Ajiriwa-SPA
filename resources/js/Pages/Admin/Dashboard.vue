<template>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />

    <div class="flex">
        <aside class="h-screen sticky top-0">
            <section class="h-16 align-middle shadow-md pt-2">
                <Link :href="'/dashboard'" class="flex space-x-2 place-self-center">
                    <span class="sr-only">Workflow</span>
                    <!-- <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt=""> -->
                    <img class="h-8 w-auto sm:h-10" :src="route('root')+'/images/ajiriwa-new-logo.png'" alt="">
                    <span class=" self-center text-2xl font-bold text-gray-500">Ajiriwa.net</span>
                </Link>
            </section>
            <ul class="flex flex-col py-4">
                <li>
                    <Link :href="route('dashboard')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-home"></i></span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('company.candidates.browse')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-search"></i></span>
                        <span class="text-sm font-medium">Search Candidates</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('company.jobs.index')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-collection"></i></span>
                        <span class="text-sm font-medium">Manage Jobs</span>
                    </Link>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-chat"></i></span>
                        <span class="text-sm font-medium">Chat</span>
                    </a>
                </li>
                <li>
                    <Link :href="route('my-company.customize')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-user"></i></span>
                        <span class="text-sm font-medium">Company Profile</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('company.email-templates')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-envelope"></i></span>
                        <span class="text-sm font-medium">Email Templates</span>
                    </Link>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-bell"></i></span>
                        <span class="text-sm font-medium">Notifications</span>
                        <span class="ml-auto mr-6 text-sm bg-red-100 rounded-full px-3 py-px text-red-500">5</span>
                    </a>
                </li>
                <li>
                    <a href="#" @click.prevent="$inertia.post(route('logout'))" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-log-out"></i></span>
                        <span class="text-sm font-medium">Logout</span>
                    </a>
                </li>
            </ul>
        </aside>

        <main class="w-full">
            <div class="h-16 bg-white shadow-md z-50 sticky top-0">
                <div class="flex space-x-1 px-4 pt-4">
                    <span class="flex-grow"></span>
                    <p class="self-center float-right text-gray-400">Balance: <span class="text-green-400 font-weight-bold cursor-pointer" title="Ajiriwa Balance" @click="balance_modal = true">TZS 1,000,000.00</span></p>
                </div>

                <ajiriwa-balance :show_modal="balance_modal"></ajiriwa-balance>
                
            </div>
            <div class="z-40 px-4 ">
                <section class="flex flex-row py-3">
                    <h1 class="flex-grow self-center text-2xl text-gray-500">Overview</h1>
                    <button class="bg-green-400 p-2 text-white"><Link :href="route('company.post-job')">Post a Job</Link></button>
                </section>

                <section class="grid grid-cols-4 gap-2">
                    <div class="bg-grey-after-transparency gap-y-4 text-gray-500 border border-gray-200 rounded-md shadow-md col-span-1 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-2xl">{{ $page.props.job_views}}</span>
                            <span>Total Job views</span>
                        </div>
                        <Button class="bg-green-400 hover:bg-green-500"><Link :href="route('company.jobs.index')">Manage Jobs</Link></Button>
                    </div>
                    <div class="bg-grey-after-transparency text-gray-500 border border-gray-200 rounded-md shadow-md col-span-1 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-2xl">{{ $page.props.total_applications }}</span>
                            <span>Total Applications</span>
                        </div>
                        <Button class="bg-green-400 hover:bg-green-500">Manage Jobs</Button>
                    </div>
                    <div class="bg-grey-after-transparency text-gray-500 border border-gray-200 rounded-md shadow-md col-span-1 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-2xl">{{ $page.props.active_jobs }}</span>
                            <span>Active Jobs</span>
                        </div>
                        <Button class="bg-green-400 hover:bg-green-500">Manage Jobs</Button>
                    </div>
                    <div class="bg-grey-after-transparency text-gray-500 border border-gray-200 rounded-md shadow-md col-span-1 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="text-2xl">{{ $page.props.pending_companies }}</span>
                            <span>Pending Verifications</span>
                        </div>

                        <Link :href="route('admin.company.verify')" class="bg-green-400 upper-case hover:bg-green-500 text-white p-1 rounded-md">Go to Verifications</Link>
                    </div>
                </section>
                <section class="grid grid-cols-4 gap-2 mt-2 text-gray-500">
                    <div class="col-span-2 shadow-md rounded-md border-t border-gray-2 mt-2">
                        <section class="border-b border-gray-200 p-2">
                            <span class="text-2xl">Recent Applicants</span>
                        </section>
                        <section class="p-2">
                            <div class="flex flex-col py-2 border-b border-gray-200" v-for="application in $page.props.recent_applications">
                                <span class="text-green-400 font-bold cursor-pointer">{{ application.candidate.full_name }}</span>
                                <span>{{ application.title }}</span>
                            </div>
<!--                            <div class="flex flex-col py-2 border-b border-gray-200">
                                <span class="text-green-400 font-bold cursor-pointer">Ntakandi karavina</span>
                                <span>Accountant</span>
                            </div>
                            <div class="flex flex-col py-2 border-b border-gray-200">
                                <span class="text-green-400 font-bold cursor-pointer">Ntakandi karavina</span>
                                <span>Accountant</span>
                            </div>
                            <div class="flex flex-col py-2 border-b border-gray-200">
                                <span class="text-green-400 font-bold cursor-pointer">Ntakandi karavina</span>
                                <span>Accountant</span>
                            </div>-->
                        </section>
                    </div>
                    <div class="col-span-2 shadow-md rounded-md border-t border-gray-2 mt-2">
                        <section class="border-b border-gray-200 p-2">
                            <span class="text-2xl">Recent Visitors</span>
                        </section>
                        <section class="p-2">
                            <div class="flex flex-col py-2 border-b border-gray-200" v-for="application in $page.props.recent_applications">
                                <span class="text-green-400 font-bold cursor-pointer">{{ application.candidate.full_name }}</span>
                                <span>{{ application.title }}</span>
                            </div>
<!--                            <div class="flex flex-col py-2 border-b border-gray-200">
                                <span class="text-green-400 font-bold cursor-pointer">Ntakandi karavina</span>
                                <span>Accountant</span>
                            </div>
                            <div class="flex flex-col py-2 border-b border-gray-200">
                                <span class="text-green-400 font-bold cursor-pointer">Ntakandi karavina</span>
                                <span>Accountant</span>
                            </div>
                            <div class="flex flex-col py-2 border-b border-gray-200">
                                <span class="text-green-400 font-bold cursor-pointer">Ntakandi karavina</span>
                                <span>Accountant</span>
                            </div>-->
                        </section>
                    </div>
                </section>

            </div>
        </main>
    </div>
    <!--<div class="flex items-center fixed w-full top-0 h-20 shadow-md z-50">
        <Link :href="'/'" class="flex space-x-2">
            <span class="sr-only">Workflow</span>
            &lt;!&ndash; <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt=""> &ndash;&gt;
            <img class="h-8 w-auto sm:h-10" :src="route('root')+'/images/ajiriwa-new-logo.png'" alt="">
            <span class=" self-center text-2xl font-bold text-gray-500">Ajiriwa.net</span>
        </Link>
    </div>
    <div class="h-screen flex flex-row mt-20 bg-gray-100 z-40">
        <aside class="flex flex-col w-56 sticky top-20 bg-white overflow-hidden">
            <ul class="flex flex-col py-4">
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-home"></i></span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-music"></i></span>
                        <span class="text-sm font-medium">Music</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-drink"></i></span>
                        <span class="text-sm font-medium">Drink</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-shopping-bag"></i></span>
                        <span class="text-sm font-medium">Shopping</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-chat"></i></span>
                        <span class="text-sm font-medium">Chat</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-user"></i></span>
                        <span class="text-sm font-medium">Profile</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-bell"></i></span>
                        <span class="text-sm font-medium">Notifications</span>
                        <span class="ml-auto mr-6 text-sm bg-red-100 rounded-full px-3 py-px text-red-500">5</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-log-out"></i></span>
                        <span class="text-sm font-medium">Logout</span>
                    </a>
                </li>
            </ul>
        </aside>
        <div>
            <p>hello ther</p>
        </div>

    </div>-->

</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Button  from "@/Jetstream/Button";
    import DialogModal from "@/Jetstream/DialogModal";
    import AjiriwaBalance from "../../Custom/AjiriwaBalance.vue";
    import iziToast from "izitoast";
    import "izitoast/dist/css/iziToast.css";
    export default {
        name: "Customize",
        components: {
            AppLayout, Head, Link, Button, DialogModal, AjiriwaBalance
        },
        mounted(){
            //alert('hello there'+this.$page.props.pending_companies);
            if(this.$page.props.pending_companies){
                iziToast.warning({title: "Alert", message: "You have "+this.$page.props.pending_companies+" companies waiting to be verified"});
            }
        },
        data(){
            return {
                balance_modal: false,
            }
        }
    }
</script>

<style scoped>

</style>
