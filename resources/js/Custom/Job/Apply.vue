<template>
    <div>
        <span class="font-bold">Cover letter</span>
        <text-editor text="" @change="coverLetterChanged"></text-editor>

        <div v-if="assessments.length">
            <assessment-render v-for="question, index in assessments" :index="index" :question="question"></assessment-render>
        </div>        
    </div>
</template>

<script>
    import TextEditor from "@/Custom/TextEditor";
    import AssessmentRender from "@/Custom/Job/Screening/AssessmentRender";
    export default {
        name: "Apply",
        components: {TextEditor},
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
            }
        },
        component: {
            TextEditor, AssessmentRender
        },
        mounted(){
            console.log('selected certificates are listed below');
            console.log(this.selected_certs)
            this.getAssessments()
        },
        data(){
            return {
                coverRequired: this.job.cover_letter,
                cover_letter: '',
                job_id: this.job.id,
                candidate_id: this.$page.props.user.candidate.id,
                typed: '',
                assessment_responses: this.assessments
            }
        },
        methods:{
            greet(){
                console.log(this.selected_certificates)
            },
            coverLetterChanged(html){
                //console.log(html);
                this.cover_letter = html;
            },
            getAssessments(){          
                axios.post(route('job.assessment.get'), {job_id: this.job_id}).then(response => {
                    this.assessments = response.data;
                }).catch(error => {
                    iziToast.error({title: "Failed", message: "Could not pull assessment information"});
                    console.log(error.response.data);
                });
            },
            sendApplication(){
                //return console.log(this.assessments)
                this.$emit('applying', true);
                this.assessment_responses = this.assessments;
                let data = this.$data;
                
                data.selected_certificates = this.selected_certs;
                //return console.log(data);
                //alert('applying');
                axios.post(route('application.send'), data).then((response) => {
                    if(response.data){
                        // applied emit applied event
                        this.$emit('applied', this.job.id);
                    }
                }).catch((error) => {
                    console.log(error.response.data);
                })
            }
        }
    }
</script>

<style scoped>

</style>
