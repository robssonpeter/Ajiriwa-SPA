import {createApp} from "vue";
import TextEditor from "@/Custom/TextEditor";
import iziToast from "izitoast";
import 'izitoast/dist/css/iziToast.min.css'
import Apply from "@/Custom/Job/Apply";
import {
    Dialog,
    DialogTitle,
    DialogDescription,
    TransitionRoot,
    TransitionChild,
} from "@headlessui/vue";
import Loader from "@/Custom/Loader";
import axios from "axios";

createApp({
    components: {
        Dialog, DialogTitle, DialogDescription, TransitionRoot,
        TransitionChild, TextEditor, Loader, Apply, axios
    },
    data(){
        return {
            currently_applying: false,
            current_job: job,
            current_assessments: [],
            certificates: certificates,
            selected_certs: [],
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
            job: job,
        }
    },
    mounted(){
        console.log(this.job);
        alert('things are happening')
    },
    methods: {
        getAssessments() {
            if (this.current_job.id) {
                axios.post(assessmentUrl, { job_id: this.current_job.id }).then(response => {
                    this.current_assessments = response.data;
                }).catch(error => {
                    iziToast.error({ title: "Failed", message: "Could not pull assessment information" });
                    console.log(error.response.data);
                });
            }
        },
        applying(status) {
            //alert(status);
            this.currently_applying = status;
        },
        apply() {
            this.$refs.apply.sendApplication();
        }
    }
}).mount('#apply-page');
