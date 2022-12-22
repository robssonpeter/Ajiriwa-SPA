<template>
    <div>
        <section class="">
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 px-2 py-8 self-center" v-if="!languages.length">
                <span class="p-2 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newLanguage">
                        <span>Add Language</span>
                    </a>
                </span>
                <span class="p-2 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newLanguage">
                        <span>Skip Step</span>
                    </a>
                </span>
            </div>
            <div v-for="(language, index) in languages" :key="language" class="" type="fade">
                    <div class="article-details border-gray-300 border p-2 my-1">
                        <div class="edit-language gap-y-2"  v-if="language.editing">
                            <div class="sm:col-span-2 md:col-span-8 flex flex-grow flex-col">
                                <label :for="'name_'+index" class="font-bold">Language Name</label>
                                <input type="text" v-model="languages[index].name" class="border border-gray-300" :id="'name_'+index">
                            </div>
                            <section class="md:grid md:grid-cols-4 gap-2 py-2">
                                <div class="flex flex-col">
                                    <label :for="'listening_'+index" class="font-bold">Listening</label>
                                    <select class="border border-gray-300" v-model="languages[index].listening" :id="'listening_'+index">
                                        <option value="">Select Level</option>
                                        <option :value="key" v-for="(level, key) in language_levels">{{ level }}</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label :for="'speaking_'+index" class="font-bold">Speaking</label>
                                    <select class="border border-gray-300" v-model="languages[index].speaking" :id="'speaking_'+index">
                                        <option value="">Select Level</option>
                                        <option :value="key" v-for="(level, key) in language_levels">{{ level }}</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                    <label :for="'reading_'+index" class="font-bold">Reading</label>
                                    <select class="border border-gray-300" v-model="languages[index].reading" :id="'reading_'+index">
                                        <option value="">Select Level</option>
                                        <option :value="key" v-for="(level, key) in language_levels">{{ level }}</option>
                                    </select>
                                </div>
                                <div class="flex flex-col">
                                <label :for="'writing_'+index" class="font-bold">Writing</label>
                                <select class="border border-gray-300" v-model="languages[index].writing" :id="'writing_'+index">
                                    <option value="">Select Level</option>
                                    <option :value="key" v-for="(level, key) in language_levels">{{ level }}</option>
                                </select>
                            </div>
                            </section>

                            <div class="flex flex-row gap-2">
                                <button @click="cancelEdit(index)" class="bg-gray-400 self-end hover:shadow-lg text-white p-2">Cancel</button>
                                <button :disabled="false" @click="addLanguage(index)" class="self-end bg-green-500 hover:shadow-lg text-white p-2">
                                    <span v-if="!languages[index].saving">Save</span>
                                    <Loader v-else class="py-2" :color="'white'"></Loader>
                                </button>
                            </div>
                        </div>
                        <section v-else class="view-language flex">
                            <div class="article-title flex-grow">
                                <h5 class="text-green-400 font-bold">{{ language.name }}</h5>
                                <h6 class="text-muted">
                                    <StarRating :value="languages[index].rating"></StarRating>
                                </h6>
                            </div>

                            <div class="flex flex-row self-end">
                                <div class="article-cta candidate-language-edit-delete flex">
                                    <a href="javascript:void(0)" @click.prevent="EditLanguage(index)" class="btn btn-warning action-btn edit-language text-green-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" @click="remove(index)" class="btn btn-danger action-btn delete-language text-red-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
            </div>
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 justify-right px-2 py-4 self-center" v-if="languages.length && allow_add">
                <span @click="newLanguage" class="p-1 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500 self-center">
                    <a href="#" @click.prevent="">
                        <span>Add Another Language</span>
                    </a>
                </span>
                <Link :href="route('my-resume.edit.sectional', 'skills')" class="bg-green-500 p-1 text-white text-center self-center">
                    <span>Next</span>
                </Link>
            </div>
        </section>
    </div>
</template>

<script>
    import axios from 'axios';
    import Loader from "@/Custom/Loader";
    import ActionMessage from "@/Jetstream/ActionMessage";
    import Swal from 'sweetalert2';
    import StarRating from "@/Custom/StarRating";
    import {Head, Link} from '@inertiajs/inertia-vue3';

    export default {
        name: "EditLanguage",
        props: {
            countries: {
                type: Object
            },
            industries: {
                type: Object
            },
            languages: {
                type: Object
            },
            language_levels: {
                type: Object
            },
            candidate_id: {
                type: Number
            }
        },
        components: {
            Loader, ActionMessage, StarRating, Link, Head
        },
        mounted(){
            //console.log($page.props.)

        },
        data(){
            return {
                allow_add: true,
                /*languages: [
                    {
                        title: 'Accountant',
                        institution: 'Sr Financial Consultants',
                        start_year: '2020',
                        year: '2021',
                        currently_studying: true,
                        description: "worked as the manager of the firm",
                        editing: false,
                        old: {}
                    },
                    {
                        title: 'Accountant',
                        institution: 'Sr Financial Consultants',
                        start_year: '2020',
                        year: '2021',
                        currently_studying: false,
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
                        if(this.languages[index].id){
                            //alert('this is an already saved language')
                            axios.delete(route('delete.candidate.data', ['language', this.languages[index].id])).then((result) => {
                                if(result.data){
                                    // remove the language from the list
                                    this.languages.splice(index, 1)
                                }
                            }).catch((error) => {
                                console.log(error.response.data)
                            })
                        }
                        //this.languages.splice(index, 1)
                        /*Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )*/
                    }
                })


            },
            currently_studyingControl(index){
                this.languages[index].currently_studying = !this.languages[index].currently_studying;
            },
            allowAddControl(){
                let editing = 0;
                for(let x = 0; x < this.languages.length; x++){
                    if(this.languages[x].editing){
                        editing += 1;
                    }
                }
                this.allow_add = editing;
            },
            cancelEdit(index){
                this.languages[index].editing = false;
                this.languages[index] = this.languages[index].old;
                if(!this.languages[index].old){
                    this.languages.splice(index, 1);
                }
                this.allow_add = true;
            },
            EditLanguage(index){
                this.languages[index].editing = true;
                this.languages[index].old = this.languages[index];
            },
            newLanguage(){
                let newEdu = {
                    name: '',
                    listening: '',
                    speaking: '',
                    reading: '',
                    writing: '',
                    candidate_id: this.candidate_id,
                    rating: 4,
                    editing: true,
                    saving: false,
                    old: {}
                };
                this.allow_add = false;
                console.log(newEdu);
                this.languages.push(newEdu);
            },
            controlRating(index){
                this.languages[index].rating = (this.languages[index].listening + this.languages[index].speaking + this.languages[index].reading + this.languages[index].writing)/4;
            },
            addLanguage(index){
                this.languages[index].saving = true;
                this.languages[index].old = [];
                axios.post(route('save.candidate.data', 'language'), {
                    data: this.languages[index]
                }).then((result) => {
                    console.log(result.data);
                    if(result.data){
                        this.languages[index].editing = false;
                        this.languages[index].saving = false;
                        if(result.data.id){
                            this.languages[index].id = result.data.id;
                            this.languages[index].saving = false;
                            this.controlRating(index);
                            this.allow_add = true;
                        }
                    }
                }).catch((error) => {
                    console.log(error.response.data)
                })
            }
        }
    }
</script>

<style scoped>

</style>
