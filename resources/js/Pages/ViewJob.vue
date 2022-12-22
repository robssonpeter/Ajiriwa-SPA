<template>
    <app-layout title="Browse Jobs">
        <div class="mx-auto px-6 sm:px-6 md:px-16 bg-white">
            <BreadCrumb></BreadCrumb>
        </div>
        <div class="w-full md:max-w-7xl mx-auto pt-5 mb-12 md:grid md:grid-cols-6 gap-2" id="job-page">
            <div class="col-span-4 mr-8 md:mr-0">
                <div class="bg-white shadow-lg  ml-8 p-4">
                    <section class="md:grid grid-cols-4">
                        <div class="col-span-3 flex flex-col">
                            <span class="text-xl text-gray-500 font-bold">{{ job.title }}</span>
                            <span class="text-green-500">{{ job.company.name }}</span>
                            <span class="text-gray-500">{{ job.location }}</span>
                        </div>
                        <div class="md:grid md:grid-cols-2 md:gap-4 hidden md:block">
                            <button class="bg-green-500 rounded-md text-white p-2 self-center" @click="apply">Apply</button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="w-6 h-6 self-center text-green-500 cursor-pointer"
                                 data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.C.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/>
                            </svg>
                        </div>


                    </section>
                    <div class="bg-gray-200 w-100 p-4 mt-2 md:grid md:grid-cols-4">
                        <section class="md:flex md:flex-col flex-row">
                            <span class="font-bold hidden md:block">Job Type:</span>
                            <div class="items-center md:hidden block px-2 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                                </svg>
                                <span class="pl-4 md:pl-0 self-center md:self-start">{{ job.type.name }}</span>
                            </div>
                            <span class="pl-4 md:pl-0 hidden md:block self-start">{{ job.type.name }}</span>
                        </section>
                        <section class="md:flex md:flex-col flex-row">
                            <span class="font-bold hidden md:block">Closing Date:</span>
                            <div class="items-center md:hidden block px-2 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                </svg>
                                <span class="pl-4 md:pl-0 self-center md:self-start">{{ $page.props.deadline_formated }}</span>
                            </div>
                            <span class="pl-4 md:pl-0 hidden md:block self-start">{{ $page.props.deadline_formated }}</span>
                        </section>
                        <section class="md:flex md:flex-col flex-row">
                            <span class="font-bold hidden md:block">Location:</span>
                            <div class="items-center md:hidden block px-2 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                </svg>
                                <span class="pl-4 md:pl-0 self-center md:self-start">{{ job.location }}</span>
                            </div>
                            <span class="pl-4 md:pl-0 hidden md:block self-start">{{ job.location }}</span>
                        </section>
                        <section class="md:flex md:flex-col flex-row">
                            <span class="font-bold hidden md:block">Views:</span>
                            <div class="items-center md:hidden block px-2 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="pl-4 md:pl-0 self-center md:self-start">300</span>
                            </div>
                            <span class="pl-4 md:pl-0 hidden md:block self-start">300</span>
                        </section>
                        <div class="flex flex-row py-2 md:hidden">
                            <button class="bg-green-500 rounded-md w-full text-white p-2 self-center" @click="apply">Apply</button>

                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-lg  ml-8 p-4 mt-2 description text-gray-600" v-html="job.description">
                </div>
            </div>
            <div class="bg-white col-span-2 mr-16 px-4 self-start py-4 sticky top-16 shadow-lg hidden md:block">
                <section class="flex flex-row border-b pb-2">
                    <div class="h-16 w-16 bg-green-200">
                        <img src="{{ job.company.logo_url }}" alt="">
                    </div>
                    <section class="px-4 flex flex-col ">
                        <a :href="route('company.show', job.company.slug)"
                           class="font-bold text-green-600 cursor-pointer">{{ job.company.name }}</a>
                        <span class="text-gray-600">Banking</span>

                        <small v-if="job.company.website" class="text-green-500" onclick="window.location.href = job.company.website">Website</small>
                    </section>
                </section>

            </div>
            <TransitionRoot
                :show="true"
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
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

                        <apply @applied="doneApplying" @applying="applying"  :selected_certs="selected_certs" :job="current_job" :ref="'apply'"></apply>
                        <section class="flex flex-col py-2">
                            <span class="font-bold">Attachments</span>
                            <v-select :options="certificates" v-model="selected_certs" multiple></v-select>
                        </section>
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
            </TransitionRoot>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import BreadCrumb from "@/Custom/BreadCrumb";
    import iziToast from "izitoast";
    import Swal from "sweetalert2";

    export default {
        name: "Jobs",
        props: {
            data: {
                type: Object,
            },
            slug: {
                type: String
            }
        },
        components: {
            AppLayout, BreadCrumb
        },
        computed: {
            canApply(){
                return date => {
                    let today = new Date();
                    date = new Date(date);
                    return today <= date;
                }
            },
            saveButtonColors(){
                let preclass = 'border-2 p-2 rounded-md'
                if(this.saved_jobs.indexOf(this.current_job.id)<0){
                    return preclass+" border-gray-200 hover:border-green-500 hover:text-green-500";
                }
                return preclass+" border-green-500 hover:border-gray-200 hover:text-green-500 text-green-500";
            },
            alreadyApplied(){
                if(this.applied_jobs.indexOf(this.current_job.id) >= 0){
                    return true
                }
                return false;
            },
            jobSaved(){
                if(this.saved_jobs.indexOf(this.current_job.id) >= 0){
                    return true
                }
                return false;
            }
        },
        data(){
            return {
                job: this.$page.props.job,
                apply_modal: false,
                application_means:{
                    show_modal: false,
                },
                guest_application:{
                    show_modal: false,
                },
                application:{
                    name: '',
                    email: '',
                    cover_letter: '',
                    attachments: []
                },
                applying: false,
            }
        },
        methods: {
            apply(){
                if(this.job.apply_method === 'url'){
                    // redirect to application url
                    window.open(
                        this.job.application_url,
                        '_blank' // <- This is what makes it open in a new window.
                    );
               }else{

                }
            },
            startApplying(){
                if(this.current_job.application_url){
                    //alert('you are supposed to be redirected to another website');
                    window.open(this.current_job.application_url, "_blank");
                    setTimeout(() => {
                        Swal.fire({
                            title: "Did you apply?",
                            text: "We can help you track the application",
                            icon: ""
                        })
                    }, 1000);
                    // show an confirmation asking if the user had applied for the position
                }else{
                    this.apply_modal = !this.apply_modal
                }
            },
            /*apply(){
                this.$refs.apply.sendApplication();
            },*/
            doneApplying(job){
                // close the modal
                this.apply_modal = false;

                this.currently_applying = false;

                console.log(job);

                // update the entry where the job exists
                this.current_job.applied = true;

                this.applied_jobs.push(this.current_job.id);

                /*let index = this.jobs.findIndex(element => element.id === job);

                if(index){
                    this.jobs[index].applied = true;
                }*/

                // show the popup notification that the application was successful
                iziToast.success({
                    title: "Done",
                    message: "Your application has been sent"
                })
            },
            applying(status){
                //alert(status);
                this.currently_applying = status;
            }
        }
    }
</script>

<style scoped>
    #description li {
        list-style-type: circle;
        margin-left: 20px;
    }
    #description h2 {
        font-size: 1.5rem/* 24px */;
    }

    #description h1, h2, h3, h4, h5, h6{
        line-height: 2rem/* 32px */;
        margin-top: 0.75rem;
        margin-bottom: 0.75rem;
    }
</style>
