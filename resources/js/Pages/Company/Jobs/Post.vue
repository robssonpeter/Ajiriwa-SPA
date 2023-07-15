<template>
    <section>
        <employer-layout title="Add Job">
            <div class="grid grid-cols-3 gap-3">
                <div class="z-40 px-4 min-h-screen col-span-2 bg-gray-50 my-4 p-4 shadow-md">
                    <form :action="route('job.save')" @submit.prevent="submitJob" method="post" class="text-gray-500">
                        <div class="input flex flex-col mb-4" v-if="$page.props.is_admin">
                            <label for="job_title" class="font-bold">Company</label>
                            <span v-if="$page.props.job">{{ $page.props.job.company.name }}</span>
                            <v-select v-if="!$page.props.job" required @change="company_selected" v-model="selected_company"
                                :options="company_options" @search="fetchCompanies">
                                <template slot="no-options">
                                    type to search companies..
                                </template>
                                <!-- <template slot="option" slot-scope="option">
                            <div class="d-center">
                                <img :src='option.logo_url'/> 
                                {{ option.name }}
                                </div>
                            </template> -->
                            </v-select>
                        </div>
                        <section class="md:grid md:grid-cols-3 gap-4 gap-y-4 pb-4"
                            v-if="$page.props.is_admin && !selected_company && !$page.props.job">
                            <div class="input flex flex-col">
                                <label for="job_title" class="font-bold">Company Name</label>
                                <input type="text" placeholder="New Company" v-model="new_company.name"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300"
                                    id="job_title" required>
                            </div>

                            <div class="input flex flex-col">
                                <label for="reports_to" class="font-bold">Website</label>
                                <input type="url" placeholder="http://.." v-model="new_company.website" id="reports_to"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                            </div>

                            <div class="input flex flex-col">
                                <span class="invisible">Save</span>
                                <button :disabled="new_company.saving" @click="saveNewCompany"
                                    class="border border-green-400 py-2 color-green-400 hover:bg-green-400 hover:text-white text-green-400">
                                    <span v-if="!new_company.saving">Save New Company</span>
                                    <Loader color="white" class="self-center" v-else></Loader>
                                </button>
                            </div>
                        </section>

                        <div class="input flex flex-col" v-if="company_id && !company_logo && $page.props.is_admin">
                            <!-- <label for="reports_to" class="font-bold">Logo</label> -->
                            <file-uploader :label="'Logo'" :model="'App\\Models\\Company'" :collection="'logo'"
                                :model_id="company_id" :key="'company-logo'" :title="new_company.name + 'company-logo'">
                            </file-uploader>
                            <!-- <input type="file" id="reports_to" class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300" > -->
                        </div>
                        <section class="md:grid md:grid-cols-3 gap-4 gap-y-4">
                            <div class="input flex flex-col">
                                <label for="job_title" class="font-bold">Job Title</label>
                                <input type="text" v-model="title"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300"
                                    id="job_title" required>
                            </div>
                            <div class="input flex flex-col">
                                <label for="reports_to" class="font-bold">Reports To</label>
                                <input type="text" v-model="reports_to" id="reports_to"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                            </div>
                            <div class="input flex flex-col">
                                <label for="location" class="font-bold">Location</label>
                                <input type="text" v-model="location" id="location"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300"
                                    required>
                            </div>
                        </section>

                        <section class="md:grid md:grid-cols-3 gap-4 gap-y-4 mt-4">
                            <div class="input flex flex-col">
                                <label for="job-type" class="font-bold">JobType</label>
                                <select name="job_type" id="job-type" v-model="job_type"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300"
                                    required>
                                    <option value="">Job Type</option>
                                    <option :value="type.id" v-for="type in $page.props.jobTypes"> {{ type.name }}</option>
                                </select>
                            </div>
                            <div class="input flex flex-col">
                                <label for="job-category" class="font-bold">Job Category</label>
                                <select name="category" v-model="category" id="job-category"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                    <option value="">Job Category</option>
                                    <option :value="category.id" v-for="category in $page.props.categories">{{ category.name
                                    }}</option>
                                </select>
                            </div>
                            <div class="input flex flex-col">
                                <label for="cover-letter" class="font-bold">Require CoverLetter</label>
                                <select name="cover_letter" v-model="cover_letter" id="cover-letter"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </section>
                        <section class="py-4">
                            <span class="font-bold">Job Description</span>
                            <editor api-key="jjad0mn6spynym8qygjn9s5rh9pdsngw4gmev06owjdt277s"
                                :initial-value="'Your job description here...'" v-model="description" :init="{
                                    height: 400,
                                    menubar: false,
                                    link_title: false,
                                    plugins: [
                                        'advlist autolink lists link image charmap print preview anchor',
                                        'searchreplace visualblocks code fullscreen',
                                        'insertdatetime media table paste code help wordcount'
                                    ],
                                    toolbar:
                                        'undo redo | formatselect | bold italic | \
                                                                alignleft aligncenter alignright alignjustify | \
                                                                bullist numlist | help'
                                }" />
                            <!--<text-editor @change="editorChanged" :text="$page.props.job?$page.props.job.description:''" v-model:content="description"></text-editor>-->
                        </section>
                        <section class="py-2">
                            <span class="font-bold">Keywords</span>
                            <tag-input @changed="tagChanged"></tag-input>
                        </section>
                        <div class="grid grid-cols-3 gap-3">
                            <section class="py-2 flex flex-col col-span-1">
                                <label for="apply_method" class="font-bold">Applications Method</label>
                                <select @change="controlScreening" name="apply_method" v-model="apply_method" id="apply_method"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                    <option value="ajiriwa">Through Ajiriwa.net (Recommended)</option>
                                    <option value="url">My company's website</option>
                                    <option value="email">Forward to my email</option>
                                    <option value="description">I have specified in description</option>
                                </select>
                            </section>
                            <section class="py-2 flex flex-col col-span-1">
                                <label for="apply_method" class="font-bold">Applications Deadline</label>
                                <input type="date" :disabled="editing && !$page.props.is_admin" v-model="deadline"
                                    class="disabled:bg-gray-200 disabled:cursor-not-allowed focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300"
                                    required>
                            </section>
                            <section class="py-2 flex flex-col col-span-1">
                                <label for="apply_method" class="font-bold">Number of Positions</label>
                                <input type="number" v-model="number_of_posts"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300"
                                    required>
                            </section>
                            <section class="py-2 flex flex-col col-span-3" v-if="apply_method === 'ajiriwa'">
                                <span class="text-green-300 font-bold">Your applications will submitted through
                                    ajiriwa.net</span>
                            </section>
                            <section class="py-2 flex flex-col col-span-3" v-if="apply_method === 'description'">
                                <span class="text-red-500 font-bold">Please be sure to specify the mode of application in
                                    your job description</span>
                            </section>
                            <section class="py-2 flex flex-col col-span-3" v-if="apply_method === 'url'">
                                <label for="apply-website" class="font-bold">Application Url</label>
                                <input type="url" id="apply-website" v-model="application_url" placeholder="Enter Url"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300"
                                    required>
                            </section>
                            <section class="py-2 flex flex-col col-span-3" v-if="apply_method === 'email'">
                                <label for="apply-email" class="font-bold">Application Email</label>
                                <input type="email" id="apply-email" v-model="application_email"
                                    placeholder="Enter your email"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300"
                                    required>
                                <div class="py-2">
                                    <span class="font-bold">Application Email CC</span>
                                    <section class="grid grid-cols-2 gap-2">
                                        <input type="email" @keyup="controlCC(index)" v-model="application_email_cc[index]"
                                            :placeholder="'CC ' + Number(index + 1)" v-for="(cc, index) in application_email_cc"
                                            class="w-full focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                        <span class="cursor-pointer mt-2 text-green-400 font-bold" v-if="allowCC"
                                            @click="addCC">Add CC</span>
                                    </section>
                                </div>


                                <label for="email-subject" class="mt-2 font-bold">Email Subject Line (Optional)</label>
                                <input type="text" v-model="email_subject_line" name="subject_line" id="email-subject"
                                    placeholder="Subject Line"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                            </section>

                            <section class="py-2 flex flex-col col-span-1">
                                <label for="apply-email" class="font-bold">Job Status</label>
                                <select name="apply_method" v-model="status" id="apply_method"
                                    class="focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                    <option :value="index" v-for="(status, index) in $page.props.status">{{ status }}
                                    </option>
                                </select>
                            </section>
                            <section class="py-2 flex col-span-3">
                                <input type="checkbox" @change="controlScreening" ref="add_assessments" class="self-center mr-2 accent-pink-500"
                                    name="add-assessments" id="">
                                <span class="self-center">Add screening questions</span>
                            </section>

                            <button :disabled="saving"
                                class="bg-green-400 hover:bg-green-500 text-white p-2 text-center self-end mb-2 justify-center">
                                <span v-if="!saving">Save</span>
                                <Loader color="white" class="self-center" v-else></Loader>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-span-1">
                    <div class="sticky top-20 shadow-md p-4">
                        <span>This is the promotion part of the job</span>
                    </div>
                </div>
            </div>
        </employer-layout>
    </section>
</template>

<script>
import EmployerLayout from "@/Layouts/EmployerLayout";
import { Head, Link } from '@inertiajs/inertia-vue3';
import TextEditor from "@/Custom/TextEditor";
import Input from "@/Jetstream/Input";
import { QuillEditor } from '@vueup/vue-quill';
import Loader from "@/Custom/Loader";
import FileUploader from "@/Custom/FileUploader";
import Swal from "sweetalert2";
import TagInput from "../../../Custom/TagInput.vue";
import vSelect from "vue-select";
import 'vue-select/dist/vue-select.css';
import Editor from '@tinymce/tinymce-vue'
import axios from "axios";
export default {
    name: "Post",
    props: {
        title: String,
    },
    components: {
        EmployerLayout, Head, TextEditor, Input, QuillEditor, Loader, TagInput, vSelect, Editor, FileUploader
    },
    mounted() {
        /*if(this.$page.props.job){
            this.application_email =
        }*/
        if (this.$page.props.job) {
            //alert(this.$page.props.job.description);
            this.description = this.$page.props.job.description;
        }
    },
    data() {
        return {
            apply_method: this.$page.props.job ? this.$page.props.job.apply_method : 'ajiriwa',
            email_subject_line: this.$page.props.job ? this.$page.props.job.email_subject : '',
            application_email: this.$page.props.job ? this.$page.props.job.application_email : '',
            application_email_cc: [],
            application_url: this.$page.props.job ? this.$page.props.job.application_url : '',
            title: this.$page.props.job ? this.$page.props.job.title : '',
            location: this.$page.props.job ? this.$page.props.job.location : '',
            reports_to: this.$page.props.job ? this.$page.props.job.reports_to : '',
            job_type: this.$page.props.job ? this.$page.props.job.job_type : '',
            category: '',
            description: this.$page.props.job ? this.$page.props.job.description : 'Your job description here',
            deadline: this.$page.props.job ? this.$page.props.job.deadline : '',
            cover_letter: this.$page.props.job ? this.$page.props.job.cover_letter : '',
            saving: false,
            keywords: [],
            company_id: this.$page.props.job ? this.$page.props.job.company_id : this.$page.props.company.id,
            number_of_posts: this.$page.props.job ? this.$page.props.job.number_of_posts : 1,
            job_id: this.$page.props.job ? this.$page.props.job.id : '',
            status: this.$page.props.job ? this.$page.props.job.status : 1,
            company_options: [],
            selected_company: null,
            company_logo: null,
            new_company: {
                name: '',
                website: '',
                logo: '',
                saving: false,
            }
        }
    },
    computed: {
        editing() {
            if (this.$page.props.job) {
                return true;
            }
            return false;
        },
        allowCC() {
            let count = this.application_email_cc.length;
            if (!count) {
                return true
            } else {
                if (this.application_email_cc[count - 1].length) {
                    return true
                }
            }
            return false;
        }
    },
    methods: {
        saveNewCompany() {
            //alert('you about to save a new company');
            this.new_company.saving = true;
            axios.post(route('company.new'), this.new_company).then(response => {
                if (response.data) {
                    this.company_options.push(response.data);
                    this.selected_company = response.data.name;
                    this.company_id = response.data.id;
                }
            }).catch(error => {
                console.log(error.response.data);
                this.new_company.saving = false;
                this.new_company.name = "";
                this.new_company.website = "";
            });
        },
        company_selected() {
            if (this.selected_company) {
                this.company_id = this.selected_company.code;
                this.company_logo = this.selected_company.logo;
                this.company_options = [];
                //alert('you are here');
            }

        },
        tagChanged(event) {
            console.log(event);
            this.keywords = event;
        },
        controlScreening() {
            if (this.apply_method !== 'ajiriwa' && this.$refs.add_assessments.checked) {
                Swal.fire('Error', 'Screening questions can only be added when the application method is ajiriwa.', 'error');
                this.$refs.add_assessments.checked = false;
                return;
            }
        },
        controlCC(index) {
            if (!this.application_email_cc[index].length) {
                this.application_email_cc.splice(index, 1)
            }
        },
        addCC() {
            this.application_email_cc.push('');
        },
        editorChanged(html) {
            this.description = html;
            //console.log(this.description);
        },
        fetchCompanies(searching, loading) {
            if (searching.length) {
                axios.post(route('companies.search'), { keyword: searching }).then((response) => {
                    console.log(response.data);
                    this.company_options = response.data;
                }).catch((error) => {
                    console.log(error)
                });
            }
        },
        submitJob() {
            this.saving = true;
            if (!this.description) {
                this.description = this.$page.props.job.description;
            }

            axios.post(route('job.save'), this.$data).then((response) => {
                console.log(response.data);
                if (response.data && response.data.id) {
                    // click the button to redirect
                    if (this.$refs.add_assessments.checked) {
                        this.$inertia.visit(route('job.assessment', response.data.slug));
                    } else {
                        this.$inertia.visit(route('company.job.view', response.data.slug));
                    }
                }
            }).catch((error) => {
                console.log(error.response.data);
                Swal.fire('Error', 'Your job could not be saved', 'error');
            })
        }
    }

}
</script>

<style scoped></style>
