<template>
    <div>
        <section class=" gap-2">
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 px-2 py-8 self-center" v-if="!educations.length">
                <span class="p-2 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newEducation">
                        <span>Add Education</span>
                    </a>
                </span>
                <span class="p-2 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newEducation">
                        <span>Skip Step</span>
                    </a>
                </span>
            </div>
            <transition v-for="(education, index) in educations" :key="education" type="fade">
                    <div class="article-details border-gray-300 border p-2 my-1">
                        <div class="edit-education grid sm:grid-cols-2 md:grid-cols-6 gap-2"  v-if="education.editing">
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'degree_level_'+index" class="font-bold">Education Level</label>
                                <select class="border border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-5" v-model="educations[index].degree_level_id" :id="'degree_level_'+index">
                                    <option value="">Select Level</option>
                                    <option :value="level.id" v-for="level in education_levels">{{ level.name }}</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'degree_title_'+index" class="font-bold">Degree Title</label>
                                <input type="text" v-model="educations[index].degree_title" class="border border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-5" :id="'degree_title_'+index">
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'institution_'+index" class="font-bold">Institution Name</label>
                                <input type="text" v-model="educations[index].institute" class="border border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-5" :id="'education_institution_'+index">
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'country_'+index" class="font-bold">Country</label>
                                <select class="border border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-5" v-model="educations[index].country_id" :id="'country_'+index">
                                    <option value="">Select Country</option>
                                    <option :value="country.iso_3166_1_alpha2" v-for="country in countries">{{ country.name }}</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'start_year_'+index" class="font-bold">Start Year</label>
                                <input type="number" v-model="educations[index].start_year" class="border border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-5" :id="'start_year_'+index">
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'year_'+index" class="font-bold">End Year</label>
                                <div class="flex flex-row gap-2">
                                    <input v-if="educations[index].currently_studying" v-model="educations[index].year" type="number" :disabled="educations[index].currently_studying" class="border border-gray-300 disabled:bg-gray-200 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-5" :id="'year_'+index">
                                    <input v-else type="number" v-model="educations[index].year" class="border border-gray-300 disabled:bg-gray-200 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-5" :id="'year_'+index">
                                    <!-- <span class="self-center text-green-400 font-bold">Studying</span>
                                    <input @change="currently_studyingControl(index)" :checked="educations[index].currently_studying" class="self-center text-green-500 focus:border-green-500 focus:border" type="checkbox"> -->
                                </div>
                            </div>
                            <div class="md:col-span-6 flex space-x-1">
                                <input @change="currently_studyingControl(index)" :checked="educations[index].currently_studying" class="self-center text-green-500 focus:border-green-500 focus:border" type="checkbox">
                                <span class="self-center text-green-400 font-bold">Currently Studying</span>
                            </div>

                            <div class="md:col-span-6 flex flex-col">
                                <label :for="'responsibilities_'+index" class="font-bold">Achievements</label>
                                <textarea placeholder="Optional" v-model="educations[index].description" class="border border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-5" :id="'responsibilities_'+index"></textarea>
                            </div>
                            <div class="flex flex-row gap-2">
                                <button @click="cancelEdit(index)" class="bg-gray-400 hover:shadow-lg text-white p-2 self-center">Cancel</button>
                                <button :disabled="false" @click="addEducation(index)" class="bg-green-500 hover:shadow-lg text-white p-2 self-center">
                                    <span v-if="!educations[index].saving">Save</span>
                                    <Loader v-else :color="'white'"></Loader>
                                </button>
                                <!--<div class="bg-blue-600 justify-center py-4 px-2">
                                    <Loader :color="'white'"></Loader>
                                </div>-->
                            </div>
                        </div>
                        <section v-else class="view-education">
                            <div class="article-title">
                                <h5 class="text-green-400 font-bold">{{ education.degree_title }}</h5>
                                <h6 class="text-muted">{{ education.institute }}</h6>
                            </div>
                            <span class="text-muted italic">{{ education.start_year }} - </span>

                            <span class="text-muted italic">{{ education.currently_studying?'Present':education.year}}</span>
                            <span></span>
                            <div class="w-28" v-if="education.currently_studying">
                                <p class="text-green-500 border-green-500 text-sm self-center">Works Here</p>
                            </div>


                            <div class="flex flex-row">
                                <span class="flex-grow"><strong>{{ education.country }}</strong></span>
                                <div class="article-cta candidate-education-edit-delete flex">
                                    <a href="javascript:void(0)" @click.prevent="EditEducation(index)" class="btn btn-warning action-btn edit-education text-green-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" @click="remove(index)" class="btn btn-danger action-btn delete-education text-red-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
            </transition>
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 justify-right px-2 py-4 self-center" v-if="educations.length && allow_add">
                <span @click="newEducation" class="p-1 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500 self-center">
                    <a href="#" @click.prevent="">
                        <span>Add Another Education</span>
                    </a>
                </span>
                <Link :href="route('my-resume.edit.sectional', 'language')" class="bg-green-500 p-1 text-white text-center self-center">
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
    import {Head, Link} from '@inertiajs/inertia-vue3';

    export default {
        name: "EditEducation",
        props: {
            countries: {
                type: Object
            },
            industries: {
                type: Object
            },
            educations: {
                type: Object
            },
            education_levels: {
                type: Object
            },
            candidate_id: {
                type: Number
            }
        },
        components: {
            Loader, ActionMessage, Link, Head
        },
        mounted(){
            //console.log($page.props.)

        },
        data(){
            return {
                allow_add: true,
                /*educations: [
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
                        if(this.educations[index].id){
                            //alert('this is an already saved education')
                            axios.delete(route('delete.candidate.data', ['education', this.educations[index].id])).then((result) => {
                                if(result.data){
                                    // remove the education from the list
                                    this.educations.splice(index, 1)
                                }
                            }).catch((error) => {
                                console.log(error.response.data)
                            })
                        }
                        //this.educations.splice(index, 1)
                        /*Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )*/
                    }
                })


            },
            currently_studyingControl(index){
                this.educations[index].currently_studying = !this.educations[index].currently_studying;
            },
            allowAddControl(){
                let editing = 0;
                for(let x = 0; x < this.educations.length; x++){
                    if(this.educations[x].editing){
                        editing += 1;
                    }
                }
                this.allow_add = editing;
            },
            cancelEdit(index){
                this.educations[index].editing = false;
                this.educations[index] = this.educations[index].old;
                if(!this.educations[index].old){
                    this.educations.splice(index, 1);
                }
                this.allow_add = true;
            },
            EditEducation(index){
                this.educations[index].editing = true;
                this.educations[index].old = this.educations[index];
            },
            newEducation(){
                let newEdu = {
                    degree_title: '',
                    degree_level_id: '',
                    institute: '',
                    start_year: '',
                    year: '',
                    currently_studying: false,
                    country_id: '',
                    candidate_id: this.candidate_id,
                    description: "",
                    editing: true,
                    saving: false,
                    old: {}
                };
                this.allow_add = false;
                console.log(newEdu);
                this.educations.push(newEdu);
            },
            addEducation(index){
                this.educations[index].saving = true;
                this.educations[index].old = [];
                axios.post(route('save.candidate.data', 'education'), {
                    data: this.educations[index]
                }).then((result) => {
                    console.log(result.data);
                    if(result.data){
                        this.educations[index].editing = false;
                        this.educations[index].saving = false;
                        if(result.data.id){
                            this.educations[index] = result.data;
                            this.educations[index].saving = false;
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
