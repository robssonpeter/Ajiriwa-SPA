<template>
    <employer-layout title="View emails">
        <div class="grid grid-cols-3 gap-3">
            <div class="z-40 px-4 min-h-screen col-span-3 bg-gray-50 my-4 p-4 shadow-md">
                <div class="flex row gap-2 pb-2">
                    <div class="flex-grow">
                        <h2 class="text-2xl flex-grow">Email Templates</h2>
                        <span>Here you can manage email templates</span>
                    </div>

                    <button class="bg-green-400 p-2 text-white self-end" @click="modal_type = 'new'">Add Template</button>
                    <dialog-modal :show="modal_type" :closeable="true" :max-width="'3xl'">
                        <template v-slot:title>
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">Email Template</span>
                                <button @click="modal_type = ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <template v-slot:content>
                            <section class="flex flex-col pb-4">
                                <span class="text-gray-700">Template Name</span>
                                <input type="text" class="border border-gray-300" placeholder="Template Name">
                            </section>
                            <section class="flex flex-col pb-4">
                                <span class="text-gray-700">Template Type</span>
                                <select class="border border-gray-300 text-gray-500" v-model="new_template.type">
                                    <option value="">Select Type</option>
                                    <option :key="type" :value="type" v-for="type in Object.keys($page.props.template_types)">{{ $page.props.template_types[type] }}</option>
                                </select>
                            </section >

                            <section class="flex flex-col pb-4">
                                <label for="">Available Placeholders</label>
                                <div>
                                    <small class="bg-green-500 rounded-md font-bold text-white p-1 mx-1 cursor-pointer" v-for="placeholder in available_placeholders(new_template.type)" :key="placeholder"><a @click="updateEditorContent(placeholder)" class="btn btn-sm btn-primary mb-2 placeholder">{{placeholder}}</a></small>
                                </div>
                            </section>
                                
                            <section class="flex flex-col pb-4">
                                <div class="editor">

                                </div>
                                <quill-editor class="w-100" @selection-change="selectionHasChanged"  theme="snow" content-type="html"  :content="new_template.content" v-model:content="new_template.content"></quill-editor>
                            </section>
                        </template>
                    </dialog-modal>
                </div>
                <div class="pb-2">
                    
                </div>
                <table class="bg-white w-full text-gray-600 rounded-md">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left px-8 py-3">Name</th>
                            <th class="text-left px-8 py-3 text-center">Type</th>
                            <!--<th class="bg-green-100 border text-left px-8 py-3 text-center">Promotion</th>-->
<!--                            <th class="text-left px-8 py-3 text-center">Date Posted</th>
                            <th class="text-left px-8 py-3 text-center">Views</th>
                            <th class="text-left px-8 py-3 text-center">Status</th>
                            <th class="text-left px-8 py-3 text-center">Closing Date</th>
                            <th class="text-left px-8 py-3 text-center">Applications</th>-->
                            <th class="text-left px-8 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="job in emails" :key="job.id">
                            <td class="border px-8 py-2 text-green-500 hover:text-green-400 font-bold"><Link :href="''">{{ job.name }}</Link></td>
                            <td class="border px-8 py-2 text-center">
                                <span>{{ job.type }}</span>
                            </td>
                            <!--<td class="border px-8 py-2 text-center">
                                <span class="bg-green-400 p-1 text-white cursor-pointer rounded-md text-center"><small>Promote</small></span>
                                <span class="bg-gray-400 p-1 text-white cursor-pointer rounded-md"><small>View Insights</small></span>
                            </td>-->

                            <td class="border px-8 py-2 text-center">
                                <div class="flex flex-row" title="Edit">
                                    <Link :href="''">
                                        <span class="text-green-500 hover:text-green-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </span>
                                    </Link>
                                    <span class="text-red-500 hover:text-red-400" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <tr v-if="!emails.length">
                        <td class="text-center border px-8 py-4" colspan="8">
                            <span>The emails that you post will appear here</span>
                            <span>
                                <button class="bg-green-400 p-1 rounded-md text-white"><Link :href="route('company.post-job')">Post a Job</Link></button>
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--<div class="col-span-1">
                <div class="sticky top-20 shadow-md p-4">
                    <span>This is the promotion part of the job</span>
                </div>
            </div>-->
        </div>
    </employer-layout>
</template>

<script>
    import EmployerLayout from "@/Layouts/EmployerLayout";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Input from "@/Jetstream/Input";
    import Loader from "@/Custom/Loader";
    import TimeAgo from 'vue3-timeago';
    import CheckableDropdown from "@/Custom/CheckableDropdown";
    import Status from "@/Custom/Job/Status";
    import DialogModal from "@/Jetstream/DialogModal";
    import {QuillEditor} from '@vueup/vue-quill';
    import '@vueup/vue-quill/dist/vue-quill.snow.css';
    import Quill from 'quill/core';
    import Toolbar from 'quill/modules/toolbar';
    import Snow from 'quill/themes/snow';

    let editor = new Quill('.editor');
    export default {
        name: "Post",
        props: {
            title: String,
        },
        components: {
            EmployerLayout,
            Head,
            Input,
            Loader,
            Link,
            TimeAgo,
            CheckableDropdown,
            Status,
            DialogModal,
            QuillEditor,
        },
        mounted() {
            console.log(this.emails);
            this.new_template.content = "hello peter"
        },
        data(){
            return {
                new_template: {
                    content: 'Hello',
                    type: 'application_rejection',
                },
                modal_type: '',
                emails: this.$page.props.emails,
                apply_method: 'ajiriwa',
                application_email: '',
                application_url: '',
                title: '',
                location: '',
                reports_to: '',
                job_type: '',
                category: '',
                description: '',
                deadline: '',
                cover_letter: '',
                saving: false,
                /*company_id: this.$page.props.company.id,*/
                number_of_posts: 1,
                location_menu: [
                    { label: 'Dar es Salaam', value: 1},
                    { label: 'Iringa', value: 2 },
                ]
            }
        },
        methods: {
            selectionHasChanged(event){
                console.log(event);
                this.new_template.content = "Whats happening here";
            },
            statusUpdated(event){
                let job_id = event.id;
                let status = event.status;
                let index = this.emails.findIndex(element => element.id === job_id);
                console.log(this.emails[index]);
                this.emails[index].status = status;
                //this.
            },
            editorChanged(html){
                //alert(html)
                this.description = html;
                console.log(this.description);
            },
            submitJob(){
                this.saving = true;
                axios.post(route('job.save'), this.$data).then((response) => {
                    console.log(response.data);
                    if(response.data && response.data.id){
                        // click the button to redirect
                        //this.$inertia.visit(route('company.job.view', response.data.slug))
                    }
                }).catch((error) => {
                    console.log(error.response.data);
                    swal.fire('Error', 'Your job could not be saved', 'error');
                })
            }
        },
        computed: {
            available_placeholders(){
                return type => {
                    if(type){
                        return this.$page.props.table_types[type].columns;
                    }
                    return [];
                }
            }
        }

    }
</script>

<style scoped>

</style>
