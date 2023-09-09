<template>
    <div>
        <span class="font-bold">Cover letter</span>
        <text-editor :text="cover?cover:''" @change="coverLetterChanged"></text-editor>

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
export default {
    name: "Apply",
    components: { TextEditor },
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
        if(this.cover){
            this.cover_letter = this.cover;
        }
    },
    data() {
        return {
            coverRequired: this.job.cover_letter,
            cover_letter: '',
            job_id: this.job.id,
            candidate_id: this.$page.props.user.candidate.id,
            typed: '',
            assessment_responses: this.assessments
        }
    },
    methods: {
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
        rememberDetails() {
            // temporarily store the applications details in a session variable
            this.sendApplication('store');
        },
        sendApplication(type="apply") {
            //return console.log(this.assessments)
            let url;
            if(type === 'apply'){
                url = route('application.send');
                this.$emit('applying', true);
            }else if (type === 'store'){ // for storing the response temporarily
                url = route('application.store');
                this.$emit('storing', true);
            }
            
            this.assessment_responses = this.assessments;
            let data = this.$data;

            data.selected_certificates = this.selected_certs;
            
            axios.post(url, data).then((response) => {
                if (response.data) {
                    // applied emit applied event
                    if (type === 'apply'){
                        this.$emit('applied', this.job.id);
                    }else if (type === 'store'){
                        this.$emit('stored', route('my-resume.edit.sectional', 'awards'));
                    }
                }
            }).catch((error) => {
                let message;
                if (type === 'apply'){
                    message = "Application could not be sent";
                }else {
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
