<template>
    <app-layout title="Browse Jobs">
        <div class="max-w-7xl hidden md:block mx-auto sm:px-6 sticky top-12 md:top-14 z-40">
            <BreadCrumb :links="$page.props.breadcrumb"></BreadCrumb>
        </div>
        <div class="md:grid md:grid-cols-3 gap-4 max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="md:col-span-1 bg-white rounded-md p-2 self-start md:sticky md:top-20 ">
                <div class="flex flex-row py-2">
                    <input type="text" @keypress.enter="searchJobs" v-model="search"
                        class="flex-grow border border-gray-300 text-gray-600 border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-l-md shadow-sm block w-full"
                        placeholder="Search Jobs">
                    <button class="bg-green-500 px-2 text-white rounded-r-md" @click="searchJobs">Search</button>
                </div>

                <div role="status" v-if="loading" v-for="x in jobs.length"
                    class="mb-2 space-y-8 animate-pulse md:space-y-0 md:space-x-8 md:flex md:items-center">
                    <div class="flex justify-center items-center h-24 bg-gray-300 rounded sm:w-48 md:w-32 dark:bg-gray-700">
                        <svg class="w-8 h-12 text-gray-200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                            fill="currentColor" viewBox="0 0 640 512">
                            <path
                                d="M480 80C480 35.82 515.8 0 560 0C604.2 0 640 35.82 640 80C640 124.2 604.2 160 560 160C515.8 160 480 124.2 480 80zM0 456.1C0 445.6 2.964 435.3 8.551 426.4L225.3 81.01C231.9 70.42 243.5 64 256 64C268.5 64 280.1 70.42 286.8 81.01L412.7 281.7L460.9 202.7C464.1 196.1 472.2 192 480 192C487.8 192 495 196.1 499.1 202.7L631.1 419.1C636.9 428.6 640 439.7 640 450.9C640 484.6 612.6 512 578.9 512H55.91C25.03 512 .0006 486.1 .0006 456.1L0 456.1z" />
                        </svg>
                    </div>

                    <div class="w-full">
                        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full mb-4"></div>
                        <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[480px] mb-2.5"></div>
                        <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                    </div>
                    <span class="sr-only">Loading...</span>
                </div>

                <section v-else-if="!jobs.length" class="border border-gray-300 text-gray-500 sm:rounded-md py-4 px-4">
                    <span>There are no jobs to display</span>
                </section>

                <section v-else v-for="(job, index) in jobs"
                    :class="'my-1 grid grid-cols-3 border border-gray-300 sm:rounded-md ' + currentJob(job)">
                    <img :src="job.company.logo_url" class="h-24 rounded-l-md" alt="">
                    <div class="col-span-2 text-gray-600 pt-2">
                        <a href="#" @click.prevent="showJob(index)" class="hidden md:block text-green-500 font-bold">{{
                            job.title }}</a>
                        <a href="#" @click.prevent="showJob(index); job_modal = true"
                            class="md:hidden text-green-500 font-bold">{{ job.title }}</a>
                        <p class="text-sm font-bold mt-1">{{ job.company.name }}</p>
                        <small>{{ job.location }}</small>
                    </div>
                </section>
                <section id="pagination" class="py-4" v-if="!loading">
                    <div class="flex justify-center">
                        <nav aria-label="Page navigation example">
                            <ul class="flex list-style-none">

                                <li :class="paginationClass(link)" v-for="link in pagination.links">
                                    <Link v-if="link.url" :class="paginationLinkClass(link)" :href="link.url" tabindex="-1"
                                        aria-disabled="true" v-html="link.label">
                                    </Link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </section>
            </div>
            <div class="hidden md:block col-span-2 bg-white rounded-md self-start sticky top-20 overflow-y-auto shadow-md">
                <!-- Job Loading Placeholder Uncomment when needed -->
                <!-- <section>
                    <div data-v-7df5818a="" class="border-b-2 p-4 text-gray-600 animate-pulse">
                        <h2 data-v-7df5818a="" class="text-lg bg-gray-200 h-5 w-1/2"></h2>
                        <p data-v-7df5818a="" class="bg-gray-200 h-4 w-1/4 mt-2"></p>
                        <p data-v-7df5818a="" class="bg-gray-200 h-4 w-1/4 mt-2"></p>
                        <div data-v-7df5818a="" class="flex gap-2 mt-4">
                            <button data-v-7df5818a=""
                                class="bg-gray-200 border border-gray-200 text-gray-200 rounded-md px-2"
                                fdprocessedid="mmf91o">Loading</button>
                            <button data-v-7df5818a=""
                                class="border-2 p-2 rounded-md border-gray-200 hover:border-green-500 hover:text-green-500"
                                fdprocessedid="q67osr">
                                <div class="animate-pulse h-6 w-6 bg-gray-200 rounded-full"></div>
                            </button>
                        </div>
                    </div>
                    <div data-v-7df5818a="" class="p-4 text-gray-600 animate-pulse">
                        <p class="bg-gray-200 h-4 w-1/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-3/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-1/2 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-3/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-3/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-2/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-3/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-3/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-3/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-4/4 mt-2"></p>
                        <p class="bg-gray-200 h-4 w-3/4 mt-2"></p>
                    </div>
                </section> -->
                <div v-if="current_job" class="description">
                    <dialog-modal :show="apply_modal" :closeable="true" :max-width="'2xl'">
                        <template v-slot:title>
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">Applying for {{ current_job.title }}</span>
                                <button @click="apply_modal = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <template v-slot:content>
                            <form @submit.prevent="apply">
                                <apply :candidate="$page.props.user.candidate.id" @applied="doneApplying"
                                    @applying="applying" :selected_certs="selected_certs" :assessments="current_assessments"
                                    :job="current_job" :ref="'apply'" @loading="loading = true" @loaded="loading = false"
                                    @can_apply="ableToApply">
                                </apply>
                                <section class="flex flex-col py-2 animate__animated animate__fadeInUp" v-if="can_apply && !loading">
                                    <section class="flex">
                                        <span class="font-bold flex-grow">Attachments</span>
                                        <small class="cursor-pointer text-green-500"
                                            @click="rememberDetails(route('my-resume.edit.sectional', 'awards'))">Manage
                                            Attachments</small>
                                        <Link ref="manage_attachments" :href="route('my-resume.edit.sectional', 'awards')">
                                        </Link>
                                    </section>
                                    <v-select :options="certificates" v-model="selected_certs" multiple></v-select>
                                </section>
                                <div class="animate__animated animate__fadeInUp" v-if="current_assessments.length && can_apply && !loading">
                                    <assessment-render @changed="questionAnswered" v-for="question in current_assessments"
                                        :question="question"></assessment-render>
                                </div>
                                <button type="submit" class="hidden" ref="submit-application">send</button>
                            </form>
                            <!--<text-editor></text-editor>-->
                        </template>
                        <template v-slot:footer>
                            <div class="flex flex-row">
                                <span class="flex-grow"></span>
                                <button v-if="can_apply" @click="$refs['submit-application'].click()"
                                    :disabled="currently_applying"
                                    class="bg-green-500 hover:shadow-lg text-white p-2 flex flex-row">
                                    <span class="flex-grow"></span>
                                    <loader v-if="currently_applying" :color="'white'"></loader>
                                    <span v-else>Apply</span>
                                    <span class="flex-grow"></span>
                                </button>
                            </div>
                        </template>
                    </dialog-modal>
                    <section v-if="current_job.title">
                        <div class="border-b-2 p-4 text-gray-600">
                            <h2 class="text-lg">{{ current_job.title }}</h2>
                            <p>{{ current_job.location }}</p>
                            <p>{{ current_job.type ? current_job.type.name : '' }}</p>
                            <!--                        <small>{{ current_job.deadline }}</small>-->
                            <div class="flex gap-2">
                                <button v-if="!alreadyApplied && canApply(current_job.deadline)"
                                    class="bg-green-500 p-2 rounded-md text-white" @click="startApplying">Apply</button>
                                <button v-else-if="!canApply(current_job.deadline)"
                                    class="bg-green-white border border-red-500 text-red-500 rounded-md px-2">Applications
                                    Closed</button>
                                <button v-else
                                    class="bg-green-white border border-green-500 text-green-500 rounded-md px-2">Already
                                    Applied</button>
                                <button @click="toggleJobSave" :class="saveButtonColors"><svg
                                        xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-pulse" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg></button>
                            </div>
                        </div>
                        <div class="p-4 text-gray-600" v-html="current_job.description">

                        </div>
                    </section>
                    <section v-else class="h-48 bg-white text-gray-500 p-4">
                        <span>The job you select will be visible here</span>
                    </section>
                </div>
            </div>
            <dialog-modal :show="job_modal" :closeable="true" :max-width="'2xl'">
                <template v-slot:title>
                    <div class="flex flex-row">
                        <span class="flex-grow text-gray-500 font-bold">Viewing Job</span>
                        <button @click="job_modal = false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
                <template v-slot:content>
                    <div class="md:hidden bg-white rounded-md self-start top-20 overflow-y-auto shadow-md">
                        <div v-if="current_job" class="description">
                            <dialog-modal :show="apply_modal" :closeable="true" :max-width="'2xl'">
                                <template v-slot:title>
                                    <div class="flex flex-row">
                                        <span class="flex-grow text-gray-500 font-bold">Applying for {{ current_job.title
                                        }}</span>
                                        <button @click="apply_modal = false">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>

                                <template v-slot:content>
                                    <form @submit.prevent="apply">
                                        <apply :candidate="$page.props.user.candidate.id" @applied="doneApplying"
                                            @applying="applying" :selected_certs="selected_certs"
                                            :assessments="current_assessments" :job="current_job" @loaded="loading = false"
                                            @can_apply="ableToApply" :ref="'apply'">
                                        </apply>
                                        <section class="flex flex-col py-2" v-if="can_apply && !loading">
                                            <section class="flex">
                                                <span class="font-bold flex-grow">Attachments</span>
                                                <small class="cursor-pointer text-green-500"
                                                    @click="rememberDetails(route('my-resume.edit.sectional', 'awards'))">Manage
                                                    Attachments</small>
                                                <Link ref="manage_attachments"
                                                    :href="route('my-resume.edit.sectional', 'awards')">
                                                </Link>
                                            </section>

                                            <v-select :options="certificates" v-model="selected_certs" multiple></v-select>
                                        </section>
                                        <div v-if="current_assessments.length && can_apply && !loading">
                                            <assessment-render @changed="questionAnswered"
                                                v-for="question in current_assessments"
                                                :question="question"></assessment-render>
                                        </div>
                                        <button type="submit" class="hidden" ref="submit-application">send</button>
                                    </form>
                                    <!--<text-editor></text-editor>-->
                                </template>
                                <template v-slot:footer>
                                    <div class="flex flex-row">
                                        <span class="flex-grow"></span>
                                        <button v-if="can_apply" @click="$refs['submit-application'].click()"
                                            :disabled="currently_applying"
                                            class="bg-green-500 hover:shadow-lg text-white p-2 flex flex-row">
                                            <span class="flex-grow"></span>
                                            <loader v-if="currently_applying" :color="'white'"></loader>
                                            <span v-else>Apply</span>
                                            <span class="flex-grow"></span>
                                        </button>
                                    </div>
                                </template>
                            </dialog-modal>
                            <section v-if="current_job.title">
                                <div class="border-b-2 p-4 text-gray-600">
                                    <h2 class="text-lg">{{ current_job.title }}</h2>
                                    <p>{{ current_job.location }}</p>
                                    <p>{{ current_job.type ? current_job.type.name : '' }}</p>
                                    <!--                        <small>{{ current_job.deadline }}</small>-->
                                    <div class="flex gap-2">
                                        <button v-if="!alreadyApplied && canApply(current_job.deadline)"
                                            class="bg-green-500 p-2 rounded-md text-white"
                                            @click="startApplying">Apply</button>
                                        <button v-else-if="!canApply(current_job.deadline)"
                                            class="bg-green-white border border-red-500 text-red-500 rounded-md px-2">Applications
                                            Closed</button>
                                        <button v-else
                                            class="bg-green-white border border-green-500 text-green-500 rounded-md px-2">Already
                                            Applied</button>
                                        <button @click="toggleJobSave" :class="saveButtonColors"><svg
                                                xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 animate-pulse" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg></button>
                                    </div>
                                </div>
                                <div class="p-4 text-gray-600" v-html="current_job.description">

                                </div>
                            </section>
                            <section v-else class="h-48 bg-white text-gray-500 p-4">
                                <span>The job you select will be visible here</span>
                            </section>
                        </div>
                    </div>
                </template>
            </dialog-modal>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import BreadCrumb from "@/Custom/BreadCrumb";
import DialogModal from "@/Jetstream/DialogModal";
import Apply from "@/Custom/Job/Apply";
import TextEditor from "@/Custom/TextEditor";
import AssessmentRender from "@/Custom/Job/Screening/AssessmentRender";
import Loader from "@/Custom/Loader";
import TimeAgo from 'vue-timeago';
import 'flowbite';
import iziToast from "izitoast";
import { Link } from "@inertiajs/inertia-vue3";
import "izitoast/dist/css/iziToast.min.css";
import Swal from "sweetalert2";
import { initializeApp } from "firebase/app";
import { getAnalytics } from "firebase/analytics";
import { getMessaging, getToken } from "firebase/messaging";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import 'animate.css';

const firebaseConfig = {
    apiKey: "AIzaSyCc2eq23_efjual1WZ329gMP5bZlOunv9s",
    authDomain: "ajiriwa-push-notifications.firebaseapp.com",
    projectId: "ajiriwa-push-notifications",
    storageBucket: "ajiriwa-push-notifications.appspot.com",
    messagingSenderId: "117362381735",
    appId: "1:117362381735:web:0a00ccfa5024cc70fc9c82",
    measurementId: "G-JW3B32E4S6"
};

// Initialize Firebase
const firebaseApp = initializeApp(firebaseConfig);
const analytics = getAnalytics(firebaseApp);
const messaging = getMessaging(firebaseApp);

export default {
    name: "Jobs",
    components: {
        AppLayout, BreadCrumb, DialogModal, Apply, TextEditor, Loader, TimeAgo, vSelect, AssessmentRender, Link
    },
    mounted() {
        let slug = window.location.hash.replace('#', '');
        let index = 0;
        console.log(this.$page.props)

        if (this.jobs.length) {
            if (slug) {
                index = this.jobs.findIndex(element => element.slug == slug);
                if (index < -1) {
                    iziToast.error({ title: 'Job Not Found', message: 'The job you are trying to access is not available' });
                    index = 0;
                }
            }
            this.showJob(index);
        }
        if (0 < 1) {
            const showPushNotificationPopup = () => {
                if (this.$page.props.user.push_notify == null) {
                    return new Promise((resolve) => {
                        Swal.fire({
                            title: 'Push Notifications',
                            text: 'Do you want to receive push notifications for new job updates?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Accept',
                            cancelButtonText: 'Cancel',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                resolve(true);
                            } else {
                                resolve(false);
                            }
                        });
                    });
                } else if (Number(this.$page.props.user.push_notify) == 1) {
                    // the user already agreed before simply just raise the prompt
                    return new Promise((resolve) => {
                        resolve(true);
                    });
                } else {
                    return new Promise((resolve) => {
                        resolve(false);
                    });
                }
            };

            showPushNotificationPopup().then((accepted) => {
                if (accepted) {
                    // Initialize Firebase and request permission for push notifications
                    const firebaseApp = initializeApp(firebaseConfig);
                    const messaging = getMessaging(firebaseApp);

                    Notification.requestPermission().then((permission) => {
                        if (permission === 'granted') {
                            console.log('Permission granted');
                            getToken(messaging, {
                                vapidKey: 'BPEeiMDqK4wcKxXE6h9ZbGaTaDhBqoAnO6Ifux11k5MRjt1eq_DnnJb7LlD9mYu41dBug20m5mPZ-ANB-3J3NUM',
                            })
                                .then((token) => {
                                    axios
                                        .post(route('fcmToken'), {
                                            _method: 'PATCH',
                                            push_notify: 1,
                                            token,
                                        })
                                        .then(({ data }) => {
                                            console.log(data);
                                        })
                                        .catch(({ response: { data } }) => {
                                            console.error(data);
                                        });
                                })
                                .catch((error) => {
                                    console.error('Failed to get token:', error);
                                });
                        }
                    });
                }
            });
        }
    },
    data() {
        return {
            loading: false,
            job_modal: false,
            apply_modal: false,
            currently_applying: false,
            current_job: {},
            current_assessments: [],
            pagination: this.$page.props.jobs,
            jobs: this.$page.props.jobs.data,
            viewed_jobs: this.$page.props.viewedJobs,
            applied_jobs: this.$page.props.appliedJobs,
            saved_jobs: this.$page.props.savedJobs,
            certificates: this.$page.props.certificates,
            selected_certs: [],
            search: "",
            can_apply: false,
        }
    },
    computed: {
        currentJob() {
            return job => {
                console.log(this.current_job);
                if (this.current_job == job) {
                    return "bg-green-200";
                }
            }
        },
        paginationLinkClass() {
            return data => {
                if (!data.url && !data.active) {
                    return "page-link relative block py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full text-gray-500 pointer-events-none focus:shadow-none"
                } else if (data.active) {
                    return "page-link relative block py-1.5 px-3 border-0 bg-green-500 outline-none transition-all duration-300 rounded-full text-white hover:text-white hover:bg-green-600 shadow-md focus:shadow-md"
                } else {
                    return "page-link relative block py-1.5 px-3 border-0 bg-transparent outline-none transition-all duration-300 rounded-full text-gray-800 hover:text-gray-800 hover:bg-gray-200 focus:shadow-none"
                }
            }
        },
        paginationClass() {
            return data => {
                if (!data.url && !data.active) {
                    return "page-item disabled"
                } else if (data.active) {
                    return "page-item active"
                } else {
                    return "page-item"
                }
            }
        },
        canApply() {
            return date => {
                let today = new Date();
                date = new Date(date);
                return today <= date;
            }
        },
        saveButtonColors() {
            let preclass = 'border-2 p-2 rounded-md'
            if (this.saved_jobs.indexOf(this.current_job.id) < 0) {
                return preclass + " border-gray-200 hover:border-green-500 hover:text-green-500";
            }
            return preclass + " border-green-500 hover:border-gray-200 hover:text-green-500 text-green-500";
        },
        alreadyApplied() {
            if (this.applied_jobs.indexOf(this.current_job.id) >= 0) {
                return true
            }
            return false;
        },
        jobSaved() {
            if (this.saved_jobs.indexOf(this.current_job.id) >= 0) {
                return true
            }
            return false;
        }
    },
    methods: {
        ableToApply(status) {
            this.can_apply = status;
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
        searchJobs() {
            this.loading = true;
            axios.post(route('jobs.search', { search: this.search, ajax: 1 })).then((response) => {
                //console.log(response.data);
                this.pagination = response.data;
                this.jobs = response.data.data;
                this.loading = false;
            }).catch((error) => {
                Swal.fire({
                    title: "Failed",
                    text: "Action could not be completed",
                    icon: "error"
                })
                console.error(error.response.data);
                this.loading = false;
            })
        },
        questionAnswered(data) {
            let index = this.current_assessments.findIndex(element => element.id === data.question_id);
            this.current_assessments[index].applicant_answer = data.answer;
        },
        toggleJobSave() {
            let index = this.saved_jobs.indexOf(this.current_job.id);
            let action = index >= 0 ? 'remove' : 'add';
            let job = this.current_job.id;
            axios.post(route('job-save.toggle', { job_id: job, action: action })).then((response) => {
                if (action === 'remove') {
                    this.saved_jobs.splice(index, 1);
                } else {
                    this.saved_jobs.push(job)
                }
            }).catch((error) => {
                Swal.fire({
                    title: "Failed",
                    text: "Action could not be completed",
                    icon: "error"
                })
                console.error(error.response.data);
            })
        },
        registerView(job_id) {
            axios.post(route('job.view.register'), { job_id: job_id });
            this.viewed_jobs.push(job_id);
        },
        showJob(index) {
            this.current_job = this.jobs[index];
            this.scrollToTop()
            // check if the user already applied for the job
            if (this.$page.user && this.$page.props.user.candidate.applied_jobs.indexOf(this.jobs[index].id) !== -1) {
                // the user has already applied for the job
                this.current_job.applied = true;
            }
            if (this.viewed_jobs.indexOf(this.current_job.id) < 0) {
                this.registerView(this.current_job.id);
            }
        },
        rememberDetails(redirect_url) {
            // temporarily store the applications details in a session
            console.log(this.$refs.apply);
            this.$refs.apply.sendApplication('store');
            this.$inertia.visit(redirect_url);
        },
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
        startApplying() {
            if (this.current_job.application_url) {
                //alert('you are supposed to be redirected to another website');
                let link = route('redirect') + "?jobid=" + this.current_job.id + '&link=' + this.current_job.application_url;
                window.open(link, "_blank");
                setTimeout(() => {
                    Swal.fire({
                        title: "Did you apply?",
                        text: "We can help you track the application",
                        icon: ""
                    })
                }, 1000);
                // show an confirmation asking if the user had applied for the position
            } else {
                this.apply_modal = !this.apply_modal;
                this.getAssessments();
            }
        },
        apply() {
            this.$refs.apply.sendApplication('apply');
        },
        doneApplying(job) {
            // close the modal
            this.apply_modal = false;

            this.currently_applying = false;

            console.log(job);

            // update the entry where the job exists
            this.current_job.applied = true;

            this.applied_jobs.push(this.current_job.id);

            iziToast.success({
                title: "Done",
                message: "Your application has been sent"
            })
        },
        applying(status) {
            //alert(status);
            this.currently_applying = status;
        }
    }
}
</script>

<style scoped>
div.description::v-deep li {
    list-style-type: circle;
    list-style-position: inside;
    margin-left: 10px;
    margin-inside: 10px;
}

div.description::v-deep h1 {
    font-size: xx-large;
    font-weight: bold;
    margin-top: 10px;
}

div.description::v-deep h2 {
    font-size: x-large;
    font-weight: bold;
    margin-top: 8px
}

div.description::v-deep h3 {
    font-size: large;
    font-weight: bold;
}

div.description::v-deep h4 {
    margin-top: 8px;
}

div.description::v-deep h5 {
    margin-top: 8px;
}
</style>
