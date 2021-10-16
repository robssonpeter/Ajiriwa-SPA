<template>
    <app-layout title="Browse Jobs">
        <div class="mx-auto px-6 sm:px-6 md:px-16 bg-white">
            <BreadCrumb></BreadCrumb>
        </div>
        <div class="mx-0 my-2 px-6 sm:px-6 md:px-16 md:grid md:grid-cols-3 gap-3">
            <div class="md:col-span-1 bg-white rounded-md p-2 self-start md:sticky md:top-20 ">
                <div class="flex flex-row py-2">
                    <input type="text" class="flex-grow border border-gray-300" placeholder="Search Jobs">
                    <button class="bg-green-500 px-2 text-white">Search</button>
                </div>
                <section v-for="(job, index) in jobs" class="my-1 grid grid-cols-3 border border-gray-300 sm:rounded-md">
                    <img src="https://placeimg.com/200/200/any" class="h-24 rounded-l-md" alt="">
                    <div class="col-span-1">
                        <a href="#" @click.prevent="showJob(index)" class="text-green-500 font-bold">{{ job.title }}</a>
                        <p>{{ job.company.name }}</p>
                        <small>{{ job.location }}</small>
                        <!--<span>{{ job.created_at }}</span>-->
                        <time-ago></time-ago>
                    </div>
                </section>
            </div>
            <div class="col-span-2 bg-white rounded-md self-start sticky top-20 overflow-y-auto">
                <div v-if="current_job" class="description">
                    <dialog-modal :show="apply_modal" :closeable="true" :max-width="'2xl'">
                        <template v-slot:title>
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">Applying for {{ current_job.title }}</span>
                                <button @click="apply_modal = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                        </template>

                        <template v-slot:content>
                            <apply @applied="doneApplying" @applying="applying" :job="current_job" :ref="'apply'"></apply>
                            <!--<text-editor></text-editor>-->
                        </template>
                        <template v-slot:footer>
                            <div class="flex flex-row">
                                <span class="flex-grow"></span>
                                <button @click="apply" :disabled="currently_applying" class="bg-green-500 hover:shadow-lg text-white p-2 flex flex-row">
                                    <span class="flex-grow"></span>
                                    <loader v-if="currently_applying" :color="'white'"></loader>
                                    <span v-else>Apply</span>
                                    <span class="flex-grow"></span>
                                </button>
                            </div>
                        </template>
                    </dialog-modal>
                    <div class="border-b-2 p-4">
                        <h2 class="text-lg">{{ current_job.title }}</h2>
                        <p>{{ current_job.location }}</p>
                        <p>Full Time</p>
                        <div class="flex gap-2">
                            <button v-if="!current_job.applied" class="bg-green-500 p-2 rounded-md text-white" @click="apply_modal = !apply_modal">Apply</button>
                            <button v-else class="bg-green-white border border-green-500 text-green-500 rounded-md px-2">Already Applied</button>
                            <button class="border-2 border-gray-200 p-2 rounded-md hover:border-green-500 hover:text-green-500"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg></button>
                        </div>
                    </div>
                    <div class="p-4 text-gray-600" v-html="current_job.description">

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import BreadCrumb from "@/Custom/BreadCrumb";
    import DialogModal from "@/Jetstream/DialogModal";
    import Apply from "@/Custom/Job/Apply";
    import TextEditor from "@/Custom/TextEditor";
    import Loader from "@/Custom/Loader";
    import TimeAgo from 'vue-timeago';
    export default {
        name: "Jobs",
        components: {
            AppLayout, BreadCrumb, DialogModal, Apply, TextEditor, Loader, TimeAgo
        },
        mounted(){
          if(this.jobs.length) {
              this.showJob(0);
          }
        },
        data(){
            return {
                apply_modal: false,
                currently_applying: false,
                current_job: {},
                jobs: this.$page.props.jobs
            }
        },
        methods: {
            showJob(index){
                this.current_job = this.jobs[index];

                // check if the user already applied for the job
                if(this.$page.props.user.candidate.applied_jobs.indexOf(this.jobs[index].id) !== -1){
                    // the user has alredy applied for the job
                    this.current_job.applied = true;
                }
            },
            apply(){
               this.$refs.apply.sendApplication();
            },
            doneApplying(){
                // close the modal
                this.apply_modal = false;

                this.currently_applying = false;

                // update the entry where the job exists

                // show the popup notification that the application was successful
            },
            applying(status){
                //alert(status);
                this.currently_applying = status;
            }
        }
    }
</script>

<style scoped>
    div.description::v-deep li {
        list-style-type: circle;
        list-style-position: inside;
        margin-left: 10px;
        margin-inside: 10px;
    }

    div.description::v-deep h1{
        font-size: xx-large;
        font-weight: bold;
        margin-top: 10px;
    }
    div.description::v-deep h2{
        font-size: x-large;
        font-weight: bold;
        margin-top: 8px
    }
    div.description::v-deep h3{
        font-size: large;
        font-weight: bold;
    }
    div.description::v-deep h4{
        margin-top: 8px;
    }
    div.description::v-deep h5{
        margin-top: 8px;
    }

</style>
