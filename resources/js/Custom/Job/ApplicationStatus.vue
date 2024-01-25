<template>
    <div class="self-center">
        <dropdown align="right" width="48" class="hidden md:block float-right">
            <template #trigger>
                <span class="inline-flex rounded-md">
                    <button type="button" :disabled="changing" :class="status_color">
                        <section v-if="!changing" class="flex flex-row">
                            <span class="self-center">{{ status_label }}</span>

                            <svg v-if="options && application.current_status !== 'Rejected'" class="ml-2 -mr-0.5 h-4 w-4 self-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </section>
                        <Loader v-else :color="current_color" css_class="p-1"></Loader>
                    </button>
                </span>
            </template>

            <template #content v-if="options && application.current_status !== 'Rejected'">
                <dropdown-link :key="`${application.id}-status-${index}`" as="button"  v-for="(status, index) in options" @click="changed(status, index)">
                    {{ status }}
                </dropdown-link>
            </template>
        </dropdown>
        <dialog-modal :show="show_interview_modal" closeable="true" :max-width="'xl'">
            <template v-slot:title>
                <div class="flex flex-row">
                    <span class="flex-grow text-gray-500 font-bold">Schedule Interview</span>
                    <button @click="show_interview_modal = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
            <template v-slot:content>
                <form action="" @submit.prevent="interviewSet" id="hello there">
                    <section class="flex flex-col font-bold text-gray-500">   
                        <label for="interview_type">Select Interview Type</label> 
                        <select name="interview_type" v-model="interview_schedule_details.type" required id="interview_type" class="p-1 border border-gray-300 text-gray-600">
                            <option value="">Interview Type</option> 
                            <option value="1">Face to Face</option>
                            <option value="2">Telephone</option>
                            <option value="3">Virtual</option>
                        </select> 
                    </section>
                    <div class="pt-4 flex flex-col font-bold text-gray-500">
                        <label for="venue">Venue</label> 
                        <input type="text" v-model="interview_schedule_details.venue" placeholder="Where the interview will take place" required class="p-2 border border-gray-300 text-gray-600">
                    </div> 
                    <section class="pt-4 flex flex-col font-bold text-gray-500"> 
                        <label for="">Pick the date and time</label> 
                        <div class="input-group mb-3 flex">
                            <input type="date" required v-model="interview_schedule_details.date" placeholder="date" aria-label="" class="flex-grow p-2 border border-gray-300 text-gray-600"> 
                            <div class="input-group-prepend">
                                <input type="time" required v-model="interview_schedule_details.time" class="p-2 border border-gray-300 text-gray-600">
                            </div>
                        </div> 
                    </section>
                    <div class="pt-4 flex flex-col font-bold text-gray-500">
                        <label for="notes">Notes for the candidate</label> 
                        <textarea type="text" id="notes" v-model="interview_schedule_details.notes" placeholder="Any additional instructions" class="flex-grow p-2 border border-gray-300 text-gray-600"></textarea>
                    </div> 
                    <div class="pt-4 font-bold text-gray-500 flex">
                        <input type="checkbox" :checked="interview_schedule_details.clear_form" class="self-center" name="do not clear" id="">
                        <span class="self-center ml-2">Clear this form when done</span>
                    </div>
                    
                    <input type="submit" ref="submit-schedule" id="submit-schedule" value="submit" class="invisible" style="height: 0px;">
                </form>
            </template>
            <template v-slot:footer>
                <button :disabled="interview_schedule_details.saving" class="bg-green-500 text-white text-sm rounded-md p-1" @click="$refs['submit-schedule'].click()">
                    <loader color="white" v-if="interview_schedule_details.saving"></loader>
                    <span v-else>Save Changes</span>
                </button>
            </template>
        </dialog-modal>
    </div>
</template>

<script>
import Dropdown from "@/Jetstream/Dropdown";
import DropdownLink from "@/Jetstream/DropdownLink";
import Loader from "@/Custom/Loader";
import Swal from "sweetalert2";
import iziToast from "izitoast";
import DialogModal from "@/Jetstream/DialogModal";
import axios from "axios";
export default {
    name: "ApplicationStatus",
    props: {
        application: {
            type: Object,
            required: true,
        },
        options: {
            type: Array,
        }
    },
    components: {
        Dropdown, DropdownLink, Loader, DialogModal
    },
    mounted() {
        this.status_code = this.application.status;
        this.status_label = this.application.current_status;
    
        if(this.application.interview){
            this.interview_schedule_details.type = this.application.interview.interview_type;
            this.interview_schedule_details.venue = this.application.interview.venue;
            this.interview_schedule_details.date = this.application.interview.date;
            this.interview_schedule_details.time = this.application.interview.time;
            this.interview_schedule_details.notes = this.application.interview.notes;
        }
    },
    computed: {
        status_color(){
            /*let classList = this.status_classes.Draft??'';
            return ''*/
            if(this.changing){
                return '';
            }
            let labelArray = this.status_label.split(' ');
            //console.log(labelArray);
            let array = labelArray.map(string => {
                let first = string[0].toUpperCase();
                let last = string.slice(1);
                return first+last;
            });
            return this.status_classes[array.join('')];
        },
        current_color(){
            return this.status_colors[this.status_label];
        }
    },
    data(){
        return {
            changing: false,
            show_interview_modal: false,
            interview_schedule_details: {
                type: '',
                venue: '',
                date: '',
                time: '',
                notes: '',
                saving: false,
                clear_form: true,
            },  
            status_label: 'Selected',
            status_code: '',
            status_classes: {
                Selected: 'border border-green-500 inline-flex items-center px-3 py-2 self-center text-sm leading-4 font-medium rounded-md text-green-500 hover:text-gray-700 focus:outline-none transition',
                Shortlisted: 'border border-blue-500 inline-flex items-center px-3 py-2 self-center text-sm leading-4 font-medium rounded-md text-blue-500 hover:text-gray-700 focus:outline-none transition',
                Rejected: 'border border-red-500 inline-flex items-center px-3 py-2 self-center text-sm leading-4 font-medium rounded-md text-red-500 hover:text-gray-700 focus:outline-none transition',
                Applied: 'border border-gray-500 inline-flex items-center px-3 py-2 self-center text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition',
                Interviewed: 'border border-yellow-500 inline-flex items-center px-3 py-2 self-center text-sm leading-4 font-medium rounded-md text-yellow-500 hover:text-gray-700 focus:outline-none transition',
                ToBeInterviewed: 'border border-yellow-500 inline-flex items-center px-3 py-2 self-center text-sm leading-4 font-medium rounded-md text-yellow-500 hover:text-gray-700 focus:outline-none transition',
            },
            status_colors: {
                Drafted: 'black',
                Applied: 'gray',
                Rejected: 'Red',
                Shortlisted: 'blue',
                ToBeInterviewed: 'yellow',
                Interviewed: 'yellow',
            }
        }
    },
    methods: {
        interviewSet(){
            this.interview_schedule_details.saving = true;
            this.interview_schedule_details.application_id = this.application.id;
            console.log(this.interview_schedule_details);
            axios.post(route('company.schedule-interview'), this.interview_schedule_details).then((response) => {
                this.interview_schedule_details.saving = false;
                iziToast.success({title: "Scheduled Successfully", message: "A notification will be sent to candidate"});
                
                // close the modal
                this.show_interview_modal = false;
                // change the status of the application
                let status = this.interview_schedule_details.status;
                let index = this.interview_schedule_details.index;
                let clear_form = this.interview_schedule_details.clear_form;
                this.changeStatus(status, index)
                // clear the interview modal windows
                if(clear_form){
                    this.interview_schedule_details = {
                        type: '',
                        venue: '',
                        date: '',
                        time: '',
                        notes: '',
                        saving: false,
                        clear_form: true,
                    };   
                }
            }).catch((error) => {
                this.interview_schedule_details.saving = false;
                console.log(error.response.data)
            })
        },
        changed(status, index){            
            // do not run the script if its already on that status
            if(this.status_code == index){
                this.changing = false;
                return iziToast.info({title: 'Done', message: "You've done that already"});
        
            }

            if(this.options[index] === 'To be interviewed'){
                this.interview_schedule_details.status = status;
                this.interview_schedule_details.index = index;

                // show the interview schedule modal
                this.show_interview_modal = true;
                //alert('remember to schedule an interview');
            }else{
                this.changeStatus(status, index);
            }
        },
        changeStatus(status, index){
            this.changing = true;
            //return console.log(status);
            axios.post(route('application.change-status'), { application_id: this.application.id, status: index }).then((response) => {
                //if(response.data){
                    this.status_label = status;
                //}
                this.status_code = index;
                this.changing = false;
                this.$emit('change', {status:status, id: this.application.id, status_key: index});
            }).catch((error) => {
                Swal.fire('Failed', 'Status could not be updated', 'error');
                console.log(error.response.data);
                this.changing = false;
            });
        }
    }
}
</script>

<style scoped>

</style>
