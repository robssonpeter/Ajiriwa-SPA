<template>
    <app-layout title="View applications">
      <div class="max-w-7xl mx-auto sm:px-6 sticky top-12 md:top-14 z-30">
        <BreadCrumb :links="$page.props.breadcrumb"></BreadCrumb>
      </div>
      <div class="gap-3 md:grid md:grid-cols-3 gap-4 max-w-7xl mx-auto py-1 px-4 sm:px-6 lg:px-8">
        <div class="px-4 min-h-screen col-span-3 bg-gray-50 my-4 p-4 shadow-md">
          <div class="flex flex-col gap-2 pb-2">
            <div class="flex-grow">
              <h2 class="text-2xl font-bold">Job Application</h2>
              <span class="text-gray-500">Here you can see all the applications you've made</span>
            </div>
          </div>
          <div class="grid gap-2 md:hidden" v-for="(application, index) in applications" :key="application.id">
            <div class="border shadow-md p-4">
              <span class="text-green-500 font-bold">
                <Link :href="route('company.job.view', application.job.slug)">{{ application.job.title }}</Link>
              </span>
              <span v-if="application.status <= 1" class="text-red-500 hover:text-red-400 cursor-pointer" @click="withdrawApplication(index)" title="Withdraw Application">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  />
                </svg>
              </span>
            </div>
            <span>{{ application.job.location }}</span>
            <section>
              <small class="mt-1">{{ application.job.deadline }}</small>
            </section>
            <application-status :application="application" :key="application.id"></application-status>
          </div>
          <table class="bg-white w-full text-gray-600 rounded-md hidden md:block">
            <thead>
              <tr class="bg-gray-50">
                <th class="px-8 py-3 text-left">Position</th>
                <th class="px-8 py-3 text-center">Location</th>
                <th class="px-8 py-3 text-center">Date Applied</th>
                <th class="px-8 py-3 text-center">Status</th>
                <th class="px-8 py-3 text-center">Closing Date</th>
                <th class="px-8 py-3 text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(application, index) in applications" :key="application.id" class="border-t">
                <td class="px-8 py-5">
                  <div class="flex flex-col">
                    <Link :href="route('job.view', application.job.slug)" class="text-green-500 hover:text-green-400 font-bold">{{ application.job.title }}</Link>
                    <small>{{ application.job.company.name }}</small>
                  </div>
                </td>
                <td class="px-8 py-5 text-center">{{ application.job.location }}</td>
                <td class="px-8 py-5 text-center">{{ application.application_date }}</td>
                <td class="px-8 py-5 text-center">
                  <application-status :application="application" :key="application.id"></application-status>
                </td>
                <td class="px-8 py-5 text-center">{{ application.job.deadline }}</td>
                <td class="px-8 py-5 text-center">
                  <span v-if="application.status <= 1" class="text-red-500 hover:text-red-400 cursor-pointer" @click="withdrawApplication(index)" title="Withdraw Application">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block align-text-bottom" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                      />
                    </svg>
                  </span>
                </td>
              </tr>
              <tr v-if="!applications.length" class="border-t">
                <td class="px-8 py-4 text-center" colspan="6">
                  <span class="text-gray-500">You have not made any application</span>
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
    import BreadCrumb from "@/Custom/BreadCrumb";
    import Swal from "sweetalert2";
    import { DefineComponent } from "vue";
    //import DataT
    export default {
        name: "Post",
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
            BreadCrumb
        },
        mounted() {
            console.log(this.applications);
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
                        field: 'application_date',
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
                applications: this.$page.props.applications,
            }
        },
        methods: {
            withdrawApplication(index){
                  Swal.fire({
                      title: "Withdraw Application",
                      text: "Are you sure you want to withdraw this application? Your application data will be deleted continue",
                      icon: "warning",
                      confirmButtonText: "Withdraw",
                      cancelButtonText: "Cancel",
                      showCancelButton: true,
                      confirmButtonColor: "#31C48D",
                      showLoaderOnConfirm: true,
                      preConfirm: (login) => {
                          axios.post(route('application.withdraw'), {
                              application_id: this.applications[index].id,
                          }).then((response) => {
                              if(response.data){
                                    console.log(response.data)
                                  // remove the application from the list
                                  this.applications.splice(index, 1);
                              }
                          }).catch((error) => {
                              console.log(error.response.data);
                          })
                      },

                  })/*.then(value => {
                      if(value.isConfirmed){
                          //alert("you've confirmed")
                      }else{
                          alert("you've cancelled")
                      }
                  })*/
            },
            statusUpdated(event){
                let job_id = event.id;
                let status = event.status;
                let index = this.applications.findIndex(element => element.id === job_id);
                console.log(this.applications[index]);
                this.applications[index].status = status;
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
