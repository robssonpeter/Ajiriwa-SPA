<template>
    <div>
        <section class=" gap-2">
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 px-2 py-8 self-center" v-if="!experiences.length">
                <span class="p-2 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newExperience">
                        <span>Add Experience</span>
                    </a>
                </span>
                <span class="p-2 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newExperience">
                        <span>Skip Step</span>
                    </a>
                </span>
            </div>
            <transition v-for="(experience, index) in experiences" :key="experience" type="fade" mode="out-in" appear enter-active-class="animated bounceIn"
                        leave-active-class="animated bounceOut" >
                    <div class="article-details border-gray-300 border p-2 my-1">
                        <div class="edit-experience grid sm:grid-cols-2 md:grid-cols-6 gap-2"  v-if="experience.editing">
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'job_title_'+index" class="font-bold">Job Title</label>
                                <input type="text" v-model="experiences[index].title" class="border border-gray-300" :id="'job_title_'+index">
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'company_'+index" class="font-bold">Company</label>
                                <input type="text" v-model="experiences[index].company" class="border border-gray-300" :id="'job_company_'+index">
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'industry_'+index" class="font-bold">Industry</label>
                                <select class="border border-gray-300" v-model="experiences[index].industry_id" :id="'industry_'+index">
                                    <option value="">Select Industry</option>
                                    <option :value="industry.id" v-for="industry in industries">{{ industry.name }}</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'country_'+index" class="font-bold">Country</label>
                                <select class="border border-gray-300" v-model="experiences[index].country_id" :id="'country_'+index">
                                    <option value="">Select Country</option>
                                    <option :value="country.iso_3166_1_alpha2" v-for="country in countries">{{ country.name }}</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'start_date_'+index" class="font-bold">Start Date</label>
                                <input type="date" v-model="experiences[index].start_date" class="border border-gray-300" :id="'start_date_'+index">
                            </div>
                            <div class="md:col-span-2 flex flex-col">
                                <label :for="'end_date_'+index" class="font-bold">End Date</label>
                                <div class="flex flex-row gap-2">
                                    <input v-if="experiences[index].currently_working" v-model="experiences[index].end_date" type="date" :disabled="experiences[index].currently_working" class="border border-gray-300 disabled:bg-gray-200" :id="'end_date_'+index">
                                    <input v-else type="date" v-model="experiences[index].end_date" class="border border-gray-300 disabled:bg-gray-200" :id="'end_date_'+index">
                                    <span class="self-center text-green-400 font-bold">Working</span>
                                    <input @change="currently_workingControl(index)" :checked="experiences[index].currently_working" class="self-center text-green-500 focus:border-green-500 focus:border" type="checkbox">
                                </div>
                            </div>

                            <div class="md:col-span-6 flex flex-col">
                                <label :for="'responsibilities_'+index" class="font-bold">Responsibilities</label>
                                <textarea v-model="experiences[index].description" class="border border-gray-300" :id="'responsibilities_'+index"></textarea>
                            </div>
                            <div class="flex flex-row gap-2">
                                <button @click="cancelEdit(index)" class="bg-gray-400 hover:shadow-lg text-white p-2 self-center">Cancel</button>
                                <button :disabled="false" @click="addExperience(index)" class="bg-green-500 hover:shadow-lg text-white p-2 self-center">
                                    <span v-if="!experiences[index].saving">Save</span>
                                    <Loader v-else :color="'white'" class="text-red"></Loader>
                                </button>
                                <!--<div class="bg-blue-600 justify-center py-4 px-2">
                                    <Loader :color="'white'"></Loader>
                                </div>-->
                            </div>
                        </div>
                        <section v-else class="view-experience">
                            <div class="article-title">
                                <h5 class="text-green-400 font-bold">{{ experience.title }}</h5>
                                <h6 class="text-muted">{{ experience.company }}</h6>
                            </div>
                            <span class="text-muted italic">{{ experience.start_date_formatted }} - </span>

                            <span class="text-muted italic">{{ experience.currently_working ? 'Present' : experience.end_date_formatted }}</span>
                            <span v-if="experience.country"> | {{ experience.country }}</span>
                            <div class="w-28" v-if="experience.currently_working">
                                <p class="text-green-500 border-green-500 text-sm self-center">Works Here</p>
                            </div>


                            <div class="flex flex-row">
                                <span class="flex-grow"><strong>{{ experience.duration }}</strong></span>
                                <div class="article-cta candidate-experience-edit-delete flex">
                                    <a href="javascript:void(0)" @click.prevent="editExperience(index)" class="btn btn-warning action-btn edit-experience text-green-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" @click="remove(index)" class="btn btn-danger action-btn delete-experience text-red-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
            </transition>
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 justify-right px-2 py-4 self-center" v-if="experiences.length && allow_add">
                <span @click="newExperience" class="p-1 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500 self-center">
                    <a href="#" @click.prevent="">
                        <span>Add Another Experience</span>
                    </a>
                </span>

                <Link :href="route('my-resume.edit.sectional', 'education')" class="bg-green-500 p-1 text-white text-center self-center">
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
        name: "EditExperience",
        props: {
            countries: {
                type: Object
            },
            industries: {
                type: Object
            },
            experiences: {
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
                /*experiences: [
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
                        if(this.experiences[index].id){
                            //alert('this is an already saved experience')
                            axios.delete(route('delete.candidate.data', ['experience', this.experiences[index].id])).then((result) => {
                                if(result.data){
                                    // remove the experience from the list
                                    this.experiences.splice(index, 1)
                                }
                            }).catch((error) => {
                                console.log(error.response.data)
                            })
                        }
                        //this.experiences.splice(index, 1)
                        /*Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )*/
                    }
                })


            },
            currently_workingControl(index){
                this.experiences[index].currently_working = !this.experiences[index].currently_working;
            },
            allowAddControl(){
                let editing = 0;
                for(let x = 0; x < this.experiences.length; x++){
                    if(this.experiences[x].editing){
                        editing += 1;
                    }
                }
                this.allow_add = editing;
            },
            cancelEdit(index){
                this.experiences[index].editing = false;
                this.experiences[index] = this.experiences[index].old;
                if(!this.experiences[index].old){
                    this.experiences.splice(index, 1);
                }
                this.allow_add = true;
            },
            editExperience(index){
                this.experiences[index].editing = true;
                this.experiences[index].old = this.experiences[index];
            },
            newExperience(){
                let newExp = {
                    title: '',
                    company: '',
                    start_date: '',
                    end_date: '',
                    currently_working: false,
                    country_id: '',
                    industry_id: '',
                    candidate_id: this.candidate_id,
                    description: "",
                    editing: true,
                    saving: false,
                    old: {}
                };
                this.allow_add = false;
                console.log(newExp);
                this.experiences.push(newExp);
            },
            addExperience(index){
                this.experiences[index].saving = true;
                this.experiences[index].old = [];
                axios.post(route('save.candidate.data', 'experience'), {
                    data: this.experiences[index]
                }).then((result) => {
                    console.log(result.data);
                    if(result.data){
                        this.experiences[index].editing = false;
                        this.experiences[index].saving = false;
                        if(result.data.id){
                            this.experiences[index] = result.data;
                            this.experiences[index].saving = false;
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
.fade-enter{
    opacity: 0;
}
.fade-enter-active{
    transition: opacity 1s;
}
.fade-leave{
    /* opacity: 1; */
}
.fade-leave-active{
    transition: opacity 1s;
    opacity: 0;
}
</style>
