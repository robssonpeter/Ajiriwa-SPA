<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="border p-6 md:max-w-4xl shadow-md rounded-lg bg-white text-gray-600 items-center" v-if="$page.props.verifying">
            <span>Verification process is under way</span>
            <section class="flex flex-row pt-2 ">
                <div class="flex-grow"></div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 text-green-500 self-center">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div class="flex-grow"></div>
            </section>
            <section class="flex flex-row pt-2">
                <span class="flex-grow"></span>
                <small><Link class="bg-green-500 hover:bg-green-400 rounded-md text-white p-1" :href="route('dashboard')">Go to Dashboard</Link></small>
            </section>
        </div>
        <div class="border p-6 md:max-w-4xl shadow-md rounded-lg bg-white text-gray-600" v-else>
            <div class="flex content-center pt-3 pb-6">
                <span class=" self-center text-xl font-bold text-gray-500">Verification Required</span>
            </div>
            <p>Dear user, we are committed to making sure that employers registering on our platform are legitimate. Please supply a document that proves your connection with the company <strong>{{ $page.props.company.name }}</strong>.</p>
            <form action="" @submit.prevent="submitVerifications">
                <div class="my-d py-3 flex flex-col w-100">
                    <label for="" class="font-bold">Role at the company</label>
                    <input type="text" v-model="role_at_company" name="role_at_company" class="bg-green-100 border border-white border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" placeholder="Your role at the company" required>
                </div>
                <div class="my-d py-3 bg-gray-300 px-2">
                    <span class="font-bold">Required Documents:</span>
                    <ul>
                        <li v-for="(document, index) in $page.props.verification_documents">{{ index+1 }}. {{ document.value }}</li>
                    </ul>
                        
                </div>
                <div class="my-d py-3 flex flex-col w-100" v-for="(document, index) in $page.props.verification_documents">
                    <label for="" class="font-bold">{{ document.value }}</label>
                    <input type="file" name="role_at_company" :ref="'attachment-'+index" :id="'attachment-'+index" @change="handleFileUpload"
                        class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-1 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-violet-50 file:text-violet-700
                                hover:file:bg-violet-100 bg-green-100" 
                        placeholder="Your role at the company" 
                        required>
                    <div class="w-full bg-gray-200 h-1.5 mb-4 dark:bg-gray-700">
                    <div class="bg-green-500 h-1.5 dark:bg-green-400" :id="'resume-progress-'+index" style="width: 0%"></div>
                    </div>
                    <input class="form-control" required :value="attachedFiles(index)" :ref="'uploaded_file_'+index" :id="'uploaded_file_'+index" name="file[]" type="hidden">
                </div>

                <button class="bg-green-500 text-white p-2 float-right" :disabled="loading"><loader v-if="loading" color="white"></loader><span v-else>Submit</span></button>

            </form>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    import axios from 'axios';
    import iziToast from 'izitoast';
    import Loader from "@/Custom/Loader";
    export default {
        name: "UserSelect",
        components: {
            Link, Loader
        },
        mounted(){
            for(let x = 0; x < this.$page.props.verification_documents.length; x++){
                this.attached_files.push('');
            }
        },
        computed: {
            attachedFiles(){
                return index => {
                    return this.attached_files[index];
                }
            }
        },
        data(){
            return {
                loading: false,
                role_at_company: '',
                attached_files: [],
            }
        },
        methods: {
            submitVerifications(){
                //e.preventDefault();
                //processingBtn('#verifyForm', '#btn-submit-verification', 'loading');
                this.loading = true;
                axios.post(route('company.verification.save'), {
                    role_at_company: this.role_at_company,
                    file: this.attached_files,
                    profile_claiming: 1,
                }).then((response) => {  
                    iziToast.success({
                        title: "Success",
                        message: "You will be notified when verification process is complete"
                    })
                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                    this.loading = false;
                }).catch((error) => {
                    console.log(error.response.data)
                    //displayErrorMessage(result.responseJSON.message);
                    this.loading = false;
                });
            }, 
            handleFileUpload(e){
                let type = e.target.name;
                let id = e.target.id;
                let index = id.replace('attachment-', '');
                let file = e.target.files || e.dataTransfer.files;
                console.log(file[0]);
                if(file.length){
                    let formData = new FormData();
                    formData.append('attachment', file[0]);
                    axios.post(route('company.verification.upload'), formData, {
                        headers: {
                            'Content-type' : 'multipart/form-data'
                        },
                        onUploadProgress: function(progressEvent) {
                            let progress = document.getElementById('resume-progress-'+index);
                            var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                            progress.style.width = percentCompleted+"%";
                            console.log(percentCompleted)
                        }
                    }).then((response) => {

                        let progress = document.getElementById('resume-progress-'+index);
                        //progress.style.width = '0%';
                        this.attached_files[index] = response.data.saved;
                        //this.$refs['uploaded_file_'+index].value = response.data.saved;
                        //$('#uploaded_file_'+index).val(response.data.saved);
                        //displaySuccessMessage(uploadSuccess);
                        console.log(response.data);
                    }).catch(error => {
                        console.log(error.response.data)
                        let progress = document.getElementById('resume-progress-'+index);
                        progress.style.width = '0%';
                        this.attached_files[index] = '';
                        this.$refs['attachment-'+index].value = '';
                        this.$refs['uploaded_file_'+index].value = '';
                        displayErrorMessage(error.response.data.message);
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
