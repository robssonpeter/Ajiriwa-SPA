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
                        <h5 class="flex-grow mt-2 ml-4 text-gray-600 text-xl"><strong>Candidates</strong></h5>
                        <!--<div class="pr-2 pb-2">
                            <input type="text" placeholder="Search Job" class="form-control">
                        </div>-->
                        <div class="flex flex-grow flex-row rounded-0 position-sticky sticky-top bg-white py-2 px-2 mb-2 h-25 px-2">
                            <!-- <span class="mr-2 self-center">Filter By:</span> -->
                            <!-- <v-select :options="filter_variables" v-on:change="filterControl" v-model="selected_filters" class="w-48" multiple></v-select> -->
                            
                            <checkable-dropdown @changed="updateSelectedFilters" :items="filter_variables" :selected_options="selected" class="mr-4" label="Filter By"></checkable-dropdown> 
                             <div class="px-2">
                                <button class="bg-green-400 text-white p-1 rounded-md mr-2 focus:pointer-events-auto hover:bg-green-500" v-if="showFilterButtons" @click="filter_modal=true">Show Filter Options</button>
                                <button class="bg-gray-400 text-white p-1 rounded-md mr-2 focus:pointer-events-auto hover:bg-gray-500" v-if="showFilterButtons" @click="clearFilters">Clear Filters</button>
                            </div>
                        </div>

                        <div>
                            <!-- {{ extra_attributes }} -->
                            <!-- <button class="bg-gray-400 text-white p-1 rounded-md mr-2 focus:pointer-events-auto hover:bg-green-500" @click="filter_modal = true">Filter Applications</button>     -->
                            
                            <checkable-dropdown v-if="screening_options.length" @changed="updateSelectedAttributes" :items="screening_options" :selected_options="selected" class="mr-4" label="Display Columns"></checkable-dropdown>
                            <label>Show <select name="jobsTbl_length" class="rounded-md" aria-controls="jobsTbl">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> entries</label>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- filter modal -->
                    <dialog-modal :show="filter_modal" closeable="true" :max-width="'md'">
                        <template v-slot:title class="border-b">
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">Filter Applications</span>
                                <button @click="filter_modal = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <template v-slot:content class="text-gray-600">
                            <div class="pb-2" v-if="selected_filters.indexOf('Status') > -1 ">
                                <div class="flex">
                                    <div class="bg-gray-300 flex rounded-l-md text-gray-600">
                                        <span class="text-sm self-center px-1" id="basic-addon3">Status</span>
                                    </div>
                                    <select v-model="filter_by_status" class="flex-grow border-gray-300 py-1 text-gray-500 rounded-r-md">
                                        <option value="">Select Status</option>
                                        <option :value="index" v-for="(status, index) in statuses">{{ status }}</option>
                                    </select>
                                </div>
                            </div>
                            <div v-for="(assessment, index) in assessments">  
                                
                                <div v-if="selected_filters.indexOf(assessment.variable_name)+1">
                                    <number-filter @changed="updateAssessmentFilter" v-if="assessment.input_type == 'number'" :index="index" :data="assessments[index]"></number-filter>
                                    <select-filter @changed="updateAssessmentFilter" v-if="assessment.input_type == 'select'" :index="index" :data="assessments[index]"></select-filter>
                                </div>
                            </div>
                            
                        </template>
                        <template v-slot:footer>
                            <section class="flex space-x-4 float-left self-center">
                                <input type="checkbox" :checked="keep_filter_modal_open" @change="keep_filter_modal_open = !keep_filter_modal_open" class="self-center">
                                <span class="self-center">Keep this box open</span>
                            </section>
                            <button @click="filterApplications" class="bg-green-400 hover:bg-green-500 text-white p-2 rounded-md">
                                <span>Filter</span>
                            </button>
                        </template>
                    </dialog-modal>
                    <!-- Profile Modal -->
                    <dialog-modal :show="candidate_modal" closeable="true" :max-width="'4xl'">
                        <template v-slot:title>
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">Candidate</span>
                                <button @click="candidate_modal = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <template v-slot:content>
                            <applicant-embed v-if="current_application" :log_descriptions="$page.props.log_colors" @status_changed="changeStatus" :statuses="statuses" :show_profile="full_profile" :job_title="job.title" :application="current_application"></applicant-embed>
                        </template>
                        <template v-slot:footer>
                            <a v-if="full_profile" :href="route('cv.print', current_application.candidate_id)" class="bg-red-500 text-white rounded-md p-1 mr-2">
<!--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>-->
                                <span class="text-sm">Export to PDF</span>
                            </a>
                            <button class="bg-gray-500 text-white text-sm rounded-md p-1" @click="full_profile=!full_profile">{{ full_profile?"Show Applicant Info":"Show Profile" }}</button>
                        </template>
                    </dialog-modal>
                    <table class="bg-white w-full text-gray-600 rounded-md">
                        <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left px-8 py-3">Candidate Name</th>
                            <th class="text-left px-8 py-3" v-for="attribute in extra_attributes">
                                <div class="flex flex-col">
                                    <span>{{ attribute.label.toUpperCase() }}</span>
                                    <small>{{ attribute.description }}</small>
                                </div>
                            </th>
                            <!-- <th class="text-left px-8 py-3 text-center">Expected Salary</th> -->
                            <th class="text-left px-8 py-3 text-center">Location</th>
                            <!--<th class="bg-green-100 border text-left px-8 py-3 text-center">Promotion</th>-->
                            <th class="text-left px-8 py-3 text-center">Status</th>
                            <th class="text-left px-8 py-3 text-center">Application Date</th>
                            <th class="text-left px-8 py-3 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(application, index) in applications" >
                            <td class="border px-8 py-2 text-green-500 hover:text-green-400 font-bold items-center">
                                <loading-placeholder v-if="fetching_applicants"></loading-placeholder>
                                <a v-else @click.prevent="candidate_modal = true; current_application = application" :href="route('company.job.view', job.slug)">{{ application.candidate.full_name }}</a>
                            </td>
                            <td class="border px-8 py-2 text-center" v-for="attribute in extra_attributes">
                                <loading-placeholder v-if="fetching_applicants"></loading-placeholder>
                                <Transition v-else
                                    name="custom-classes"
                                    enter-active-class="animate__animated animate__tada"
                                    leave-active-class="animate__animated animate__bounceOutRight"
                                >
                                <span>{{ attribute_value(attribute.label, index)??'hello' }}</span>
                                </Transition>
                            </td>
                            <!-- <td class="border px-8 py-2 text-center">500,000</td> -->
                            <td class="border px-8 py-2 text-center">
                                <loading-placeholder v-if="fetching_applicants"></loading-placeholder>
                                <span v-else>{{ application.candidate.address }}</span>
                            </td>

                            <td class="border px-8 py-4 h-100">
                                <loading-placeholder class="self-center" v-if="fetching_applicants"></loading-placeholder>
                                <section class="flex" v-else>
                                    <span class="flex-grow h-100"></span>
                                    <ApplicationStatus class="text-center h-full self-center" :application="application" :options="statuses"></ApplicationStatus>
                                    <span class="flex-grow"></span>
                                </section>
                            </td>
                            <td class="border px-8 py-2 text-center">
                                <loading-placeholder v-if="fetching_applicants"></loading-placeholder>
                                <span v-else>{{ job.deadline }}</span>
                            </td>
                            <td class="border px-8 py-2 align-items-center">
                                <loading-placeholder v-if="fetching_applicants"></loading-placeholder>
                                <div v-else class="flex mx-auto text-center" title="Edit">
                                    <span class="flex-grow"></span>
                                    <span class="text-red-500 hover:text-red-400" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                    <span class="flex-grow"></span>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="!applications.length">
                            <td class="text-center border px-8 py-4" colspan="8">
                                <loading-placeholder class="w-50" v-if="fetching_applicants"></loading-placeholder>
                                <section v-else>
                                    <span v-if="this.selected.length">There are not applications to display</span>
                                    <span v-else>You have not received any application for this job</span>
                                </section>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
    import Modal from "@/Jetstream/Modal";
    import iziToast from "izitoast";
    import "izitoast/dist/css/iziToast.min.css";
    import ApplicationStatus from "@/Custom/Job/ApplicationStatus";
    import DialogModal from "@/Jetstream/DialogModal";
    import ApplicantEmbed from "@/Pages/Company/Jobs/ApplicantEmbed";
    import ProfileEmbed from "@/Custom/Resume/ProfileEmbed";
    import CheckableDropdown from "@/Custom/CheckableDropdown";
    import LoadingPlaceholder from "@/Custom/LoadingPlaceholder";
    import NumberFilter from "@/Custom/Job/Screening/NumberFilter";
    import SelectFilter from "@/Custom/Job/Screening/SelectFilter";
    import axios from "axios";
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';

    export default {
        name: "Applications",
        components: {
            EmployerLayout,
            Head,
            Input,
            Loader,
            Link,
            TimeAgo,
            Dropdown,
            DropdownLink,
            Menu,
            MenuButton,
            MenuItems,
            MenuItem,
            Modal,
            ApplicationStatus,
            DialogModal,
            ApplicantEmbed,
            ProfileEmbed,
            CheckableDropdown,
            vSelect,
            SelectFilter,
            NumberFilter,
            LoadingPlaceholder
        },
        mounted(){
            console.log("filters are below");
            console.log(this.$page.props.applications);
            let selected_attributes = this.$page.props.job.application_display_columns??"[]";
            this.selected = JSON.parse(selected_attributes);
            /* for(let x=0; x<this.screening_options.length; x++){
                this.filter_variables.push(this.screening_options[x].label)
            } */
        },  
        data(){
            return {
                fetching_applicants: false,
                keep_filter_modal_open: false,
                current_application: null,
                candidate_modal: false,
                filter_modal: false,
                job: this.$page.props.job,
                applications: this.$page.props.applications,
                statuses: this.$page.props.statuses,
                full_profile: false,
                screening_options: this.$page.props.screening_filters,
                selected: [],
                assessments: this.$page.props.assessments,
                filter_variables: this.$page.props.filter_variables,
                display_filter_variables: [],
                filter_by_status: '',
                selected_filters: [],
            }
        },
        methods: {
            updateAssessmentFilter(event){
                this.assessments[event.index].filter_operator = event.data.filter_operator;
                this.assessments[event.index].filter_value = event.data.filter_value;
                console.log('things have update '+event.data.filter_operator);
                console.log(this.assessments);
            },
            updateSelectedFilters(data){
                //console.log(data);
                //this.selected = data;
                console.log('selected options are right below');
                console.log(data);
                this.selected_filters = data;
                console.log(this.selected_filters.length);
                this.$forceUpdate
                // save the new data
                //axios.post(route('company.job-attributes.store', this.$page.props.job.id), { data: data})
            },
            updateSelectedAttributes(data){
                //console.log(data);
                this.selected = data;
                // save the new data
                axios.post(route('company.job-attributes.store', this.$page.props.job.id), { data: data})
            },
            changeStatus(change){
                console.log(change);
                console.log('and it happened just right above man')
                let index = this.applications.findIndex(element => element.id === change.id);
                if(index >= 0 ){
                    this.$page.props.applications[index].current_status = change.status;
                    this.$page.props.applications[index].status = change.status_key;
                }
            },
            callFunction(name, args = {}){
                //return console.log(args)
                this[name].call(this, args);
            },
            switchToTab(tab){
                this.active_tab = tab;
            },
            greet(name){
                alert('hello there '+name);
            },
            transferApplication(from_status, from_index, to_status, move=true){
                let data = this.applications[from_status][from_index];
                return axios.post(route('application.change-status'), {
                    application_id: data.id,
                    to_status: to_status
                }).then((response) => {
                    if(response.data){
                        this.applications[from_status].status = to_status;
                        if(move){
                            this.applications[from_status].splice(from_index, 1);
                        }
                        //this.applications[to_status].unshift(data);
                        this.applications[to_status].push(data);

                    }
                    return true
                }).catch((error) => {
                    console.log(error.response.data);
                    return false;
                })

                //console.log(this.applications[to_status]);
            },
            reject(args){
                //alert('the application will be rejected from '+args.current_status+" index "+args.index);
                console.log(args);
                //axios.post('', )
                this.transferApplication(args.current_status, args.index, 2, args.move);
            },
            unshortlist(args){
                /*return console.log(args);
                return console.log(this.applications[args.current_status]);*/
                if(this.transferApplication(args.current_status, args.index, 1, args.move)){
                    iziToast.success({
                        title: "Success",
                        message: "Application successfully removed from shortlist"
                    })
                }
            },

            shortlist(args){
                if(this.transferApplication(args.current_status, args.index, 3, args.move)){
                    iziToast.success({
                        title: "Success",
                        message: "Application successfully added to a shortlist"
                    })
                }
            },
            scheduleInterview(args){
                return alert('you are about to schedule an interview');
                this.transferApplication(args.current_status, args.index, 4, args.move);
            },
            markInterviewed(){
                this.transferApplication(args.current_status, args.index, 5, args.move);
            },
            changeApplicationStatus(){

            },
            clearFilters(){
                this.selected_filters = [];
                this.filterApplications();
            },
            filterApplications(){
                let filters = [];
                this.fetching_applicants = true;
                if(this.filter_by_status !== ''){
                    let filter = {
                        answer: this.filter_by_status,
                        filter_operator: '=',
                        filter_value: this.filter_by_status,
                        name: 'Status',
                        type: 'status',
                    }
                    filters.push(filter);
                }


                for(let x = 0; x < this.assessments.length; x++){
                    //console.log(filters[x].filter_operator.length);
                    if(this.selected_filters.indexOf(this.assessments[x].variable_name)>-1/* this.assessments[x].filter_operator.length && this.assessments[x].filter_value */){
                        filters.push(this.assessments[x]);
                    }
                }
                console.log(this.assessments);
            

                /*console.log(filters);*/
                /*console.log('ended here');
                return;*/
                axios.post(route("job.applications.filter"), {
                    job_id: this.job.id,
                    filters: JSON.stringify(filters),
                    keyword: this.keyword,
                    limit: this.limit
                }).then((response) => {
                    //return console.log(response.data);
                    this.applications = response.data;
                    this.fetching_applicants = false;
                    if(!this.keep_filter_modal_open){
                        this.filter_modal = false;
                    }
                    //document.getElementById('close-filter-modal').click();
                    console.log(response.data)
                }).catch(error => {
                    this.fetching_applicants = false;
                    console.log(error.response.data);
                    iziToast.error({title: 'Error', message: "There was an error filtering your data"});
                })
            },
        },
        computed: {
            showFilterButtons(){
                return this.selected_filters.length;
            },
            total_application(){
                return 0;
                //return this.applications[this.active_tab].length
            },
            extra_attributes(){
                return this.screening_options.filter(item => this.selected.indexOf(item.value)>-1)
            },
            attribute_value(){
                return (type, index) => {
                    let attribute = this.applications[index].screening_responses.find(element => element.type === type);
                    return attribute.response??"-";
                } 
            }
        }
    }
</script>

<style scoped>
    
</style>
