<template>
    <employer-layout :title="'Job Assessments'">
        <div class = "col-md-9 mx-5 text-gray-600 border border-gray-200 my-2 mb-20">
            <div class="card card-header bg-gray-200 p-4">
                <h4 class="text-xl">Add Screening questions</h4>
                <button @click="logQuestions">Console Questions</button>
            </div>
            <div class="container-fluid text-justify card py-2 ">
                <span class="ml-4"><strong>See top applicants more easily by asking about their qualifications when they apply. Add screening questions below:</strong></span>
                <div class="md:grid grid-cols-12 mx-1 sticky top-16 bg-white shadow-md py-4">
                    <section class="border md:col-span-4 xl:col-span-3 py-2 mr-md-1 mt-1 mx-2 flex px-4 items-center" ><i class="bx bx-briefcase mr-2"></i><span class="col-6 flex-grow">Work Experience</span> <i class="bx bx-plus ml-2 float-right mt-1 cursor-pointer" @click="add('experience')"></i></section>
                    <section class="border md:col-span-3 xl:col-span-2 py-2 py-2 mx-md-1 mt-1 mx-2 flex px-4 items-center" ><i class="bx bx-building-house mr-2"></i><span class="col-6 flex-grow">Education</span> <i class="bx bx-plus ml-1 col-1 float-right mt-1 cursor-pointer" @click="add('education')" v-if="!attributeAdded('education')"></i><i class="bx bx-check-circle ml-1 col-1 float-right mt-1 text-green-500" v-else></i></section>
                    <section class="border md:col-span-3 xl:col-span-2 py-2 py-2 mt-1 mx-2 flex px-4 items-center" ><i class="bx bx-current-location mr-2"></i><span class="col-6 flex-grow">Location</span> <i class="bx bx-plus ml-1 col-1 float-right mt-1 cursor-pointer" @click="add('location')" v-if="!attributeAdded('location')"></i><i class="bx bx-check-circle ml-1 col-1 float-right mt-1 text-green-500" v-else></i></section>
                    <section class="border md:col-span-3 xl:col-span-2 py-2 py-2 mt-1 mx-2 flex px-4 items-center" ><i class="bx bx-certification mr-2"></i><span class="col-6 flex-grow">Certification</span> <i class="bx bx-plus ml-1 col-1 float-right mt-1 cursor-pointer" @click="add('certification')"></i></section>
                    <section class="border md:col-span-4 xl:col-span-3 py-2 mx-md-1 mt-1 mx-2 flex px-4 items-center" ><i class="bx bx-briefcase mr-2"></i><span class="col-6 flex-grow">Work Authorization</span> <i class="bx bx-plus ml-1 col-1 float-right mt-1 cursor-pointer" @click="add('authorization')" v-if="!attributeAdded('authorization')"></i><i class="bx bx-check-circle ml-1 col-1 float-right mt-1 text-green-500" v-else></i></section>
                    <section class="border md:col-span-4 xl:col-span-3 py-2 mt-1 mx-2 flex px-4 items-center" ><i class="bx bx-wrench mr-2"></i><span class="col-6 flex-grow">Expertise with tool</span> <i class="bx bx-plus ml-1 col-1 float-right mt-1 cursor-pointer" @click="add('expertise')"></i></section>
                    <section class="border md:col-span-4 xl:col-span-3 py-2 mt-1 mx-2 flex px-4 items-center" ><i class="bx bx-question-mark mr-2"></i><span class="col-6 flex-grow">Custom Question</span> <i class="bx bx-plus ml-1 col-1 float-right mt-1 cursor-pointer" @click="add('custom')"></i></section>
                </div>

                <div v-if="questions.length==0" class="my-3 mx-4 container-fluid text-center py-3 border-dotted border" style="border-style: dotted; border-color: #A5A5A5">
                    <!-- <i class='fas fa-file-alt text-primary mb-3' style="font-size:48px"></i> -->
                    <!-- <box-icon name='file' size="lg" color="green" ></box-icon> -->
                    <i class="bx bx-file text-7xl text-green-500"></i>
                    <p>Your screening questions will appear here</p>
                    <span>Add screening questions to easily find top applicants</span>
                </div>
                <div v-else-if="questions.length>0" class="my-3 container px-4 py-3" style="border-color: #A5A5A5">
                    <form method="post" @submit.prevent="submitData" action="{{Route('job.assessment.save', ['hash'=>$job->hashslug])}}" id = 'assessment-form'>
                        <div v-for="(question, index) in questions">
                            <experience @removed="remove" v-if="question.type =='experience'" :key="index" :index="index" :data="questions[index]" :name="questions[index].name" :answer="Number(questions[index].answer)" :necessity="questions[index].necessity"></experience>
                            <education @removed="remove" v-else-if="question.type == 'education'" v-bind:key="index+'edu'" :index="index" :data="questions[index]"></education>
                            <location @removed="remove" v-else-if="question.type == 'location'" v-bind:key="index+'loc'" :index="index" :data="questions[index]"></location>
                            <certification @removed="remove" v-else-if="question.type == 'certification'" v-bind:key="index+'cert'" :index="index" :data="questions[index]"></certification>
                            <authorization @removed="remove" v-else-if="question.type == 'authorization'" v-bind:key="index+'auth'" :index="index" :data="questions[index]"></authorization>
                            <expertise @removed="remove" v-else-if="question.type == 'expertise'" v-bind:key="index+'exp'" :index="index" :data="questions[index]"></expertise>
                            <custom @removed="remove" v-else-if="question.type == 'custom'" v-bind:key="index+'cust'" :index="index" :data="questions[index]"></custom>
                        </div>
                        <button type="submit" class = "hidden" id="submit-assessment">submit</button>
                    </form>
                </div>
            </div>
            <div class="card card-footer px-4 border-t py-2">
                <div class="flex">
                    <div class="col-md-6 py-2 flex-grow">
                        <Link :href="route('company.job.view', $page.props.job.slug)" id="go-to-click" ref="go-to-job" @click.prevent="skipAssessments" class="float-left text-green-500 font-bold">Skip this step</Link>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary float-right bg-green-500 text-white p-2" @click="submitAttempt" v-if="questions.length && !saving">
                            <Loader color="white" v-if="saving"></Loader>    
                            <span v-else>Continue</span>
                        </button>
                        <button class="btn btn-primary float-right bg-green-500 text-white p-4" @click="submitAttempt" v-else-if="saving" disabled>
                            <Loader color="white" v-if="saving"></Loader>   
                            <span v-else>Continue</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </employer-layout>
</template>
<script>
import EmployerLayout from "@/Layouts/EmployerLayout";
import Authorization from "@/Custom/Job/Screening/Authorization";
import Certification from "@/Custom/Job/Screening/Certification";
import Custom from "@/Custom/Job/Screening/Custom";
import Education from "@/Custom/Job/Screening/Education";
import Experience from "@/Custom/Job/Screening/Experience";
import Expertise from "@/Custom/Job/Screening/Expertise";
import Location from "@/Custom/Job/Screening/Location";
import Loader from '@/Custom/Loader';
import {Head, Link} from '@inertiajs/inertia-vue3';
import iziToast from "izitoast";
import "izitoast/dist/css/iziToast.min.css";
import axios from "axios";
export default{
    components: {
        EmployerLayout, Authorization, Certification, Custom, Education, Experience, Expertise, Location, Loader, Head, Link
    },
    mounted(){
        console.log('the element is below')
        //this.$refs['go-to-job'].click;
        //document.getElementById('go-to-job').click()
        //alert('hello')
        //iziToast.success({title: "Greeting", message: "hello Burton"});
    },
    computed:{
        attributeAdded(){
            return type => {
                return this.questions.find(element => element.type == type)
            }
        }
    },
    data(){
        return {
            greet: "Hello Peter how are you doing",
            jobLink: '{{route("job.view", $job->hashslug)}}',
            saving: false,
            added: {
                location: false,
                education: false,
                authorization: false,
            },
            experience: {
                question: "",
                name: "",
                answer: "",
                answer_type: "minimum",
                type: "experience",
                necessity: "required",
                options: null,
                input: "number"
            },
            education: {
                question: "",
                name: "",
                answer: "Yes",
                answer_type: "ideal",
                type: "education",
                necessity: "required",
                options: [
                    "Yes", "No"
                ],
                input: "select"
            },
            location: {
                question: "",
                name: "",
                answer: "Yes",
                answer_type: "ideal",
                type: "location",
                necessity: "required",
                options: [
                    "Yes", "No"
                ],
                input: "select"
            },
            certification: {
                question: "",
                name: "",
                answer: "Yes",
                answer_type: "ideal",
                type: "certification",
                necessity: "required",
                options: [
                    "Yes", "No"
                ],
                input: "select"
            },
            authorization: {
                question: "",
                name: "",
                answer: "Yes",
                answer_type: "ideal",
                type: "authorization",
                necessity: "required",
                options: [
                    "Yes", "No"
                ],
                input: "select"
            },
            expertise: {
                question: "",
                name: "",
                answer: "",
                answer_type: "minumum",
                type: "expertise",
                necessity: "required",
                options: null,
                input: "number"
            },
            customized: {
                name: "",
                answer: "",
                question: "",
                answer_type: "",
                type: "custom",
                necessity: "required",
                options: null,
                input: ""
            },
            questions: this.$page.props.assessments
        }
    },
    methods: {
        logQuestions(){
            console.log(this.questions);
        },
        remove: function(index){
            if(this.questions[index].id){
                axios.post(route('job.assessment.delete'), {question_id: this.questions[index].id}).then(response => {
                    if(response.data){
                        iziToast.success({title: "Done", message: "Assessment Deleted Permanently"})
                    }
                }).catch(error => {
                    iziToast.error({title: "Failed", message: "Question could not be deleted due to an error"})
                })
            }
            this.questions.splice(index, 1);
        },
        add: function(component){
            //alert('you are about to add '+component);
            if(component === 'experience'){
                let experience =  {
                    question: "",
                    name: "",
                    answer: "",
                    answer_type: "minimum",
                    type: "experience",
                    necessity: "required",
                    options: null,
                    input: "number"
                };
                this.questions.push(experience)
            }else if(component === 'education'){
                this.questions.push(this.education);
                this.added.education = true;
            }else if(component === 'location'){
                this.questions.push(this.location);
                this.added.location = true;
            }else if(component === 'certification'){
                let certification = {
                    question: "",
                    name: "",
                    answer: "Yes",
                    answer_type: "ideal",
                    type: "certification",
                    necessity: "required",
                    options: [
                        "Yes", "No"
                    ],
                    input: "select"
                }
                this.questions.push(certification);
            }else if(component === 'authorization'){
                this.questions.push(this.authorization);
                this.added.authorization = true;
            }else if(component === 'expertise'){
                let expertise = {
                    question: "",
                    name: "",
                    answer: "",
                    answer_type: "minimum",
                    type: "expertise",
                    necessity: "required",
                    options: null,
                    input: "number"
                }
                this.questions.push(expertise);
            }else if(component === 'custom'){
                let customized = {
                    name: "",
                    answer: "",
                    question: "",
                    answer_type: "",
                    type: "custom",
                    necessity: "required",
                    options: null,
                    input: ""
                }
                this.questions.push(customized);
            }

        },
        checker: function(){
            var i;
            for(i = 0; i<this.questions.length; i++){
                if(this.questions[i].type === 'education'){
                    this.added.education = true;
                }else if(this.questions[i].type === 'location'){
                    this.added.location = true;
                }else if(this.questions[i].type === 'authorization'){
                    this.added.authorization = true;
                }
            }
        },
        submitAttempt: function(){
            document.getElementById('submit-assessment').click();
        },
        updateQuestions: function(index, data){

        },
        skipAssessments: function(){
            window.location.replace(vue.jobLink);
        },
        submitData: function(){
            this.saving = true;
            //return iziToast.success({title: 'done', message: "It worked"});
            /* console.log('saving your assessments');
            return console.log(this.questions);
            return console.log(this.questions); */
            /* console.log(this.questions);
            return; */

            axios.post(route('job.assessment.save', this.$page.props.job.slug),
                {
                    job_id: this.$page.props.job.id,
                    data: this.questions
                }).then((response) => {
                    ///alert(JSON.stringify(response.data));
                    if(response.data){
                        iziToast.success({title: 'Done', message: "Questions successfully saved"});
                        document.getElementById('go-to-click').click();
                        //window.location.replace(route('company.job.view', this.$page.props.job.slug));
                    }
                    //vue.saving = false;
                    console.log(response.data)
                }).catch((error) => {
                    console.error(error.response.data)
                    iziToast.error({title: 'Error', message: 'There was an error saving your assessment questions'});
                    this.saving = false;
                });
        }
    },
}
</script>