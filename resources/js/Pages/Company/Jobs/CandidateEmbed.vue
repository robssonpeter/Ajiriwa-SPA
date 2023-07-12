<template>
        <div class="flex flex-row gap-2 text-gray-500 p-4 px-6">
            <img src="https://placeimg.com/200/200/any" class="h-16 w-16 rounded-full" alt="">
            <div class="flex flex-col flex-grow">
                <span class="text-2xl font-bold">{{ application.candidate.full_name }}</span>
                <section class="flex">
                    <div class="flex mr-4">
                        <i class="bx bx-envelope mr-2 text-green-500 self-center"></i><span class="text-gray-500 self-center">{{ application.candidate.email }}</span>
                    </div>
                    <div class="flex">
                        <i class="bx bx-phone mr-2 text-green-500 self-center"></i><span class="text-gray-500 self-center">{{ application.candidate.phone }}</span>
                    </div>
                        
                </section>
            </div>
        </div>
        <div class="overflow-y-auto md:max-h-85 lg:max-h-90 xl:max-h-95" style="max-height: 30rem;">
            <Transition>
                <profile-embed v-if="show_profile" :candidate="application.candidate" :show_profile="show_profile"></profile-embed>
            </Transition>
            <Transition>
            <section v-if="!show_profile" class="grid grid-cols-6 gap-2 px-4">
                <div class="col-span-4 shadow-md sticky top-0 bg-white rounded-md text-gray-500">
                    <div class="border-b border-gray-300 p-4">
                        <span class="text-xl font-bold">Applicant Information</span>
                    </div>
                    <div class="p-4 grid grid-cols-2 gap-2">
                        <!-- <div class="flex flex-col">
                            <span class="text-gray-400">Application for</span>
                            <span class="text-gray-500 font-bold">{{ job_title }}</span>
                        </div> -->
                        <!-- <div class="flex flex-col">
                            <span class="text-gray-400">Email Address</span>
                            <span class="text-gray-500 font-bold">{{ application.candidate.email }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-gray-400">Phone</span>
                            <span class="text-gray-500 font-bold">{{ application.candidate.phone }}</span>
                        </div> -->
                        <div class="flex flex-col">
                            <span class="text-gray-400">Salary Expectation</span>
                            <span class="text-gray-500 font-bold">Tsh. 2,000,000</span>
                        </div>
                        
                        <div class="flex flex-col col-span-2 pt-2">
                            <span class="text-gray-500 font-bold">Cover Letter</span>
                            <span class="text-gray-500" v-html="application.cover_letter"></span>
                        </div>
                        <div class="flex flex-col col-span-2 pt-2" v-if="application.attachments.length">
                            <span class="text-gray-400">Attachments</span>
                            <div class="border border-gray-300 rounded-md text-gray-500">
                                <section class="flex flex-row border-b gap-2 border-gray-300 p-2" v-for="attachment in application.attachments">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                    </svg>
                                    <span class="flex-grow">{{ attachment.name }}</span>
                                    <a class="text-green-400 cursor-pointer font-bold" :href="attachment.media_url" target="_blank">View</a>
                                </section>
                            </div>
                        </div>
                        <div class="flex flex-col col-span-2 pt-2" v-if="application.screening_responses.length">
                            <span class="text-lg font-bold mb-2">Screening Questions</span>
                            <section class="flex pb-2" v-for="response, index in application.screening_responses">
                                <span class="self-start mr-2 font-bold">{{ index+1 }}. </span>
                                <div>
                                    <span class="self-center mr-2">{{ response.question }}</span>
                                    <span class="bg-green-200 p-1 rounded-md self-center">{{ response.response }}</span>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="container shadow-md col-span-2 bg-white rounded-md text-gray-500">
                    <div class="border-b border-gray-300 p-4">
                        <span class="text-xl">Timeline</span>
                    </div>
                    <div class="flex flex-col md:grid grid-cols-12 text-gray-50 text-sm">

                        <div class="flex md:contents">
                            <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                                <div class="h-full w-6 flex items-center justify-center">
                                    <div class="h-full w-1 bg-green-500 pointer-events-none"></div>
                                </div>
                                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-green-500 shadow text-center">
                                    <i class="fas fa-check-circle text-white"></i>
                                </div>
                            </div>
                            <div class="bg-green-500 col-start-4 col-end-12 p-2 rounded-xl my-4 mr-auto shadow-md w-full">
                                <h3 class="font-semibold text-md mb-1">Applied</h3>
                                <p class="leading-tight text-justify w-full">
                                    {{ application.application_date_time }}
<!--                                    21 July 2021, 04:30 PM-->
                                </p>
                            </div>
                        </div>

                        <div class="flex md:contents" v-for="log in application.logs">
                            <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                                <div class="h-full w-6 flex items-center justify-center">
                                    <div :class="'h-full w-1 '+logColor(log)+' pointer-events-none'"></div>
                                </div>
                                <div :class="'w-6 h-6 absolute top-1/2 -mt-3 rounded-full '+logColor(log)+' shadow text-center'">
                                    <i class="fas fa-check-circle text-white"></i>
                                </div>
                            </div>
                            <div :class="logColor(log)+' col-start-4 col-end-12 p-2 rounded-xl my-4 mr-auto shadow-md w-full'">
                                <h3 class="font-semibold text-md mb-1">{{ log.label }}</h3>
                                <p class="leading-tight text-justify">
                                    {{ log.log_date }}
<!--                                    22 July 2021, 01:00 PM-->
                                </p>
                            </div>
                        </div>

<!--                        <div class="flex md:contents">
                            <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                                <div class="h-full w-6 flex items-center justify-center">
                                    <div class="h-full w-1 bg-red-500 pointer-events-none"></div>
                                </div>
                                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-red-500 shadow text-center">
                                    <i class="fas fa-times-circle text-white"></i>
                                </div>
                            </div>
                            <div class="bg-red-500 col-start-4 col-end-12 p-2 rounded-xl my-4 mr-auto shadow-md w-full">
                                <h3 class="font-semibold text-md mb-1 text-gray-50">Cancelled</h3>
                                <p class="leading-tight text-justify">
                                    Customer cancelled the order
                                </p>
                            </div>
                        </div>-->

<!--                        <div class="flex md:contents">
                            <div class="col-start-2 col-end-4 mr-10 md:mx-auto relative">
                                <div class="h-full w-6 flex items-center justify-center">
                                    <div class="h-full w-1 bg-gray-300 pointer-events-none"></div>
                                </div>
                                <div class="w-6 h-6 absolute top-1/2 -mt-3 rounded-full bg-gray-300 shadow text-center">
                                    <i class="fas fa-exclamation-circle text-gray-400"></i>
                                </div>
                            </div>
                            <div class="bg-gray-300 col-start-4 col-end-12 p-2 rounded-xl my-4 mr-auto shadow-md w-full">
                                <h3 class="font-semibold text-md mb-1 text-gray-400">Delivered</h3>
                                <p class="leading-tight text-justify">

                                </p>
                            </div>
                        </div>-->

                    </div>
                </div>
            </section>
            </Transition>
        </div>
</template>

<script>
    import EmployerLayout from "@/Layouts/EmployerLayout";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Input from "@/Jetstream/Input";
    import Loader from "@/Custom/Loader";
    import TimeAgo from 'vue3-timeago';
    import Dropdown from "@/Jetstream/Dropdown";
    import DropdownLink from "@/Jetstream/DropdownLink";
    import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
    import ProfileEmbed from "@/Custom/Resume/ProfileEmbed";
    import ApplicationStatus from "@/Custom/Job/ApplicationStatus";
    export default {
        name: "Applicant",
        props: {
            application: {
                type: Object
            },
            statuses: {
                type: Array
            },
            job_title: {
                type: String
            },
            show_profile: {
                type: Boolean
            },
            log_descriptions: {
                type: Array
            }
        },
        components: {
            EmployerLayout, Head, Input, Loader, Link, TimeAgo, Dropdown, DropdownLink, Menu, MenuButton, MenuItems, MenuItem, ProfileEmbed, ApplicationStatus
        },
        computed:{
            logColor(){
                return log => {
                    //console.log(log);
                    return this.log_descriptions[log.status].color
                }
            }
        },
        methods: {
            statusUpdated(change){
                console.log('status has changed')
                this.$emit('status_changed', change);
            }
        }
    }
</script>

<style scoped>

    .v-enter-active,
    .v-leave-active {
        transition: opacity 0.3s ease;
    }

    .v-enter-from,
    .v-leave-to {
        opacity: 0;
    }
    @media (min-width: 1280px) {
        .xl\:max-h-95 {
            height: 40rem;
        }
    }
    @media (min-width: 1024px) {
        .lg\:max-h-90 {
            height: 30rem;
        }
    }
    @media (min-width: 768px) {
        .md\:max-h-85 {
            height: 30rem;
        }
    }
</style>
