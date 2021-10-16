<template>
    <div>
        <section class=" gap-2">
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 px-2 py-8 self-center" v-if="!certificates.length">
                <span class="p-2 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newCertificate">
                        <span>Add Certificate</span>
                    </a>
                </span>
                <span class="p-2 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newCertificate">
                        <span>Skip Step</span>
                    </a>
                </span>
            </div>
            <transition v-for="(certificate, index) in certificates" :key="certificate" type="fade">
                    <div class="article-details border-gray-300 border p-2 my-1">
                        <div class="edit-certificate grid sm:grid-cols-2 md:grid-cols-6 gap-2"  v-if="certificate.editing">
                            <div class="col-span-2 flex flex-col">
                                <label :for="'name_'+index" class="font-bold">Title</label>
                                <input placeholder="Full Name" type="text" v-model="certificates[index].name" class="border border-gray-300" :id="'name_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'category_'+index" class="font-bold">Certificate Category</label>
                                <select class="border border-gray-300" v-model="certificates[index].category" :id="'degree_level_'+index">
                                    <option value="">Select Level</option>
                                    <option :value="category.id" v-for="category in categories">{{ category.name }}</option>
                                </select>
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'institution_'+index" class="font-bold">Awarding Institution</label>
                                <input type="text" v-model="certificates[index].institution" class="border border-gray-300" :id="'institution_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'completion_date_'+index" class="font-bold">Completion Date</label>
                                <input type="date" v-model="certificates[index].completion_date" class="border border-gray-300" :id="'completion_date_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'valid_until_'+index" class="font-bold">Valid Until <small>(leave blank if not applicable)</small></label>
                                <input type="date" v-model="certificates[index].valid_until" class="border border-gray-300" :id="'valid_until_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col w-full">
                                <div id="new-attachment-section" v-if="!certificates[index].media">
                                    <label :for="'certificate-'+index">Attachment</label>
                                    <input type="file" @change="fileUpload" :key="index" :id="'certificate-'+index" class="border border-gray-300">

                                    <!--<div class="progress mt-2 " style="height: 5px">
                                        <div class="progress-bar" id="resume-progress-new" role="progressbar" style="width: 0%; height: 5px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>-->
                                    <div class="form-group col-sm-12">
                                        <input type="hidden" class="w-full">
                                    </div>
                                </div>
                                <div class="flex flex-col" v-else>
                                    <label for="attached-file" class="font-bold">Attachment</label>
                                    <div class="border flex border-gray-300 p-2">
                                        <small id="attached-file" class="flex-grow">{{ certificates[index].media.file_name }}</small>
                                        <small class="text-green-300 cursor-pointer">change</small>
                                    </div>
                                </div>
                                <div class="flex py-1 flex-grow w-full">
                                    <div class="bg-green-500 h-1 rounded-l-md" :style="'width: '+upload_completed+'%'">

                                    </div>
                                    <div class="bg-green-200 h-1" :style="'width: '+upload_left+'%'">

                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-row gap-2">
                                <button @click="cancelEdit(index)" class="bg-gray-400 hover:shadow-lg text-white p-2">Cancel</button>
                                <button :disabled="false" @click="addCertificate(index)" class="bg-green-500 hover:shadow-lg text-white p-2">
                                    <span v-if="!certificates[index].saving">Save</span>
                                    <Loader v-else :color="'white'"></Loader>
                                </button>
                                <!--<div class="bg-blue-600 justify-center py-4 px-2">
                                    <Loader :color="'white'"></Loader>
                                </div>-->
                            </div>
                        </div>
                        <section v-else class="view-certificate">
                            <div class="article-title">
                                <h5 class="text-green-400 font-bold">{{ certificate.name }}</h5>
                                <h6 class="text-muted">{{ certificate.institution }} <!--<span class="font-bold">{{ "at "+certificate.company }}</span>--></h6>
                            </div>
                            <span class="text-muted italic"></span>

                            <div class="" v-if="certificate.completion_date">
                                <p class="text-sm self-center"><span>Completed in: </span><span class="text-green-500 text-sm self-center">{{ certificate.completion_date }}</span></p>
                            </div>


                            <div class="flex flex-row">
                                <span class="flex-grow flex gap-2 invisible">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <strong>{{ certificate.phone }}</strong>
                                </span>
                                <div class="article-cta candidate-certificate-edit-delete flex">
                                    <a href="javascript:void(0)" @click.prevent="editCertificate(index)" class="btn btn-warning action-btn edit-certificate text-green-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" @click="remove(index)" class="btn btn-danger action-btn delete-certificate text-red-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
            </transition>
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 justify-right px-2 py-4 self-center" v-if="certificates.length && allow_add">
                <span class="p-1 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newCertificate">
                        <span>Add Another Certificate</span>
                    </a>
                </span>
                <span class="p-1 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newCertificate">
                        <span>Next</span>
                    </a>
                </span>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';
    import Loader from "@/Custom/Loader";
    import ActionMessage from "@/Jetstream/ActionMessage";
    import Swal from 'sweetalert2';


    export default {
        name: "EditCertificate",
        props: {
            countries: {
                type: Object
            },
            industries: {
                type: Object
            },
            certificates: {
                type: Object
            },
            candidate_id: {
                type: Number
            },
            categories: {
                type: Object
            }
        },
        components: {
            Loader, ActionMessage
        },
        mounted(){
            console.log(this.certificates);
        },
        data(){
            return {
                allow_add: true,
                upload_completed: 0,
                upload_left: 100,
                /*certificates: [
                    {
                        title: 'Accountant',
                        company: 'Sr Financial Consultants',
                        start_date: '2020',
                        end_date: '2021',
                        currently_working: true,
                        description: "worked as the manager of the firm",
                        editing: false,
                        old: {}
                    },
                    {
                        title: 'Accountant',
                        company: 'Sr Financial Consultants',
                        start_date: '2020',
                        end_date: '2021',
                        currently_working: false,
                        description: "worked as the manager of the firm",
                        editing: true,
                        old: {}
                    },
                ]*/
            }
        },
        methods: {
            remove(index){
                // perform database removal
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',

                }).then((result) => {
                    //Swal.showLoading();
                    if (result.isConfirmed) {
                        if(this.certificates[index].id){
                            //alert('this is an already saved certificate')
                            axios.delete(route('delete.candidate.data', ['certificate', this.certificates[index].id])).then((result) => {
                                if(result.data){
                                    // remove the certificate from the list
                                    this.certificates.splice(index, 1)
                                }
                            }).catch((error) => {
                                console.log(error.response.data)
                            })
                        }
                        //this.certificates.splice(index, 1)
                        /*Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )*/
                    }
                })


            },
            currently_workingControl(index){
                this.certificates[index].currently_working = !this.certificates[index].currently_working;
            },
            allowAddControl(){
                let editing = 0;
                for(let x = 0; x < this.certificates.length; x++){
                    if(this.certificates[x].editing){
                        editing += 1;
                    }
                }
                this.allow_add = editing;
            },
            cancelEdit(index){
                this.certificates[index].editing = false;
                this.certificates[index] = this.certificates[index].old;
                if(!this.certificates[index].old){
                    this.certificates.splice(index, 1);
                }
                this.allow_add = true;
            },
            editCertificate(index){
                this.certificates[index].editing = true;
                this.certificates[index].old = this.certificates[index];
            },
            newCertificate(){
                let newExp = {
                    name: '',
                    institution: '',
                    category: '',
                    media_id: '',
                    country_id: '',
                    valid_until: '',
                    completion_date: '',
                    candidate_id: this.candidate_id,
                    editing: true,
                    saving: false,
                    old: {}
                };
                this.allow_add = false;
                console.log(newExp);
                this.certificates.push(newExp);
            },
            addCertificate(index){
                this.certificates[index].saving = true;
                this.certificates[index].old = [];
                axios.post(route('save.candidate.data', 'certificates'), {
                    data: this.certificates[index]
                }).then((result) => {
                    console.log(result.data);
                    if(result.data){
                        this.certificates[index].editing = false;
                        this.certificates[index].saving = false;
                        if(result.data.id){
                            this.certificates[index].id = result.data.id;
                            this.certificates[index].saving = false;
                            this.allow_add = true;
                        }
                    }
                }).catch((error) => {
                    console.log(error.response.data)
                })
            },
            removeFile(media_id){
                axios.delete(route('delete.candidate.file', ['media', media_id])).then((result) => {
                    if(result.data){
                        // remove the certificate from the list
                        //this.certificates.splice(index, 1)
                    }
                }).catch((error) => {
                    console.log(error.response.data)
                })
            },
            fileUpload(e){
                console.log(e.target.files);
                let iteration = e.target.id.replace('certificate-', '');
                let title = this.certificates[iteration].name;
                let type = 'certificate';
                let id = 'attachment-new';
                let index = 'new';
                if(!title){
                    Swal.fire('Error', 'Please add the title of this certificate first', 'error');
                    e.target.value = null;
                    //$('#attachment-'+index).val('');
                    return;
                }
                let file = e.target.files || e.dataTransfer.files;
                if(file.length){
                    let formData = new FormData();
                    formData.append('file', file[0]);
                    formData.append('return', '1');
                    formData.append('candidate_id', this.candidate_id);
                    formData.append('title', title);
                    axios.post(route('candidate.certificates'), formData, {
                        headers: {
                            'Content-type' : 'multipart/form-data'
                        },
                        onUploadProgress: function(progressEvent) {
                            this.upload_completed = Math.round((progressEvent.loaded * 100) / progressEvent.total)
                            this.upload_left = 100 - this.upload_completed;
                            console.log(this.upload_completed);
                        }
                    }).then((response) => {
                        console.log(response.data);
                        if(response.data.success){
                            this.certificates[iteration].media = response.data.data;
                            this.certificates[iteration].media_id = response.data.data.id;
                            //let progress = document.getElementById('resume-progress-'+index);
                            //progress.style.width = '0%';
                            //$('#addAchievementAttachment').append($('<option></option>').attr('value', response.data.data.id).text(title));
                            //$('#attachment-'+index).val('');
                            //progress.style.width = '0%';
                            this.upload_completed = 0;
                            this.upload_left = 100;
                            //$("#new-attachment-section").slideUp('slow');
                            //$('#addAchievementAttachment').val(response.data.data.id);
                            //$('#uploaded_file_'+index).val(response.data.saved);
                            //displaySuccessMessage(response.data.message);
                            console.log(response.data);
                        }

                    }).catch(error => {
                        //console.log(error.response.data)
                        //let progress = document.getElementById('resume-progress-'+index);
                        //progress.style.width = '0%';
                        this.upload_completed = 0;
                        this.upload_left = 100;
                        //$('#attachment-'+index).val('');
                        console.log(error.response.data/*.message*/);
                        //swal('Error', error.response.data.message, 'error');

                        //console.log(error.response.data.errors.attachment);
                    })
                }
            }
        }
    }
    //<style src="vue-tel-input/dist/vue-tel-input.css"></style>;
</script>

<style scoped>

</style>
