<template>
    <app-layout title="Browse Jobs">
        <section class="text-gray-500 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="p-2 bg-white border-1 shadow-md">
                <h1 class="text-xl font-semibold">Profile Builder</h1>
            </div>

            <div class="mt-4 grid grid-cols-4 gap-4">
                <div class="col-span-1 border-r shadow-md border-1 bg-white">
                    <div class="px-2">
                        <span class="text-sm">Profile Completion</span>
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                  <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-emerald-600 bg-emerald-200">
                                    Task in progress
                                  </span>
                                </div>
                                <div class="text-right">
                          <span class="text-xs font-semibold inline-block text-emerald-600">
                            0%
                          </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-emerald-200">
                            </div>
                        </div>
                    </div>
                    <Link :href="route('my-resume.edit.sectional', 'personal')">
                        <div :class="section === 'personal'?active_class:inactive_class">
                            Personal Information
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'experience')">
                        <div :class="section === 'experience'?active_class:inactive_class">
                            Work Experience
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'education')">
                        <div :class="section === 'education'?active_class:inactive_class">
                            Education Information
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'language')">
                        <div :class="section === 'language'?active_class:inactive_class">
                            Language Proficiency
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'skills')">
                        <div :class="section === 'skills'?active_class:inactive_class">
                            Skills
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'awards')">
                        <div :class="section === 'awards'?active_class:inactive_class">
                            Awards & Certificates
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'reference')">
                        <div :class="section === 'reference'?active_class:inactive_class">
                            Referees
                        </div>
                    </Link>
                </div>
                <div class="col-span-3 px-2 py-4 bg-white shadow-md">
                    <EditPersonal v-if="section === 'personal'"></EditPersonal>
                    <EditExperience :candidate_id="$page.props.data.candidate_id" :industries="$page.props.industries" :experiences="$page.props.data.experience" :countries="$page.props.countries" v-else-if="section === 'experience'"></EditExperience>
                    <EditEducation :candidate_id="$page.props.data.candidate_id" :educations="$page.props.data.education" :education_levels="$page.props.data.education_levels" :countries="$page.props.countries" v-else-if="section === 'education'"></EditEducation>
                    <EditLanguage :candidate_id="$page.props.data.candidate_id" :languages="$page.props.data.languages" :language_levels="$page.props.data.language_levels" v-else-if="section === 'language'"></EditLanguage>
                    <EditSkills :candidate_id="$page.props.data.candidate_id" :skills="$page.props.data.skills" :skill_levels="$page.props.data.skill_levels" v-else-if="section === 'skills'"></EditSkills>
                    <EditReferees :candidate_id="$page.props.data.candidate_id" :referees="$page.props.data.referees"  v-else-if="section === 'reference'"></EditReferees>
                    <EditCertificates :countries="$page.props.countries" :candidate_id="$page.props.data.candidate_id" :categories="$page.props.data.categories" :certificates="$page.props.data.certificates" v-else-if="section === 'awards'"></EditCertificates>
                </div>

            </div>

            <!--<div class="mt-4 grid grid  grid-col-4">

                <section class="col-span-1 border-r shadow-md border-1 bg-white">
                    <div class="px-2">
                        <span class="text-sm">Profile Completion</span>
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                  <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-emerald-600 bg-emerald-200">
                                    Task in progress
                                  </span>
                                </div>
                                <div class="text-right">
                          <span class="text-xs font-semibold inline-block text-emerald-600">
                            0%
                          </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-emerald-200">
                            </div>
                        </div>
                    </div>
                    <Link :href="route('my-resume.edit.sectional', 'personal')">
                        <div :class="section === 'personal'?active_class:inactive_class">
                            Personal Information
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'experience')">
                        <div :class="section === 'experience'?active_class:inactive_class">
                            Work Experience
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'education')">
                        <div :class="section === 'education'?active_class:inactive_class">
                            Education Information
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'language')">
                        <div :class="section === 'language'?active_class:inactive_class">
                            Language Proficiency
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'skills')">
                        <div :class="section === 'skills'?active_class:inactive_class">
                            Skills
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'awards')">
                        <div :class="section === 'achievement'?active_class:inactive_class">
                            Awards & Certificates
                        </div>
                    </Link>
                    <Link :href="route('my-resume.edit.sectional', 'reference')">
                        <div :class="section === 'referees'?active_class:inactive_class">
                            Referees
                        </div>
                    </Link>
                </section>

                <section class="col-span-3 px-2 py-4 bg-white shadow-md flex-grow">
                    <EditPersonal v-if="section === 'personal'"></EditPersonal>
                    <EditExperience :candidate_id="$page.props.data.candidate_id" :industries="$page.props.industries" :experiences="$page.props.data.experience" :countries="$page.props.countries" v-else-if="section === 'experience'"></EditExperience>
                    <EditEducation :candidate_id="$page.props.data.candidate_id" :educations="$page.props.data.education" :education_levels="$page.props.data.education_levels" :countries="$page.props.countries" v-else-if="section === 'education'"></EditEducation>
                    <EditLanguage :candidate_id="$page.props.data.candidate_id" :languages="$page.props.data.languages" :language_levels="$page.props.data.language_levels" v-else-if="section === 'language'"></EditLanguage>
                    <EditSkills :candidate_id="$page.props.data.candidate_id" :skills="$page.props.data.skills" :skill_levels="$page.props.data.skill_levels" v-else-if="section === 'skills'"></EditSkills>
                    <EditReferees :candidate_id="$page.props.data.candidate_id" :referees="$page.props.data.referees"  v-else-if="section === 'reference'"></EditReferees>
                    <EditCertificates :countries="$page.props.countries" :candidate_id="$page.props.data.candidate_id" :categories="$page.props.data.categories" :certificates="$page.props.data.certificates" v-else-if="section === 'awards'"></EditCertificates>
                </section>

            </div>-->
        </section>
    </app-layout>
</template>

<script>
    import {Head, Link} from '@inertiajs/inertia-vue3';
    import EditPersonal from "@/Custom/Resume/EditPersonal";
    import EditExperience from "@/Custom/Resume/EditExperience";
    import AppLayout from "@/Layouts/AppLayout";
    import EditEducation from "@/Custom/Resume/EditEducation";
    import EditLanguage from "@/Custom/Resume/EditLanguage";
    import EditSkills from "@/Custom/Resume/EditSkills";
    import EditReferees from "@/Custom/Resume/EditReferees";
    import EditCertificates from "@/Custom/Resume/EditCertificates";

    export default {
        name: "MyResumeEdit",
        props: {
            section: {
                type: String,
            },
            details: {
                type: Object
            }
        },
        components: {
            EditCertificates,
            EditEducation, EditLanguage, EditSkills, EditReferees,
            Link, Head, EditPersonal, AppLayout, EditExperience
        },
        mounted(){
          console.log(this.$page.props.data);
        },
        data(){
            return {
                active_class: 'p-2 pr-12 font-semibold hover:bg-green-400 hover:text-white cursor-pointer bg-green-400 text-white',
                inactive_class : 'p-2 pr-8 font-semibold hover:bg-green-400 hover:text-white cursor-pointer'
            }
        }
    }
</script>

<style scoped>
    input:focus {
        border: none white;
    }

    select:focus {
        border: 0px none white;
    }
</style>
