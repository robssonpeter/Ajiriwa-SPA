<template>
    <employer-layout title="View Jobs">
        <div class="grid grid-cols-3 gap-3">
            <div class="z-40 px-4 min-h-screen col-span-3 bg-gray-50 my-4 p-4 shadow-md">
                <div class="flex row gap-2 pb-2">
                    <div class="flex-grow">
                        <h2 class="text-2xl flex-grow">Companies Pending Verification</h2>
                        <span>Here you can see companies waiting to be verified</span>
                    </div>
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
                            <th class="text-left px-8 py-3">Company Name</th>
                            <th class="text-left px-8 py-3 text-center">User Name</th>
                            <!--<th class="bg-green-100 border text-left px-8 py-3 text-center">Promotion</th>-->
                            <th class="text-left px-8 py-3 text-center">Date Submitted</th>
                            <th class="text-left px-8 py-3 text-center">Attachments</th>
                            <th class="text-left px-8 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="company in companies" >
                            <td class="border px-8 py-4 flex flex-col">
                                <Link class="text-green-500 hover:text-green-400 font-bold" :href="'/'">{{ company.name }}</Link> 
                            </td>
                            <td class="border px-8 py-2 text-center">
                                <span>{{ company.user.name }}</span>
                            </td>
                            <td class="border px-8 py-2 text-center">
                                {{ company.verification_attempt.time_ago }}
                            </td>
                            <td class="border px-8 py-2 text-center">
                                <dropdown align="right" width="48" class="hidden md:block">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="border border-green-400 p-1 rouded-md">
                                                <section class="flex flex-row text-green-400">
                                                    <span class="self-center">Attachments</span>
                                                    <svg class="ml-2 -mr-0.5 h-4 w-4 self-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </section>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <dropdown-link class="hover:bg-green-300 flex flex-col" as="button" v-for="(attachment, index) in company.verification_attempt.documents">
                                            <span><a target="_blank" :href="$page.props.host+attachment.file" class="class">Attachment {{ index + 1 }}</a></span>
                                        </dropdown-link>
                                    </template>
                                </dropdown>
                            </td>
                            <td class="border px-8 py-4 items-center">
                                <loader color="green" v-if="verifying_loading(company.id)"></loader>  
                                <div class="flex space-x-2" v-else>
                                    <span class="text-red-500 hover:text-red-400 align-items-center" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span> 
                                    
                                    <span @click="markVerified(company.id)" class="text-green-500 hover:text-green-400 align-items-center cursor-pointer" title="Mark Verified">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                
                            </td>
                        </tr>
                        <tr v-if="!companies.length">
                            <td class="text-center border px-8 py-4" colspan="8">
                                <span>The are no companies pending verification</span>
                            </td>
                        </tr>
                    </tbody>    
                </table>
            </div>
        </div>
    </employer-layout>
</template>

<script>
    import EmployerLayout from "@/Layouts/EmployerLayout";
    import Dropdown from "@/Jetstream/Dropdown";
    import BreadCrumb from "@/Custom/BreadCrumb";
    import DialogModal from "@/Jetstream/DialogModal";
    import Apply from "@/Custom/Job/Apply";
    import TextEditor from "@/Custom/TextEditor";
    import AssessmentRender from "@/Custom/Job/Screening/AssessmentRender";
    import Loader from "@/Custom/Loader";
    import TimeAgo from 'vue-timeago';
    import 'flowbite';
    import iziToast from "izitoast";
    import { Link } from "@inertiajs/inertia-vue3";
    import "izitoast/dist/css/iziToast.min.css";
    import Swal from "sweetalert2";
    import { initializeApp } from "firebase/app";
    import { getAnalytics } from "firebase/analytics";
    import { getMessaging, getToken } from "firebase/messaging";
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css'

    const firebaseConfig = {
        apiKey: "AIzaSyCc2eq23_efjual1WZ329gMP5bZlOunv9s",
        authDomain: "ajiriwa-push-notifications.firebaseapp.com",
        projectId: "ajiriwa-push-notifications",
        storageBucket: "ajiriwa-push-notifications.appspot.com",
        messagingSenderId: "117362381735",
        appId: "1:117362381735:web:0a00ccfa5024cc70fc9c82",
        measurementId: "G-JW3B32E4S6"
    };

    // Initialize Firebase
    const firebaseApp = initializeApp(firebaseConfig);
    const analytics = getAnalytics(firebaseApp);
    const messaging = getMessaging(firebaseApp);

    export default {
        name: "Jobs",
        components: {
            EmployerLayout, Dropdown, BreadCrumb, DialogModal, Apply, TextEditor, Loader, TimeAgo, vSelect, AssessmentRender, Link
        },
        mounted(){
            /*messaging.onMessage(function({data:{body,title}}){
                new Notification(title, {body});
            });*/
            console.log(this.companies[0].verification_attempt.documents);
        },
        data(){
            return {
                loading: false,
                verifying: [],
                apply_modal: false,
                currently_applying: false,
                current_job: {},
                current_assessments: [],
                companies: this.$page.props.companies,
                search: "",
            }
        },
        computed: {
            verifying_loading(){
                return company_id => {
                    return this.verifying.indexOf(company_id) > -1;
                }
            }
        },
        methods: {
            markVerified(company_id){
                Swal.fire({
                title: 'Mark Verified',
                text: "Are you sure you want to proceed?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#22c55e',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, verify!'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.verifying.push(company_id);
                    axios.post(route('admin.company.verify.save', company_id), {company_id: company_id}).then((response) => {
                        if(response.data){
                            // show a success message
                            iziToast.success({title: "Done", message: "Company succesfully verified"});
                            // remove the company from the listing
                            let verify_index = this.verifying.indexOf(company_id);
                            let index = this.companies.findIndex(element => element.id == company_id);
                            if(index > -1){
                                this.companies.splice(index, 1);
                            }  
                            this.verifying.splice(verify_index, 1); 
                        } 
                    }).catch((error) => {
                        iziToast.error({title: "Failed", message: "Verification failed due to an error"});
                        console.log(error.response.data);
                        this.verifying.splice(verify_index, 1);  
                    })
                }
                })
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
