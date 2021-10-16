<template>
    <employer-layout title="View Jobs">
        <div class="grid grid-cols-3 gap-3">

            <div class="z-40 min-h-screen col-span-3 my-4 shadow-md ">
                <div class="flex flex-row bg-gray-50 px-4 pt-4">
                    <span class="self-center">Job </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="self-center">Engineering</span>
                </div>
                <div class="flex flex-row px-4 bg-gray-50">
                    <h3 class="text-2xl font-bold pt-2 flex-grow">{{ job.title }}</h3>
                    <section class="flex flex-row gap-2">
                        <button class="self-center font-bold flex flex-row gap-1 border border-gray-400 text-gray-500 p-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            <span>Edit</span>
                        </button>
                        <button class="self-center font-bold flex flex-row gap-1 border border-gray-400 text-gray-500 p-2 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>View</span>
                        </button>
                        <button class="self-center font-bold flex flex-row gap-1 border text-white bg-green-400 text-gray-500 p-2 rounded-md">
                            <span>Published</span>
                        </button>
                    </section>
                </div>
                <section class="flex flex-row gap-2 text-gray-500 text-sm bg-gray-50 px-4 pb-4 pt-2">
                    <span class="flex flex-row items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>{{ job.type.name }}</span>
                    </span>
                    <span class="flex flex-row items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ job.location }}</span>
                    </span>
                    <span class="flex flex-row items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Closing on {{ job.deadline }}</span>
                    </span>
                </section>
                <div class="sticky top-16 bg-white">
                    <div class="card rounded-sm flex flex-row col-12 pt-2 px-4">
                        <h5 class="flex-grow mt-2"><strong>Candidates</strong></h5>
                        <!--<div class="pr-2 pb-2">
                            <input type="text" placeholder="Search Job" class="form-control">
                        </div>-->

                        <div>
                            <label>Show <select name="jobsTbl_length" aria-controls="jobsTbl">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> entries</label>
                        </div>
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-black rounded-md bg-opacity-20 hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                >
                                    Options
                                    <ChevronDownIcon
                                        class="w-5 h-5 ml-2 -mr-1 text-violet-200 hover:text-violet-100"
                                        aria-hidden="true"
                                    />
                                </MenuButton>
                            </div>

                            <transition
                                enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0"
                            >
                                <MenuItems
                                    class="absolute right-0 w-56 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                  active ? 'bg-violet-500 text-white' : 'text-gray-900',
                                                  'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                                                ]"
                                            >
                                                <EditIcon
                                                    :active="active"
                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                    aria-hidden="true"
                                                />
                                                <input type="checkbox"> Edit
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                      active ? 'bg-violet-500 text-white' : 'text-gray-900',
                      'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                    ]"
                                            >
                                                <DuplicateIcon
                                                    :active="active"
                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                    aria-hidden="true"
                                                />
                                                Duplicate
                                            </button>
                                        </MenuItem>
                                    </div>
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                      active ? 'bg-violet-500 text-white' : 'text-gray-900',
                      'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                    ]"
                                            >
                                                <ArchiveIcon
                                                    :active="active"
                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                    aria-hidden="true"
                                                />
                                                Archive
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                      active ? 'bg-violet-500 text-white' : 'text-gray-900',
                      'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                    ]"
                                            >
                                                <MoveIcon
                                                    :active="active"
                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                    aria-hidden="true"
                                                />
                                                Move
                                            </button>
                                        </MenuItem>
                                    </div>

                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                      active ? 'bg-violet-500 text-white' : 'text-gray-900',
                      'group flex rounded-md items-center w-full px-2 py-2 text-sm',
                    ]"
                                            >
                                                <DeleteIcon
                                                    :active="active"
                                                    class="w-5 h-5 mr-2 text-violet-400"
                                                    aria-hidden="true"
                                                />
                                                Delete
                                            </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>
                    <div class="z-50">
                        <ul class="flex text-gray-500 py-3 border-b-2 border-gray-400 px-4">
                            <li class="mr-6">
                                <a class="hover:text-blue-800" href="#">Applied <span class="bg-gray-100 rounded-lg p-1">2</span></a>
                            </li>
                            <li class="mr-6">
                                <a class="hover:text-blue-800" href="#">Phone Screening</a>
                            </li>
                            <li class="mr-6">
                                <a class="hover:text-green-800 text-green-500 border-b border-green-500" href="#">Interview</a>
                            </li>
                            <li class="mr-6">
                                <a class="cursor-not-allowed " href="#">Rejected</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <section v-for="application in applications" class="px-4 py-2 flex flex-row gap-2 border-b border-gray-400 text-gray-500">
                        <img src="https://placeimg.com/200/200/any" class="h-14 w-14 rounded-full" alt="">
                        <div class="flex flex-col gap-1 flex-grow">
                            <span class="text-green-500 font-bold">{{ application.candidate.full_name }}</span>
                            <div class="flex flex-row items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>{{ application.candidate.user.email }}</span>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1 self-center items-center text-sm">
                            <span class="font-bold">Salary Expectation</span>
                            <span>$500,000</span>
                        </div>
                        <div class="flex flex-col gap-1 self-center items-center">
                            <span class="self-center">Applied on January 5, 2020</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 self-center" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </section>
                </div>
                <!--<table class="shadow-lg bg-white w-full text-gray-600 rounded-md">
                    <thead>
                    <tr>
                        <th class="bg-green-100 border text-left px-8 py-3">Candidate Name</th>
                        <th class="bg-green-100 border text-left px-8 py-3 text-center">Cover Letter</th>
                        <th class="bg-green-100 border text-left px-8 py-3 text-center">Resume</th>
                        <th class="bg-green-100 border text-left px-8 py-3 text-center">Closing Date</th>
                        <th class="bg-green-100 border text-left px-8 py-3 text-center">Applications</th>
                        <th class="bg-green-100 border text-left px-8 py-3 text-center">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="job in $page.props.jobs">
                        <td class="border px-8 py-2 text-green-500 hover:text-green-400 font-bold"><Link :href="route('company.job.view', job.slug)">{{ job.title }}</Link></td>
                        <td class="border px-8 py-2 text-center">
                            <span class="bg-green-400 p-1 text-white cursor-pointer rounded-md text-center"><small>Promote</small></span>
                            <span class="bg-gray-400 p-1 text-white cursor-pointer rounded-md"><small>View Insights</small></span>
                        </td>
                        <td class="border px-8 py-2 text-center">
                            &lt;!&ndash;<time-ago refresh long locale="en" :datetime="new Date()">
                                <template v-slot="{ timeago }">
                                  <span class="text-gray-600 text-sm">
                                    {{ job.created_at }}
                                  </span>
                                </template>
                            </time-ago>&ndash;&gt;
                        </td>
                        <td class="border px-8 py-2 text-center">{{ job.deadline }}</td>
                        <td class="border px-8 py-2 text-center"><span class="bg-green-400 p-1 text-white cursor-pointer rounded-md"><small><Link :href="route('company.job.applications', job.slug)">{{ job.applications_count }}</Link></small></span></td>
                        <td class="border px-8 py-2 text-center">
                            <div class="flex flex-row" title="Edit">
                                    <span class="text-green-500 hover:text-green-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </span>
                                <span class="text-red-500 hover:text-red-400" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center border px-8 py-4" colspan="6">
                            <span>The jobs that you post will appear </span>
                            <span>
                                <button class="bg-green-400 p-1 rounded-md text-white"><Link :href="route('company.post-job')">Post a Job</Link></button>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>-->
            </div>
            <!--<div class="col-span-1">
                <div class="sticky top-20 shadow-md p-4">
                    <span>This is the promotion part of the job</span>
                </div>
            </div>-->
        </div>
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
        name: "Applications",
        components: {
            EmployerLayout, Head, Input, Loader, Link, TimeAgo, Dropdown, DropdownLink, Menu, MenuButton, MenuItems, MenuItem
        },
        data(){
            return {
                job: this.$page.props.job,
                applications: this.$page.props.applications

            }
        }
    }
</script>

<style scoped>

</style>
