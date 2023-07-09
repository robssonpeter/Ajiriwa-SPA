<template>
<div class="md:col-span-2 flex flex-col w-full">
    <div id="new-attachment-section" v-if="!file.media">
        <section class="flex flex-col">
            <label class="font-bold" :for="'certificate-'+index">{{ label }}</label>
            <input type="file" @change="fileUpload" :key="index" :id="'certificate-'+key" class="border border-gray-300">
        </section>
        <!--<div class="progress mt-2 " style="height: 5px">
            <div class="progress-bar" id="resume-progress-new" role="progressbar" style="width: 0%; height: 5px" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>-->
        <div class="form-group col-sm-12">
            <input type="hidden" class="w-full">
        </div>
    </div>
    <div class="flex flex-col" v-else>
        <label for="attached-file" class="font-bold sm:mt-4">{{ label }}</label>
        <div class="border flex border-gray-300 p-2">
            <small id="attached-file" class="flex-grow">{{ file.media.file_name }}</small>
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
</template>
<script>
    import Loader from "@/Custom/Loader";
    import Swal from "sweetalert2";
    export default {
        name: "FileUploader",
        components: {
            Loader
        },
        mounted(){
            
        }, 
        props: {
           key: {
                required: true
           },
           label: {

           },
           title: {

           },
           model:{
                type: String
           },
           model_id: {
                type: Number
           },
           collection: {
                type: String
           }
        },
        data() {
          return {
                file_name: "",
                file: {
                    media: null,       
                },
                upload_completed: "",
                upload_left: ""
          }
        },
        methods: {
            fileUpload(e){
                console.log(e.target.files);
                //let iteration = e.target.id.replace('certificate-', '');
                let title = this.title;
                let type = 'certificate';
                let id = 'attachment-new';
                let index = 'new';
                if(!title){
                    Swal.fire('Error', 'Please add the title of this file first', 'error');
                    e.target.value = null;
                    //$('#attachment-'+index).val('');
                    return;
                }
                let file = e.target.files || e.dataTransfer.files;
                if(file.length){
                    let formData = new FormData();
                    formData.append('files', file[0]);
                    formData.append('return', '1');
                    formData.append('model', this.model);
                    formData.append('model_id', this.model_id);
                    formData.append('collection', this.collection);
                    /* formData.append('candidate_id', this.candidate_id); */
                    formData.append('title', title);
                    axios.post(route('file.uploads'/* 'candidate.certificates' */), formData, {
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
                            this.file.media = response.data.data;
                            this.file.media_id = response.data.data.id;
                            
                            this.upload_completed = 0;
                            this.upload_left = 100;
                            
                            console.log(response.data);
                        }

                    }).catch(error => {
                        
                        this.upload_completed = 0;
                        this.upload_left = 100;
                        
                        console.log(error.response.data/*.message*/);
                        
                    })
                }
            }
        }
    }
</script>