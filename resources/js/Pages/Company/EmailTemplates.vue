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
                        <!-- Dialog modal content -->
                        <template v-slot:title>
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">Email Template</span>
                                <button @click="modal_type = ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <template v-slot:content>
                            <section class="flex flex-col pb-4">
                                <span class="text-gray-700">Template Name</span>
                                <input type="text" v-model="new_template.name" class="border border-gray-300"
                                    placeholder="Template Name">
                            </section>
                            <section class="flex flex-col pb-4">
                                <span class="text-gray-700">Template Type</span>
                                <select class="border border-gray-300 text-gray-500" v-model="new_template.type">
                                    <option value="">Select Type</option>
                                    <option :key="type" :value="type"
                                        v-for="type in Object.keys($page.props.template_types)">{{
                                            $page.props.template_types[type] }}</option>
                                </select>
                            </section>

                            <section class="flex flex-col pb-4">
                                <label for="">Available Placeholders</label>
                                <div>
                                    <small class="bg-green-500 rounded-md font-bold text-white p-1 mx-1 cursor-pointer"
                                        v-for="placeholder in available_placeholders(new_template.type)"
                                        :key="placeholder"><a @click="updateEditorContent(placeholder)"
                                            class="btn btn-sm btn-primary mb-2 placeholder">{{ placeholder }}</a></small>
                                </div>
                            </section>

                            <section class="flex flex-col pb-4">
                                <div class="editor">

                                </div>
                                <quill-editor ref="quillEditor" class="w-100" @selection-change="selectionHasChanged"
                                    theme="snow" content-type="html" :content="new_template.content"
                                    v-model:content="new_template.content"></quill-editor>
                            </section>
                        </template>
                        <template v-slot:footer>
                            <button class="bg-green-500 p-1 hover:bg-green-400 text-white" :disabled="saving_template"
                                @click="saveEmailTemplate">
                                <span v-if="!saving_template">Save Template</span>
                                <loader v-else color="white"></loader>
                            </button>
                        </template>
                    </dialog-modal>
                    <!-- The modal for viewing the email template -->
                    <dialog-modal :show="viewModalVisible" closeable="true" :max-width="'2xl'">
                        <!-- Dialog modal content -->
                        <template v-slot:title>
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">View Email Template</span>
                                <button @click="viewModalVisible = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <template v-slot:content>
                            <div v-html="viewedTemplate?.content">
                            </div>
                        </template>
                        <template v-slot:footer>
                            <!-- Edit Template Button -->
                            <button v-if="viewedTemplate && viewedTemplate.company_id === $page.props.user.company.id"
                                class="bg-green-500 p-1 hover:bg-green-400 text-white" @click="openEditModal">
                                Edit Template
                            </button>
                        </template>
                    </dialog-modal>


                    <!-- The modal for editing email Template -->
                    <dialog-modal :show="modal_type === 'edit'" :closeable="true" :max-width="'3xl'">
                        <!-- Dialog modal content -->
                        <template v-slot:title>
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">Edit Email Template</span>
                                <button @click="modal_type = ''">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <template v-slot:content>
                            <section class="flex flex-col pb-4">
                                <span class="text-gray-700">Template Name</span>
                                <input type="text" v-model="editedTemplate.name" class="border border-gray-300"
                                    placeholder="Template Name">
                            </section>
                            <section class="flex flex-col pb-4">
                                <span class="text-gray-700">Template Type</span>
                                <select class="border border-gray-300 text-gray-500" v-model="editedTemplate.type">
                                    <option value="">Select Type</option>
                                    <option :key="type" :value="type"
                                        v-for="type in Object.keys($page.props.template_types)">
                                        {{ $page.props.template_types[type] }}
                                    </option>
                                </select>
                            </section>
                            <section class="flex flex-col pb-4">
                                <div class="editor">
                                    <quill-editor ref="quillEditor" class="w-100" @selection-change="selectionHasChanged"
                                        theme="snow" content-type="html" :content="editedTemplate.content"
                                        v-model:content="editedTemplate.content"></quill-editor>
                                </div>
                            </section>
                        </template>
                        <template v-slot:footer>
                            <button class="bg-green-500 p-1 hover:bg-green-400 text-white" :disabled="saving_template"
                                @click="updateEmailTemplate">
                                <span v-if="!saving_template">Update Template</span>
                                <loader v-else color="white"></loader>
                            </button>
                        </template>
                    </dialog-modal>


                    <dialog-modal :show="template_modal" closeable="true" :max-width="'2xl'">
                        <!-- Dialog modal content -->
                        <template v-slot:title>
                            <div class="flex flex-row">
                                <span class="flex-grow text-gray-500 font-bold">Email Template</span>
                                <button @click="template_modal = false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <template v-slot:content>
                            <div>
                                {{ currentIndexContent }}
                            </div>
                        </template>
                        <template v-slot:footer>
                            <span>Hello</span>
                        </template>
                    </dialog-modal>
                </div>

                <div class="pb-2"></div>

                <table class="bg-white w-full text-gray-600 rounded-md">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left px-8 py-3">Name</th>
                            <th class="text-left px-8 py-3 text-center">Type</th>
                            <th class="text-left px-8 py-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Email template rows -->
                        <tr v-for="(job, index) in emails" :key="job.id">
                            <td class="border flex px-8 py-2 text-green-500 hover:text-green-400 font-bold"
                                @click="viewTemplate(job)">
                                <span class="cursor-pointer">{{ job.name }} <small v-if="defaultSetting(job.type) === job.id" class="rounded-md p-1 text-xs bg-green-400 text-white">Default</small></span>
                                <loader v-if="loading.indexOf(job.id) >= 0" color="green"></loader>
                            </td>
                            <td class="border px-8 py-2 text-center cursor-pointer">
                                <span>{{ job.type }} {{ defaultSetting(job.type) }}</span>
                            </td>
                            <td class="border px-8 py-2 text-center">
                                <div class="flex flex-row" title="Edit">
                                    <span @click="emailClicked(job, index)"
                                        v-if="job.company_id && job.company_id == $page.props.user.company.id"
                                        class="text-green-500 hover:text-green-400 cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </span>
                                    <span @click="deleteTemplate(job)"
                                        v-if="job.company_id && job.company_id == $page.props.user.company.id"
                                        class="text-red-500 hover:text-red-400" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </span>
                                    <span v-if="defaultSetting(job.type) !== job.id" @click="setDefaultTemplate(job.id)" title="Set as default">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-blue-500">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                        </svg>
                                    </span>
                                </div>
                            </td>
                        </tr>

                        <!-- Empty state row -->
                        <tr v-if="!emails.length">
                            <td class="text-center border px-8 py-4" colspan="3">
                                <span>The emails that you post will appear here</span>
                                <span>
                                    <button class="bg-green-400 p-1 rounded-md text-white">
                                        <Link :href="route('company.post-job')">Post a Job</Link>
                                    </button>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Quill from 'quill/core';
import Toolbar from 'quill/modules/toolbar';
import Snow from 'quill/themes/snow';
import iziToast from 'izitoast';
import "izitoast/dist/css/iziToast.css";
import Swal from 'sweetalert2'

// CommonJS

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
        //console.log(this.emails);
        //this.new_template.content = "hello peter"
    },
    data() {
        return {
            template_modal: false,
            view_type: "",
            settings: this.$page.props.settings,
            current_template: {

            },
            current_index: 'hello there',
            new_template: {
                name: "",
                content: 'Hello',
                type: 'application_rejection',
            },
            modal_type: '',
            editedTemplate: {
                id: '',
                name: '',
                type: '',
                content: ''
            },
            viewModalVisible: false,
            viewedTemplate: null,
            editingTemplateIndex: null,
            emails: this.$page.props.emails,
            saving: false,
            saving_template: false,
            loading: [''],
        }
    },
    methods: {
        setDefaultTemplate(template_id){
            let template = this.emails.find(temp => temp.id === template_id);
            let keys = Object.keys(this.settings);
            let values = Object.values(this.settings);
            // send a request to the server
            axios.post(route('email.template.set-default'), {
                template_id: template_id,
                keys: keys
            }).then((response) => {
                if (response.data){
                    // update the default template in the ux
                    console.log(response);
                    this.settings = response.data;
                }
            }).catch(error => {
                console.log(error.response.data);
            })

        },
        viewTemplate(template) {
            this.viewModalVisible = true;
            this.viewedTemplate = template;
        },
        openEditModal() {
            this.viewModalVisible = false;
            this.modal_type = 'edit';
        },
        deleteTemplate(job) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete an email template",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    //alert('deleting')
                    this.loading.push(job.id);
                    axios.post(route('template.delete'), job).then(response => {
                        let index = this.emails.findIndex(element => element.id == job.id);
                        let loadingIndex = this.loading.indexOf(job.id);
                        console.log(response.data)
                        if (response.data) {
                            this.emails.splice(index, 1);
                            iziToast.success({ title: 'Success', message: 'Template was deleted succesfully' });
                            this.loading.splice(loadingIndex);
                        }
                    }).catch(error => {
                        console.log(error.response.data);
                        this.loading = '';
                    })
                    /* Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    ) */
                }
            })
        },
        saveEmailTemplate() {
            // validate the entered information
            if (!this.new_template.name || !this.new_template.type || !this.new_template.content) {
                return iziToast.error({ title: "Error", message: "Please fill in all information to proceed" });
            }
            this.saving_template = true;
            axios.post(route('template.store'), this.new_template).then((response) => {
                this.saving_template = false;
                if (response.data.id) {
                    // push the new template to the list
                    this.emails.push(response.data);
                    // close the email template modal
                    this.modal_type = ''
                    this.new_template = {
                        name: "",
                        content: '',
                        type: 'application_rejection',
                    };
                    return iziToast.success({ title: "Saved", message: "Template succesfully created" })
                }
            }).catch((error) => {
                this.saving_template = false;
                console.log(error.response.data)
            });
        },
        updateEditorContent(placeholder) {
            // Get the current content of the text editor
            let currentContent = this.new_template.content;

            console.log(currentContent);
            alert('you are here');

            // Get the Quill editor instance
            let quillEditor = this.$refs.quillEditor;

            /* // Get the current cursor position
            let cursorPosition = quillEditor.getSelection().index; */

            console.log(quillEditor.getQuill().selection.cursor.selection.savedRange.index);
            let cursorPosition = quillEditor.getQuill().selection.cursor.selection.savedRange.index;

            // Append the clicked placeholder to the current content
            let pretext;
            let posttext;
            let last_index;
            /* if(cursorPosition){
                // we have added 2 to compensate the space taken by html tags since this is an html editor
                pretext = currentContent.substring(0, cursorPosition+2);
                posttext = currentContent.substring(cursorPosition+2);
            }else{ */
            last_index = currentContent.lastIndexOf('<');
            pretext = currentContent.substring(0, last_index);
            posttext = currentContent.substring(last_index);
            //}


            let updatedContent = pretext + '[' + placeholder + ']' + posttext;

            // Update the content of the text editor
            this.new_template.content = updatedContent;
            //quillEditor.getQuill().focus(3);
        },
        viewEmailTemplate(template, index) {
            this.emailClicked(template, index, false);
            this.viewModalVisible = true;
            this.canEditTemplate = template.company_id === this.$page.props.user.company.id;
        },
        emailClicked(template, index, edit = true) {
            this.editedTemplate = { ...template };
            this.editingTemplateIndex = index;
            //if(edit){
            this.modal_type = 'edit';
            //}
        },
        selectionHasChanged(event) {
            console.log(event);
            //this.new_template.content = "Whats happening here";
        },
        statusUpdated(event) {
            let job_id = event.id;
            let status = event.status;
            let index = this.emails.findIndex(element => element.id === job_id);
            console.log(this.emails[index]);
            this.emails[index].status = status;
            //this.
        },
        editorChanged(html) {
            //alert(html)
            this.description = html;
            console.log(this.description);
        },
        submitJob() {
            this.saving = true;
            axios.post(route('job.save'), this.$data).then((response) => {
                console.log(response.data);
                if (response.data && response.data.id) {
                    // click the button to redirect
                    //this.$inertia.visit(route('company.job.view', response.data.slug))
                }
            }).catch((error) => {
                console.log(error.response.data);
                swal.fire('Error', 'Your job could not be saved', 'error');
            })
        },
        updateEmailTemplate() {
            // Validate the entered information
            if (!this.editedTemplate.name || !this.editedTemplate.type || !this.editedTemplate.content) {
                return iziToast.error({
                    title: 'Error',
                    message: 'Please fill in all information to proceed'
                });
            }

            this.saving_template = true;
            axios.post(route('template.update'), this.editedTemplate)
                .then(response => {
                    this.saving_template = false;
                    if (response.data) {
                        // Update the template in the emails array
                        this.emails[this.editingTemplateIndex] = { ...this.editedTemplate };

                        // Close the email template modal
                        this.modal_type = '';

                        // Reset the editedTemplate and editingTemplateIndex
                        this.editedTemplate = { name: '', type: '', content: '' };
                        this.editingTemplateIndex = null;

                        return iziToast.success({
                            title: 'Saved',
                            message: 'Template successfully updated'
                        });
                    }
                })
                .catch(error => {
                    this.saving_template = false;
                    console.log(error.response.data);
                });
        },
    },
    computed: {
        defaultSetting(){
            let keys = Object.keys(this.settings);
            let values = Object.values(this.settings);
            return key => {
                let index = keys.indexOf(`default_${key}_template`);
                let setting = `default_${key}_template`;
                if (index < 0) {
                    // simply use the default
                    // find the first occurance in the template and user it
                    let default_temp = this.emails.find(template => template.type == key);
                    console.log(default_temp);
                    if(default_temp){
                        return default_temp.id;
                    }
                }
                return Number(values[index]);
            }
        },
        currentTemplateContent() {
            return this.emails[this.editingTemplateIndex]?.content ?? 'No content';
        },
        currentIndexContent() {
            return this.current_index;
        },
        current_template() {
            return this.current_template.content ?? "No content";
        },
        available_placeholders() {
            return type => {
                if (type) {
                    return this.$page.props.table_types[type].columns;
                }
                return [];
            }
        }
    },
    watch: {
    settings: {
        deep: true, // This option enables deep watching of the object properties
        handler(newSettings, oldSettings) {
        // Perform actions when the 'settings' property changes
        console.log('Settings changed:', newSettings);
        
        // You can add your logic here to update any UI elements based on the new settings
        // For example, if you want to update the default template display, you can do it here
        }
    }
},


}
</script>
  
<style scoped>
/* Custom styling */

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 8px;
}

th {
    background-color: #F3F4F6;
}

tr:nth-child(even) {
    background-color: #EDF2F7;
}

tr:hover {
    background-color: #E2E8F0;
}

button {
    cursor: pointer;
}
</style>
  