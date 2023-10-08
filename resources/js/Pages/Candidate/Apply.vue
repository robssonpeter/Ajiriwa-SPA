<template>
  <app-layout :title="'Applying for ' + $page.props.job.title">
    <div class="min-h-screen w-100 grid grid-cols-4 items-center justify-center" id="apply-page">
      <div class="md:col-span-1 "></div>
      <div class="bg-white shadow-md rounded-lg p-8 mx-4 col-span-4 md:col-span-2">
        <h2 class="text-2xl font-semibold mb-4">Applying for <a class="text-green-500" :href="route('job.view', $page.props.job.slug)">{{ $page.props.job.title }}</a></h2>
        <form @submit.prevent="apply">
          <!-- <apply :job="$page.props.job" :assessments="current_assessments" :certificates="certificates" :selected_certs="selected_certs"></apply> -->
          
          <section class="w-100">
            <apply 
              :cover="application.cover_letter" 
              :assessments="current_assessments" 
              :candidate="$page.props.user.candidate.id" 
              :job="current_job" 
              :selected_certs="selected_certs" 
              :ref="'apply'" 
              @stored="navigateAway" 
              @applied="doneApplying" 
              @loading="loading = true"
              @loaded="loading = false"
              @can_apply="canApply"
              @applying="applying">
            </apply>
          </section>

          <section class="flex flex-col py-2" v-if="!loading && can_apply">
            <section class="flex">
              <span class="font-bold flex-grow">Attachments</span>
              <small class="cursor-pointer text-green-500" @click="rememberDetails">Manage Attachments</small>
              <Link ref="manage_attachments" :href="route('my-resume.edit.sectional', 'awards')"></Link>
            </section>
            <v-select :options="certificates" v-model="selected_certs" multiple></v-select>
          </section>
          <div v-if="current_assessments.length">
            <assessment-render :answer="question.applicant_answer" @changed="questionAnswered" v-for="question in current_assessments"
              :question="question"></assessment-render>
          </div>
          <div v-if="loading" class="bg-green-500 h-8 w-12 rounded-md animate-pulse float-right"></div>
          <button v-else-if="can_apply" @click="$refs['submit-application'].click()" :disabled="currently_applying"
            class="bg-green-500 hover:shadow-lg text-white p-2 flex flex-row rounded-md mt-2 float-right">
            <span class="flex-grow"></span>
            <loader v-if="currently_applying" :color="'white'"></loader>
            <span v-else>Apply</span>
            <span class="flex-grow"></span>
          </button>
          <button type="submit" class="hidden" ref="submit-application">send</button>
          <Link :href="route('jobs.browse')" id="go-to-jobs">
          </Link>
        </form>
      </div>
      <div class="md:col-span-1"></div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import { Head, Link } from '@inertiajs/inertia-vue3';
import Loader from "@/Custom/Loader";
import TextEditor from "@/Custom/TextEditor";
import iziToast from "izitoast";
import 'izitoast/dist/css/iziToast.min.css'
import Apply from "@/Custom/Job/Apply";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css'
import AssessmentRender from "@/Custom/Job/Screening/AssessmentRender";
//import DataT
export default {
  name: "Applying",
  props: {
    title: String,
  },
  components: {
    AppLayout,
    Head,
    Loader,
    Link,
    Apply,
    TextEditor,
    vSelect,
    AssessmentRender
  },
  mounted() {
    console.log(this.job);
    if(this.$page.props.applied){
      iziToast.info({title: "Info", message:"You've already applied for the position"});
      this.$inertia.visit(route('jobs.browse'));
    }
    //alert('things are happening')
    this.getAssessments();
    if(this.$page.props.remembered){
      let remembered = this.$page.props.remembered;
            this.selected_certs = remembered.selected_certificates;
            this.current_assessments = remembered.assessment_responses;
            this.application.cover_letter = remembered.cover_letter;
            this.assessment_responses = this.$page.props.remembered.assessment_responses;
        }
  },
  data() {
    return {
      currently_applying: false,
      current_job: this.$page.props.job,
      current_assessments: [],
      certificates: this.$page.props.certificates,
      selected_certs: [],
      application_means: {
        show_modal: false,
      },
      guest_application: {
        show_modal: false,
      },
      application: {
        name: '',
        email: '',
        cover_letter: '',
        attachments: []
      },
      //applying: false,
      job: this.$page.props.job,
      loading: false,
      can_apply: false,
    }
  },
  methods: {
    getAssessments() {
      if (this.current_job.id) {
        axios.post(route('job.assessment.get'), { job_id: this.current_job.id }).then(response => {
          this.current_assessments = response.data;
        }).catch(error => {
          iziToast.error({ title: "Failed", message: "Could not pull assessment information" });
          console.log(error.response.data);
        });
      }
    },
    canApply(status){
      this.can_apply = status;
    },
    applying(status) {
      //alert(status);
      this.currently_applying = status;
    },
    apply() {
      this.$refs.apply.sendApplication('apply');
    },
    questionAnswered(data) {
      let index = this.current_assessments.findIndex(element => element.id === data.question_id);
      this.current_assessments[index].applicant_answer = data.answer;
      //alert('things are happening')
      console.log(data)
    },
    rememberDetails(){
      // temporarily store the applications details in a session
      this.$refs.apply.sendApplication('store');
    },
    navigateAway(url){
      this.$inertia.visit(url)
    },
    doneApplying(job) {
      // close the modal
      //this.apply_modal = false;

      this.currently_applying = false;

      console.log(job);

      // update the entry where the job exists
      this.current_job.applied = true;

      //this.applied_jobs.push(this.current_job.id);

      iziToast.success({
        title: "Done",
        message: "Your application has been sent"
      })
      document.getElementById('go-to-jobs').click();
    },
  }

}
</script>

<style scoped></style>
