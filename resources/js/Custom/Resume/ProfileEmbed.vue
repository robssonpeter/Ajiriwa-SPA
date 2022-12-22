<template>
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-600">
            <div class="col-span-2 text-gray-600">
                <div class="w3-card w3-white w3-margin-bottom">
                    <!--<meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://www.ajiriwa.net/css/w3.css">-->

                    <div class="container text-gray-700 body bg-white shadow-md" v-if="candidate">
                        <div class="">
                            <h1 class="text-center text-3xl ">
                                CURRICULUM VITAE
                            </h1>
                            <p>
                                <strong></strong>
                            </p>
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                PERSONAL PARTICULARS
                            </h2>
                            <div class="px-2">
                            <span>
                            <span style="font-weight: bold">Name</span>
                            <strong>:</strong>
                            {{ fullName }}    </span><br>
                                                <span>
                            <strong>Date </strong>
                            <strong>of </strong>
                            <strong>Birth:</strong>
                            {{ candidate.dob_formatted }}
                        </span><br>
                                                <span>
                            <strong>Nationality:</strong>
                            {{ candidate.nationality }}</span><br>
                                                <span>
                            <strong>Sex:</strong>
                            {{ candidate.sex?candidate.sex.name:'' }}</span><br>
                                                <span>
                            <strong>Marital status:</strong>
                            {{ candidate.marital?candidate.marital.marital_status:'' }}</span><br>
                                                <span>
                            <strong>Phone Number:</strong>
                            {{ candidate.phone }}</span><br>
                                                <span>
                            <strong>Email Address:</strong>
                            {{ candidate.email }}   </span>
                            </div>

                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                PERSONAL PROFILE
                            </h2>

                            <p class="px-2" v-html="candidate.career_objective"></p>
                            <!--<p class="bg-green-500">
          text-white                       <strong>CAREER OBJECTIVES</strong>
                            </p>
                            <p>
                                <strong> </strong>
                            </p>
                            <p>
                                To earn a job that utilizes my skills and experience, to succeed in an
                                environment of growth and excellence, to work hard with full
                                determination and dedication and to achieve personal as well as
                                organizational goals.
                            </p>
                            <p>-->
                            <section class="mt-2" v-if="experiences && experiences.length">
                                <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                    WORK EXPERIENCE
                                </h2>
                                <div class="px-2">
                                <p v-for="experience in experiences">
                                    <span style="font-weight: bold" class="font-light">{{ experience.start_date_formatted }} - </span>
                                    <span :class="experience.currently_working?'font-bold text-green-400':'font-bold'">{{ experience.currently_working?'Present': experience.end_date_formatted }}</span>
                                    <span class="w3-text-green ml-1" style="font-weight: bold">{{ experience.company }}</span>
                                    : <em>{{ experience.title }}</em><strong></strong>
                                    <br><span>{{ experience.description }}</span>
                                </p>
                                <p></p>
                                </div>
                            </section>
                            <section class="mt-2" v-if="education && education.length">
                                <h2 class="bg-green-400 text-xl text-white px-2">
                                    EDUCATION AND QUALIFICATIONS
                                </h2>
                                <p class="px-2" v-for="education in education">
                                    <span class="font-bold">{{ education.start_year }} - </span>
                                    <span :class="education.currently_studying?'font-bold text-green-400':'font-bold'">{{ education.currently_studying?'Present':education.year }}</span>
                                    <span class="w3-text-green ml-1" style="font-weight: bold">{{  education.degree_title }}</span>
                                    : <em>{{  education.institute }}</em><strong></strong>
                                </p>
                            </section>
                        </div>

<!--                        <div>
                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                ACHIEVEMENTS
                            </h2>
                            <div class="px-2">
                            <p><b>Development of ajiriwa.net recruitment platform</b>&nbsp; - with inspration from
                                working
                                at the HR Department at DHL Supply Chain. The platform connects employers and job
                                seekers,
                                assisting employers to get the candidate they need and allowing job seekers to be found,
                                the
                                platform would even assist people in making a professional CV. This CV was create using
                                the
                                platform.<br></p>
                            <p><strong>Development of a payroll management software</strong>&nbsp;which handles a
                                company's
                                payroll and employement management needs. Trial version of the software is live at
                                https://payroll.ajiriwa.net</p>
                            </div>
                        </div>-->

                        <section class="mt-2" v-if="candidate.skills && candidate.skills.length">
                        <div>
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                SKILLS
                            </h2>
                        </div>
                        <div class="px-2">
                            <table class="text-gray-700">
                                <tbody>
                                <tr v-for="skill in candidate.skills">
                                    <td width="215">
						                <span>§ {{ skill.name }}</span>
                                    </td>
                                    <td width="215">
						                <span>{{ skillLabel(skill.rating) }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        </section>

                        <!--<div>
                            <p class="bg-green-500">
          text-white                       <strong>COMPUTER AND INFORMATION TECHNOLOGY SKILLS</strong>
                            </p>
                        </div>-->


                        <section class="mt-2" v-if="languages && languages.length">
                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                LANGUAGE PROFICIENCY
                            </h2>
                            <div class="px-2">
                            <p v-for="language in languages">
                                § {{ language.name }}: {{ language.rating_label }}
                                <!--<br>Speaking - <em>Advanced</em>, Listening - <em>Advanced</em>, Writing - <em>Advanced</em>, Reading - <em>Advanced</em>-->
                            </p>
                            </div>
                        </section>
<!--                        <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                            PERSONAL INTERESTS, HOBBIES AND TALENTS
                        </h2>
                        <div class="px-2"><p><b>Programming </b>- I enjoy coding and spend most of my free time doing so, to solve
                            problems</p>
                            <p><br></p></div>

                        <div>-->
                        <section class="mt-2" v-if="referees && referees.length">
                            <div>
                                <h2 class="bg-green-400 text-xl text-white px-2 ">
                                    REFEREES
                                </h2>
                            </div>
                            <div class="w3-border-bottom px-2">
                            <span class="text-sm">
                                Apart from my personal information mentioned in this Curriculum Vitae
                                other information with some recommendations may be sought freely from:
                            </span>
                            <div v-for="referee in referees">
                                <p><strong>{{ referee.name }}</strong></p>
                                <p>{{ referee.company }}</p>
                                <p>{{ referee.phone }}</p>
                                <p></p>
                                <p>Email: {{ referee.email }}</p>
                            </div>
                        </div>
                        </section>
                    </div>


                    <!-- End Right Column -->
                </div>


                <!-- End Grid -->
            </div>

            <!-- End Page Container -->
        </div>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import Swal from "sweetalert2";
    import Loader from "@/Custom/Loader";
    import BreadCrumb from "@/Custom/BreadCrumb";
    import {Head, Link} from '@inertiajs/inertia-vue3';
    import iziToast from "izitoast";

    export default {
        name: "MyResume",
        components: {
            AppLayout, Loader, BreadCrumb, Head, Link
        },
        props: {
            candidate: {
                type: Object
            },
            show_profile: {
                type: Boolean
            }
        },
        mounted(){
            /* if(this.candidate.skills){

            }else{ */
                this.getCandidateInfo();
            /* } */
            //console.log(this.candidate)
            //this.$refs.profile_overview.style.backgroundImage = "url("+this.candidate.logo_url+")";
            //console.log(this.skills[4])
        },
        data(){
            return {
                skills:{},
                experiences: [],
                languages: [],
                education: [],
                referees: [],
                /*profile_picture: this.$props.candidate.logo_url,*/
                loading: false,
                dp_upload_progress: 0,
                saving: {
                    dp: false,
                }
            }
        },
        computed: {
            fullName(){
                return this.candidate.first_name? this.candidate.first_name+" "+this.candidate.last_name : ''
            },
            currentLogo(){
                return this.current_logo.length?this.current_logo:this.company.logo_url;
            }
        },
        methods: {
            skillLabel(level){
                let skills = Object.values(this.skills);
                return skills[level-2];
            },
            getCandidateInfo(){
                this.loading = true;
                axios.post(route('candidate.get-info', this.candidate.id)).then(response => {
                    //console.log(response.data);
                    //this.candidate = response.data.candidate;
                    this.skills = response.data.skills;
                    this.experiences = response.data.candidate.experiences;
                    this.education = response.data.candidate.education;
                    this.referees = response.data.candidate.referees;
                    this.languages = response.data.candidate.languages;
                    this.loading = false;
                }).catch(error => {
                    iziToast.error({title: "Failed", message: "Information could not be fetched due to an error"});
                    console.log(error.response.data);
                    this.loading = false;
                })
            }
        }
    }
</script>

<style scoped>
    #profile-overview {
        /*background-image: url("https://www.ajiriwa.net");*/
        background-size: cover;
    }
</style>
