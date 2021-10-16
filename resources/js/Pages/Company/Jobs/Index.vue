<template>
    <employer-layout title="View Jobs">
        <div class="grid grid-cols-3 gap-3">
            <div class="z-40 px-4 min-h-screen col-span-3 bg-gray-50 my-4 p-4 shadow-md">
                <table class="shadow-lg bg-white w-full text-gray-600 rounded-md">
                    <thead>
                        <tr>
                            <th class="bg-green-100 border text-left px-8 py-3">Title</th>
                            <th class="bg-green-100 border text-left px-8 py-3 text-center">Promotion</th>
                            <th class="bg-green-100 border text-left px-8 py-3 text-center">Date Posted</th>
                            <th class="bg-green-100 border text-left px-8 py-3 text-center">Closing Date</th>
                            <th class="bg-green-100 border text-left px-8 py-3 text-center">Applications</th>
                            <th class="bg-green-100 border text-left px-8 py-3 text-center">Actions</th>
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
                                <!--<time-ago refresh long locale="en" :datetime="new Date()">
                                    <template v-slot="{ timeago }">
                                      <span class="text-gray-600 text-sm">
                                        {{ job.created_at }}
                                      </span>
                                    </template>
                                </time-ago>-->
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
    export default {
        name: "Post",
        props: {
            title: String,
        },
        components: {
            EmployerLayout, Head, Input, Loader, Link, TimeAgo
        },
        data(){
            return {
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
                number_of_posts: 1
            }
        },
        methods: {
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
        }

    }
</script>

<style scoped>

</style>
