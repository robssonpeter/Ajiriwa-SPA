<template>
    <app-layout title="View jobs">
        <div class="max-w-7xl mx-auto hidden md:block sm:px-6 sticky top-12 md:top-14 ">
            <BreadCrumb :links="$page.props.breadcrumb"></BreadCrumb>
        </div>
        <div class="gap-3 md:grid md:grid-cols-3 gap-4 max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">
            <div class="px-4 min-h-screen col-span-3 bg-gray-50 my-4 p-4 shadow-md">
                <div class="flex row gap-2 pb-2">
                    <div class="flex-grow">
                        <h2 class="text-2xl flex-grow">Saved Jobs</h2>
                        <span>Here you can see all the jobs that you've saved</span>
                    </div>
                </div>
                <div class="border shadow-md md:hidden flex flex-col p-2 w-100" v-for="(job, index) in jobs">
                    <section class="w-100">
                        <span class="flex-fill py-2 col-4 text-green-500 hover:text-green-400 font-bold"><Link :href="route('company.job.view', job.job.slug)">{{ job.job.title }}</Link></span>
                        <span v-if="job.status <= 1" class="col-1 text-red-500 hover:text-red-400 align-center cursor-pointer" @click="unsaveJob(index)" title="Withdraw Application">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </span>
                    </section>
                    <span>{{ job.job.location }}</span>
                    <section >
                        <small class="mt-1">{{ job.job.deadline}}</small>
                    </section>

                    <job-status :job="job" :key="job.id" ></job-status>
                </div>
                <table class="bg-white col-span-3 text-gray-600 rounded-md hidden md:block">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-8 py-3">Position</th>
                        <th class="text-left px-8 py-3 text-center">Company</th>
                        <th class="text-left px-8 py-3 text-center">Location</th>
                        <th class="text-left px-8 py-3 text-center">Status</th>
                        <th class="text-left px-8 py-3 text-center">Closing Date</th>
                        <th class="text-left px-8 py-3 text-center">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(job, index) in jobs" >
                        <td class="border px-8 py-2 text-green-500 hover:text-green-400 font-bold"><Link :href="route('company.job.view', job.job.slug)">{{ job.job.title }}</Link></td>
                        <td class="border px-8 py-2 text-center">
                            <span>{{ job.job.company.name }}</span>
                        </td>

                        <td class="border px-8 py-2 text-center">
                            {{ job.job.location }}
                        </td>

                        <td class="border px-8 py-2 text-center">
<!--                            <job-status :job="job" :key="job.id" ></job-status>-->
                        </td>
                        <td class="border px-8 py-2 text-center">{{ job.job.deadline }}</td>
                        <td class="border px-8 py-2 text-center">
                            <span class="text-red-500 hover:text-red-400 align-center cursor-pointer" @click="unsaveJob(index)" title="Withdraw Application">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </span>
                        </td>
                    </tr>
                    <tr v-if="!jobs.length" class="w-full">
                        <td class="text-center border px-8 py-4" colspan="6">
                            <span>You have not saved any jobs</span>
                            <span>
                                <button class="bg-green-400 p-1 rounded-md text-white"><Link :href="route('jobs.browse')">Browse Jobs</Link></button>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Input from "@/Jetstream/Input";
    import Loader from "@/Custom/Loader";
    import TimeAgo from 'vue3-timeago';
    import CheckableDropdown from "@/Custom/CheckableDropdown";
    import ApplicationStatus from "@/Custom/Job/ApplicationStatus";
    import { DataTable, TableHead, TableBody, TableBodyCell, TableHeadCell } from '@jobinsjp/vue3-datatable';
    import '@jobinsjp/vue3-datatable/dist/style.css';
    import BreadCrumb from "@/Custom/BreadCrumb";
    import Swal from "sweetalert2";
    import { DefineComponent } from "vue";
    //import DataT
    export default {
        name: "SavedJobs",
        props: {
            title: String,
        },
        components: {
            AppLayout,
            Head,
            Input,
            Loader,
            Link,
            TimeAgo,
            CheckableDropdown,
            ApplicationStatus,
            DataTable,
            TableHead,
            TableBody,
            TableBodyCell,
            TableHeadCell,
            BreadCrumb
        },
        mounted() {
            console.log(this.jobs);
        },
        computed: {

            columns(){
                return [
                    {
                        label: 'Position',
                        field: 'job_title',
                        html: true,
                    },
                    {
                        label: 'Location',
                        field: 'location',
                    },
                    {
                        label: 'Date Applied',
                        field: 'job_date',
                    },
                    {
                        label: 'Status',
                        field: 'closing_date',
                    },
                    {
                        label: 'Closing Date',
                        field: 'deadline',
                    },
                    {
                        label: 'Action',
                        field: 'action',
                    },
                ]
            }
        },
        data(){
            return {
                empty_rows: [],
                rows: [
                    { id:1, name:"John", age: 20, createdAt: '',score: 0.03343 },
                    { id:2, name:"Jane", age: 24, createdAt: '2011-10-31', score: 0.03343 },
                    { id:3, name:"Susan", age: 16, createdAt: '2011-10-30', score: 0.03343 },
                    { id:4, name:"Chris", age: 55, createdAt: '2011-10-11', score: 0.03343 },
                    { id:5, name:"Dan", age: 40, createdAt: '2011-10-21', score: 0.03343 },
                    { id:6, name:"John", age: 20, createdAt: '2011-10-31', score: 0.03343 },
                ],
                jobs: this.$page.props.jobs,
            }
        },
        methods: {
            unsaveJob(index){
                  axios.post(route('job-save.toggle'), {
                      job_id: this.jobs[index].job.id,
                      action: 'remove',
                  }).then((response) => {
                      if(response.data){
                            console.log(response.data)
                          // remove the job from the list
                          this.jobs.splice(index, 1);
                      }
                  }).catch((error) => {
                      console.log(error.response.data);
                  })
            },
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
        }

    }
</script>

<style scoped>

</style>
