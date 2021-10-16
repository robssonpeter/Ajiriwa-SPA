<template>
    <employer-layout title="Add Job">
        <div class="grid grid-cols-3 gap-3">
            <div class="z-40 px-4 min-h-screen col-span-2 bg-gray-50 my-4 p-4 shadow-md">
                <form :action="route('job.save')" @submit.prevent="submitJob" method="post" class="text-gray-500">

                    <section class="md:grid md:grid-cols-3 gap-4 gap-y-4">
                        <div class="input flex flex-col">
                            <label for="job_title" class="font-bold">Job Title</label>
                            <input type="text" v-model="title" class="focus:border-green-400 border-gray-300" id="job_title" required>
                        </div>
                        <div class="input flex flex-col">
                            <label for="reports_to" class="font-bold">Reports To</label>
                            <input type="text" v-model="reports_to" id="reports_to" class="focus:border-green-400 border-gray-300 " >
                        </div>
                        <div class="input flex flex-col">
                            <label for="location" class="font-bold">Location</label>
                            <input type="text" v-model="location" id="location" class="border-gray-300" required>
                        </div>
                    </section>

                    <section class="md:grid md:grid-cols-3 gap-4 gap-y-4 mt-4">
                        <div class="input flex flex-col">
                            <label for="job-type" class="font-bold">JobType</label>
                            <select name="job_type" id="job-type" v-model="job_type" class="border border-gray-300" required>
                                <option value="">Job Type</option>
                                <option :value="type.id" v-for="type in $page.props.jobTypes">{{ type.name }}</option>
                            </select>
                        </div>
                        <div class="input flex flex-col">
                            <label for="job-category" class="font-bold">Job Category</label>
                            <select name="category" v-model="category" id="job-category" class="border border-gray-300">
                                <option value="">Job Category</option>
                                <option :value="category.id" v-for="category in $page.props.categories">{{ category.name }}</option>
                            </select>
                        </div>
                        <div class="input flex flex-col">
                            <label for="cover-letter" class="font-bold">Require CoverLetter</label>
                            <select name="cover_letter" v-model="cover_letter" id="cover-letter" class="border border-gray-300">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </section>
                    <section class="py-4">
                        <span class="font-bold">Job Description</span>
                        <text-editor @change="editorChanged" v-model="description"></text-editor>
                    </section>
                    <div class="grid grid-cols-3 gap-3  ">
                        <section class="py-2 flex flex-col col-span-1" >
                            <label for="apply_method" class="font-bold">Applications Method</label>
                            <select name="apply_method" v-model="apply_method" id="apply_method" class="border border-gray-300">
                                <option value="ajiriwa">Through Ajiriwa.net (Recommended)</option>
                                <option value="url">My company's website</option>
                                <option value="email">Forward to my email</option>
                                <option value="description">I have specified in description</option>
                            </select>
                        </section>
                        <section class="py-2 flex flex-col col-span-1">
                            <label for="apply_method" class="font-bold">Applications Deadline</label>
                            <input type="date" v-model="deadline" class="border border-gray-300" required>
                        </section>
                        <section class="py-2 flex flex-col col-span-1">
                            <label for="apply_method" class="font-bold">Number of Positions</label>
                            <input type="number" v-model="number_of_posts" class="border border-gray-300" required>
                        </section>
                        <section class="py-2 flex flex-col col-span-3" v-if="apply_method === 'ajiriwa'">
                            <span class="text-green-300 font-bold">Your applications will submitted through ajiriwa.net</span>
                        </section>
                        <section class="py-2 flex flex-col col-span-3" v-if="apply_method === 'description'">
                            <span class="text-red-500 font-bold">Please be sure to specify the mode of application in your job description</span>
                        </section>
                        <section class="py-2 flex flex-col col-span-3" v-if="apply_method === 'url'">
                            <label for="apply-website" class="font-bold">Application Url</label>
                            <input type="url" id="apply-website" v-model="application_url" placeholder="Enter Url" class="border border-gray-300" required>
                        </section>
                        <section class="py-2 flex flex-col col-span-3" v-if="apply_method === 'email'">
                            <label for="apply-email" class="font-bold">Application Email</label>
                            <input type="email" id="apply-email" v-model="application_email" placeholder="Enter your email" class="border border-gray-300" required>

                            <label for="email-subject" class="mt-2 font-bold">Email Subject Line (Optional)</label>
                            <input type="email" id="email-subject" placeholder="Enter your email" class="border border-gray-300">
                        </section>

                        <button :disabled="saving" class="bg-green-400 hover:bg-green-500 text-white p-2">
                            <span v-if="!saving">Save</span>
                            <Loader color="white" v-else></Loader>
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
</template>

<script>
    import EmployerLayout from "@/Layouts/EmployerLayout";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import TextEditor from "@/Custom/TextEditor";
    import Input from "@/Jetstream/Input";
    import { QuillEditor } from '@vueup/vue-quill';
    import Loader from "@/Custom/Loader";
    export default {
        name: "Post",
        props: {
            title: String,
        },
        components: {
            EmployerLayout, Head, TextEditor, Input, QuillEditor, Loader
        },
        data(){
            return {
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
                company_id: this.$page.props.company.id,
                number_of_posts: 1
            }
        },
        methods: {
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
                        this.$inertia.visit(route('company.job.view', response.data.slug))
                    }
                }).catch((error) => {
                    console.log(error.response.data);
                    swal.fire('Error', 'Your job could not be saved', 'error');
                })
            }
        }

    }
</script>

<style scoped>

</style>
