<template>
    <employer-layout title="View Jobs">
        <div class="grid grid-cols-3 gap-3">
            <div class="z-40 px-4 min-h-screen col-span-3 bg-gray-50 my-4 p-4 shadow-md">
                <div class="flex row gap-2 pb-2">
                    <div class="flex-grow">
                        <h2 class="text-2xl flex-grow">Positions</h2>
                        <span>Here you can manage your job posts</span>
                    </div>

                    <button class="bg-green-400 p-2 text-white self-end">Add Position</button>
                    <button class="bg-white p-2 text-green-400 self-end border border-green-400 hover:bg-green-500 hover:text-white">Add Pool</button>
                </div>
                <div class="pb-2">
                    <div class="flex flex-row gap-2">
                        <checkable-dropdown :items="location_menu" label="All Locations"></checkable-dropdown>
                        <checkable-dropdown :items="location_menu" label="All Statuses"></checkable-dropdown>
                    </div>
                </div>
                <table class="bg-white w-full text-gray-600 rounded-md">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left px-8 py-3">Position</th>
                            <th class="text-left px-8 py-3 text-center">Location</th>
                            <!--<th class="bg-green-100 border text-left px-8 py-3 text-center">Promotion</th>-->
                            <th class="text-left px-8 py-3 text-center">Date Posted</th>
                            <th class="text-left px-8 py-3 text-center">Views</th>
                            <th class="text-left px-8 py-3 text-center">Status</th>
                            <th class="text-left px-8 py-3 text-center">Closing Date</th>
                            <th class="text-left px-8 py-3 text-center">Applications</th>
                            <th class="text-left px-8 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="job in jobs" >
                            <td class="border px-8 py-2 flex flex-col">
                                <Link class="text-green-500 hover:text-green-400 font-bold" :href="route('company.job.view', job.slug)">{{ job.title }}</Link>
                                <span class="text-sm" v-if="$page.props.is_admin">{{ job.company.name }}</span>
                            </td>
                            <td class="border px-8 py-2 text-center">
                                <span>{{ job.location }}</span>
                            </td>
                            <!--<td class="border px-8 py-2 text-center">
                                <span class="bg-green-400 p-1 text-white cursor-pointer rounded-md text-center"><small>Promote</small></span>
                                <span class="bg-gray-400 p-1 text-white cursor-pointer rounded-md"><small>View Insights</small></span>
                            </td>-->
                            <td class="border px-8 py-2 text-center">
                                <small>{{ job.time_ago }}</small>
                                <!--<time-ago refresh long locale="en" :datetime="new Date()">
                                    <template v-slot="{ timeago }">
                                      <span class="text-gray-600 text-sm">
                                        {{ job.created_at }}
                                      </span>
                                    </template>
                                </time-ago>-->
                            </td>
                            <td class="border px-8 py-2 text-center">{{ job.views_count }}</td>
                            <td class="border px-8 py-2 text-center">
                                <Status :job="job" :options="$page.props.status" :key="job.id" @change="statusUpdated"></Status>
                            </td>
                            <td :class="isPast(job.deadline)?'text-red-500 border px-8 py-2 text-center':'border px-8 py-2 text-center'">{{ job.deadline }}</td>
                            <td class="border px-8 py-2 text-center"><span class="bg-green-400 p-1 text-white cursor-pointer rounded-md"><small><Link :href="route('company.job.applications', job.slug)">{{ job.applications_count }}</Link></small></span></td>
                            <td class="border px-8 py-2 text-center">
                                <div class="flex flex-row" title="Edit">
                                    <Link :href="route('company.edit-job', job.slug)">
                                        <span class="text-green-500 hover:text-green-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </span>
                                    </Link>
                                    <span class="text-red-500 hover:text-red-400" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <tr v-if="!jobs.length">
                        <td class="text-center border px-8 py-4" colspan="8">
                            <span>The jobs that you post will appear here</span>
                            <span>
                                <button class="bg-green-400 p-1 rounded-md text-white"><Link :href="route('company.post-job')">Post a Job</Link></button>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
    import CheckableDropdown from "@/Custom/CheckableDropdown";
    import Status from "@/Custom/Job/Status";
    export default {
        name: "Post",
        props: {
            title: String,
        },
        components: {
            EmployerLayout,
            Head,
            Input,
            Loader,
            Link,
            TimeAgo,
            CheckableDropdown,
            Status
        },
        mounted() {
            console.log(this.jobs);
        },
        data(){
            return {
                jobs: this.$page.props.jobs,
                apply_method: 'ajiriwa',
                application_email: '',
                application_url: '',
                title: '',
                location: '',
                reports_to: '',
                job_type: '',
                category: '',
                description: '',
                deadline: '',
                cover_letter: '',
                saving: false,
                /*company_id: this.$page.props.company.id,*/
                number_of_posts: 1,
                location_menu: [
                    { label: 'Dar es Salaam', value: 1},
                    { label: 'Iringa', value: 2 },
                ]
            }
        },
        methods: {
            statusUpdated(event){
                let job_id = event.id;
                let status = event.status;
                let index = this.jobs.findIndex(element => element.id === job_id);
                console.log(this.jobs[index]);
                this.jobs[index].status = status;
                //this.
            },
            editorChanged(html){
                //alert(html)
                this.description = html;
                console.log(this.description);
            },
            submitJob(){
                this.saving = true;
                axios.post(route('job.save'), this.$data).then((response) => {
                    console.log(response.data);
                    if(response.data && response.data.id){
                        // click the button to redirect
                        this.$inertia.visit(route('company.job.view', response.data.slug))
                    }
                }).catch((error) => {
                    console.log(error.response.data);
                    swal.fire('Error', 'Your job could not be saved', 'error');
                })
            }
        },
        computed: {
            isPast(){
                return date => {
                    let today = new Date();
                    let new_date = new Date(date);
                    return new_date < today;
                }
            }
        }

    }
</script>

<style scoped>

</style>
