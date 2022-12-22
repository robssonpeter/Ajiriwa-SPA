<template>
    <app-layout title="Browse Jobs">
        <div class="max-w-7xl mx-auto sm:px-6 sticky top-12 md:top-14 z-40 border-gray-300">
            <BreadCrumb :links="$page.props.breadcrumb" :actions="$page.props.breadcrumb_actions"></BreadCrumb>
        </div>
        <div class="md:grid md:grid-cols-3 gap-4 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-600">
            <!-- Left Column -->
            <div class="col-span-1 ">

                <div class="bg-white text-grey my-6 sticky top-28 b-2 border-gray-200 shadow-sm">
                    <div class="w-100 bg-gray-100 md:-mt-16 mt-2">
                        <span class="ml-2 mt-1 mr-1 absolute justify-center" id="add-logo" @click="">
                            <button class="active bg-green-400 text-white rounded-md mt-1 p-1 text-sm" :disabled="saving.dp" href="#home"
                               @click.prevent="$refs.profile.click()"
                               id="changeDp">
                                <Loader color="white" v-if="saving.dp"></Loader>
                                <span v-else>Change Picture</span>
                            </button>
                        </span>
                        <input type="file" class="hidden" name="profile" ref="profile" @change="uploadProfilePic">
                        <img :src="currentLogo" class="object-contain" :style="{ 'height': 'auto', 'width': 'auto', 'object-fit': 'contain', 'object-position': logoPosition }">
                        <div class="bg-gray-100 bg-opacity-50 text-black px-2">
                            <h2 class="text-3xl">{{ fullName }}</h2>
                        </div>
                    </div>
                    <div class="w3-container pb-3 shadow-md mt-4">
                        <div class="text-grey flex py-4 px-2" id="certificateHeader">
                            <span class="flex-grow text-2xl">Certificates</span>
                            <Link class="bg-green-500 self-center" :href="route('my-resume.edit.sectional', 'awards')">Manage</Link>
                        </div>
                        <ul class="list-1 gap-y-4 px-2" style="margin-left: auto; margin-right: auto;">
                            <li class="bullet text-grey flex hover:text-green-500 mt-2" v-for="certificate in $page.props.candidate.certificates">
                                <span class="flex-grow">{{ certificate.name }}</span>
                                <a class="button" target="_blank"
                                   :href="certificate.media_url">
                                    <span
                                        class="border-2 text-green-500 px-2 rounded-md border-green-500 hover:bg-green-500 hover:text-white">View</span></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- End Left Column -->
            </div>

            <!-- Right Column -->
            <div class="col-span-2 text-gray-600">
                <div class="w3-card w3-white w3-margin-bottom">
                    <title>Peter Robert Mgembe Resume</title>
                    <!--<meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" href="https://www.ajiriwa.net/css/w3.css">-->

                    <div class="container text-gray-700 body bg-white shadow-md">
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
                            {{ $page.props.candidate.dob_formatted }}
                        </span><br>
                                                <span>
                            <strong>Nationality:</strong>
                            {{ $page.props.candidate.nationality }}</span><br>
                                                <span>
                            <strong>Sex:</strong>
                            {{ $page.props.candidate?$page.props.candidate.sex.name:'' }}</span><br>
                                                <span>
                            <strong>Marital status:</strong>
                            {{ $page.props.candidate.marital?$page.props.candidate.marital.marital_status:'' }}</span><br>
                                                <span>
                            <strong>Phone Number:</strong>
                            {{ $page.props.candidate.phone }}</span><br>
                                                <span>
                            <strong>Email Address:</strong>
                            {{ $page.props.user.email }}   </span>
                            </div>

                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                PERSONAL PROFILE
                            </h2>

                            <p class="px-2" v-html="$page.props.candidate.career_objective"></p>
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
                            <section class="mt-2" v-if="$page.props.candidate.experiences.length">
                                <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                    WORK EXPERIENCE
                                </h2>
                                <div class="px-2">
                                <p v-for="experience in $page.props.candidate.experiences">
                                    <span style="font-weight: bold" class="font-light">{{ experience.start_date_formatted }} - </span>
                                    <span :class="experience.currently_working?'font-bold text-green-400':'font-bold'">{{ experience.currently_working?'Present': experience.end_date_formatted }}</span>
                                    <span class="w3-text-green ml-1" style="font-weight: bold">{{ experience.company }}</span>
                                    : <em>{{ experience.title }}</em><strong></strong>
                                    <br><span>{{ experience.description }}</span>
                                </p>
                                <p></p>
                                </div>
                            </section>
                            <section class="mt-2" v-if="$page.props.candidate.education.length">
                                <h2 class="bg-green-400 text-xl text-white px-2">
                                    EDUCATION AND QUALIFICATIONS
                                </h2>
                                <p class="px-2" v-for="education in $page.props.candidate.education">
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

                        <section class="mt-2" v-if="$page.props.candidate.skills.length">
                        <div>
                            <h2 class="bg-green-400 text-xl text-white px-2">
                                SKILLS
                            </h2>
                        </div>
                        <div class="px-2">
                            <table class="text-gray-700">
                                <tbody>
                                <tr v-for="skill in $page.props.candidate.skills">
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


                        <section class="mt-2" v-if="$page.props.candidate.languages.length">
                            <h2 class="bg-green-400 text-xl text-white mt-4 px-2">
                                LANGUAGE PROFICIENCY
                            </h2>
                            <div class="px-2">
                            <p v-for="language in $page.props.candidate.languages">
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
                        <section class="mt-2" v-if="$page.props.candidate.referees.length">
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
                            <div v-for="referee in $page.props.candidate.referees">
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
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import Swal from "sweetalert2";
    import Loader from "@/Custom/Loader";
    import BreadCrumb from "@/Custom/BreadCrumb";
    import {Head, Link} from '@inertiajs/inertia-vue3';

    export default {
        name: "MyResume",
        components: {
            AppLayout, Loader, BreadCrumb, Head, Link
        },
        mounted(){
            console.log(this.$page.props.candidate)
            //this.$refs.profile_overview.style.backgroundImage = "url("+this.candidate.logo_url+")";
            //console.log(this.skills[4])
        },
        data(){
            return {
                candidate: this.$page.props.candidate,
                skills: this.$page.props.skills,
                /*profile_picture: this.$props.candidate.logo_url,*/
                current_logo: this.$page.props.candidate.logo_url,
                dp_upload_progress: 0,
                saving: {
                    dp: false,
                }
            }
        },
        computed: {
            fullName(){
                return this.$page.props.candidate.first_name? this.$page.props.candidate.first_name+" "+this.$page.props.candidate.last_name : this.$page.props.user.name
            },
            currentLogo(){
                return this.current_logo.length?this.current_logo:this.company.logo_url;
            }
        },
        methods: {
            skillLabel(level){
                let skills = Object.values(this.$page.props.skills);
                return skills[level-2];
            },
            uploadProfilePic(event){
                let type = 'DPs';
                let file = event.target.files || event.dataTransfer.files;
                if(file.length){
                    //this.company.logo_url =  URL.createObjectURL(event.target.files[0]);
                    let formData = new FormData();
                    formData.append('files', file[0]);
                    formData.append('model', 'App\\Models\\Candidate');
                    formData.append('collection', type);
                    formData.append('model_id', this.candidate.id);
                    formData.append('remove_media', this.candidate.logo);
                    this.saving.dp = true;
                    axios.post(route('file.save'), formData, {
                        headers: {
                            'Content-type' : 'multipart/form-data'
                        },
                        onUploadProgress: function(progressEvent) {
                            this.dp_upload_progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                            console.log(this.dp_upload_progress)
                        }
                    }).then((response) => {
                        console.log(response.data.link);
                        this.current_logo = response.data.link;
                        this.dp_upload_progress = 0;
                        this.saving.dp = false;
                    }).catch(error => {
                        Swal.fire({
                            title: "Failed",
                            text: "The upload has failed",
                            icon: "error",
                        })
                        console.log(error.response.data)
                        this.saving.dp = false;
                    })
                }
                return console.log(file);
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
