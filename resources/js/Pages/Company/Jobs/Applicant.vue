<template>
    <employer-layout title="View Applicant">
        <div class="flex flex-row gap-2 text-gray-500 p-4 px-6">
            <img src="https://placeimg.com/200/200/any" class="h-14 w-14 rounded-full" alt="">
            <div class="flex flex-col flex-grow">
                <span class="text-2xl font-bold">Peter Mgembe</span>
                <span>Applied for <strong>Accountant</strong> on August 2, 2021</span>
            </div>
            <div class="flex flex-row gap-2">
                <button class="bg-white border border-gray-400 rounded-md p-1 self-center">Disqualify</button>
                <button class="bg-green-500 text-white border border-gray-400 rounded-md p-1 self-center">Schedule Interview</button>
            </div>
        </div>
        <section class="grid grid-cols-6 gap-2 px-4">
            <div class="col-span-4 shadow-md bg-white rounded-md text-gray-500">
                <div class="border-b border-gray-300 p-4">
                    <span class="text-xl">Applicant Information</span>
                </div>
                <div class="p-4 grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <span class="text-gray-400">Application for</span>
                        <span class="text-gray-500 font-bold">Backend Developer</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-400">Email Address</span>
                        <span class="text-gray-500 font-bold">Peterrobsson@gmail.com</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-400">Salary Expectation</span>
                        <span class="text-gray-500 font-bold">Tsh. 2,000,000</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-400">Phone</span>
                        <span class="text-gray-500 font-bold">0759867315</span>
                    </div>
                    <div class="flex flex-col col-span-2 pt-2">
                        <span class="text-gray-400">About</span>
                        <span class="text-gray-500">Peter is a very creative person looking to establish a new connection and make the
                        most out of his career. Over the past 5 years he's worked to develop different systems that have been impactfull for the society
                        and manage to capture many customers that were once not very good in deed</span>
                    </div>
                    <div class="flex flex-col col-span-2 pt-2">
                        <span class="text-gray-400">Attachments</span>
                        <div class="border border-gray-300 rounded-md text-gray-500">
                            <section class="flex flex-row border-b gap-2 border-gray-300 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <span class="flex-grow">Birth Certificate</span>
                                <span class="text-green-400 cursor-pointer font-bold">View</span>
                            </section>
                            <section class="flex flex-row border-b gap-2 border-gray-300 p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                                <span class="flex-grow">Birth Certificate</span>
                                <span class="text-green-400 cursor-pointer font-bold">View</span>
                            </section>
                        </div>
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
                            <h3 class="font-semibold text-md mb-1">Package Booked</h3>
                            <p class="leading-tight text-justify w-full">
                                21 July 2021, 04:30 PM
                            </p>
                        </div>
                    </div>

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
                            <h3 class="font-semibold text-md mb-1">Out for Delivery</h3>
                            <p class="leading-tight text-justify">
                                22 July 2021, 01:00 PM
                            </p>
                        </div>
                    </div>

                    <div class="flex md:contents">
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
                    </div>

                    <div class="flex md:contents">
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
                    </div>

                </div>
            </div>
        </section>
    </employer-layout>
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
    export default {
        name: "Applicant",
        components: {
            EmployerLayout, Head, Input, Loader, Link, TimeAgo, Dropdown, DropdownLink, Menu, MenuButton, MenuItems, MenuItem
        }
    }
</script>

<style scoped>

</style>
