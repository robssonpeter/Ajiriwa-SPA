<template>
    <section v-if="loading">
        <div class="bg-gray-300 h-4 w-20 rounded-full animate-pulse"></div>
        <br>
        <div class="bg-gray-300 h-8 w-80 rounded-full animate-pulse mt-2"></div>
        <br>
        <div class="bg-gray-300 h-4 w-full rounded-full animate-pulse"></div>
        <br>
        <div class="bg-gray-300 h-4 w-20 rounded-full animate-pulse"></div>
        <br>
        <div class="bg-gray-300 h-8 w-80 rounded-full animate-pulse mt-2"></div>
        <br>
        <div class="bg-gray-300 h-4 w-full rounded-full animate-pulse"></div>
        <br>
        <div class="bg-gray-300 h-4 w-20 rounded-full animate-pulse"></div>
        <br>
        <div class="bg-gray-300 h-8 w-80 rounded-full animate-pulse mt-2"></div>
        <br>
        <div class="bg-gray-300 h-4 w-full rounded-full animate-pulse"></div>
        <br>
    </section>
    <section v-else-if="!loading && !can_apply.status">
        <div class="p-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                class="w-16 h-16 mx-auto text-green-500 border border-green-500 rounded-full">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>

        </div>
        <h2 class="text-xl font-semibold text-green-500 mb-4">{{ can_apply.title }}</h2>
        <section v-html="can_apply.message">
        </section>
        <section class="flex space-x-1">
            <span class="flex-grow"></span>
            <button v-for="link in can_apply.links" @click.prevent="goToLink(link.url)"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300">
                {{ link.label }}
            </button>
        </section>
    </section>
    <div class="animate__animated animate__fadeInUp" v-else-if="!loading && can_apply.status">
        <span class="font-bold">Cover letter</span>
        <text-editor :text="cover ? cover : ''" @change="coverLetterChanged"></text-editor>

        <div v-if="assessments.length">
            <assessment-render @changed="questionAnswered" v-for="question, index in assessments" :index="index"
                :question="question"></assessment-render>
        </div>
    </div>
</template>

<script>
import TextEditor from "@/Custom/TextEditor";
import AssessmentRender from "@/Custom/Job/Screening/AssessmentRender";
import iziToast from "izitoast";
import 'izitoast/dist/css/iziToast.min.css'
import axios from "axios";
import { Link } from "@inertiajs/inertia-vue3";
export default {
    name: "Apply",
    components: { TextEditor, Link },
    props: {
        job: {
            type: Object
        },
        certificates: {
            type: Object,
        },
        selected_certs: {
            type: Array,
        },
        assessments: {
            type: Array,
        },
        cover: {
            required: false
        }
    },
    component: {
        TextEditor, AssessmentRender
    },
    mounted() {
        console.log('selected certificates are listed below');
        console.log(this.selected_certs)
        this.getAssessments();
        if (this.cover) {
            this.cover_letter = this.cover;
        }
        this.checkApplicability();
    },
    data() {
        return {
            can_apply: {

            },
            coverRequired: this.job.cover_letter,
            cover_letter: '',
            job_id: this.job.id,
            candidate_id: this.$page.props.user.candidate.id,
            typed: '',
            assessment_responses: this.assessments,
            loading: false,
        }
    },
    methods: {
        checkApplicability() {
            this.loading = true;
            this.$emit('loading', true);
            //alert('checking the applicability')
            
            axios.post(route('job.can-apply'), { job_id: this.job.id }).then((response) => {
                this.can_apply = response.data;
                this.$emit('can_apply', response.data.status);
                console.log(response.data)
            }).catch((error) => console.error(error.response.data));
            setTimeout(() => {
                console.log('Waiting for sometime');
                this.loading = false;
                this.$emit('loaded', true);
            }, 3000);
            return '';
        },
        greet() {
            console.log(this.selected_certificates)
        },
        coverLetterChanged(html) {
            //console.log(html);
            this.cover_letter = html;
        },
        questionAnswered(data) {
            let index = this.current_assessments.findIndex(element => element.id === data.question_id);
            this.current_assessments[index].applicant_answer = data.answer;
            console.log(data.answer);
        },
        getAssessments() {
            axios.post(route('job.assessment.get'), { job_id: this.job_id }).then(response => {
                this.assessments = response.data;
            })/* .catch(error => {
                iziToast.error({ title: "Failed", message: "Could not pull assessment information" });
                console.log(error.response.data);
            }); */
        },
        goToLink(link) {
            this.sendApplication('store', link);
            this.$inertia.visit(link);

        },
        rememberDetails() {
            // temporarily store the applications details in a session variable
            this.sendApplication('store');
        },
        sendApplication(type, redirect_url = null) {
            // type can be 'apply' or 'store'
            //return console.log(this.assessments)
            let url;
            if (type === 'apply') {
                url = route('application.send');
                this.$emit('applying', true);
            } else if (type === 'store') { // for storing the response temporarily
                url = route('application.store');
                this.$emit('storing', true);
            }

            this.assessment_responses = this.assessments;
            let data = this.$data;

            data.selected_certificates = this.selected_certs;

            axios.post(url, data).then((response) => {
                if (response.data) {
                    // applied emit applied event
                    if (type === 'apply') {
                        this.$emit('applied', this.job.id);
                    } else if (type === 'store') {
                        // if the redirect url is specified, send the user to that link
                        if(redirect_url){
                            this.$emit('stored', redirect_url);
                        }else{
                            this.$emit('stored', route('my-resume.edit.sectional', 'awards'));
                        }
                    }
                }
            }).catch((error) => {
                let message;
                if (type === 'apply') {
                    message = "Application could not be sent";
                } else {
                    message = "Application could not be stored";
                }
                iziToast.error({ title: "Failed", message: message })
                console.log(error.response.data);
            })
        }
    }
}
</script>

<style scoped></style>
