<template>
    <div>
        <section class="">
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 px-2 py-8 self-center" v-if="!skills.length">
                <span class="p-2 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newSkill">
                        <span>Add Skill</span>
                    </a>
                </span>
                <span class="p-2 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newSkill">
                        <span>Skip Step</span>
                    </a>
                </span>
            </div>
            <div v-for="(skill, index) in skills" :key="skill" class="" type="fade">
                    <div class="article-details border-gray-300 border p-2 my-1">
                        <div class="edit-skill md:grid md:grid-cols-3 gap-2"  v-if="skill.editing">
                            <div class="flex flex-col py-2">
                                <label :for="'name_'+index" class="font-bold">Skill Name</label>
                                <input type="text" v-model="skills[index].name" class="border border-gray-300" :id="'name_'+index">
                            </div>
                            <div class="flex flex-col py-2">
                                <label :for="'reading_'+index" class="font-bold">Reading</label>
                                <select class="border border-gray-300" v-model="skills[index].rating" :id="'reading_'+index">
                                    <option value="">Select Level</option>
                                    <option :value="key" v-for="(level, key) in skill_levels">{{ level }}</option>
                                </select>
                            </div>

                            <div class="flex flex-row gap-2 py-3">
                                <button @click="cancelEdit(index)" class="bg-gray-400 self-end hover:shadow-lg text-white p-2">Cancel</button>
                                <button :disabled="false" @click="addSkill(index)" class="self-end bg-green-500 hover:shadow-lg text-white p-2">
                                    <span v-if="!skills[index].saving">Save</span>
                                    <Loader v-else class="py-2" :color="'white'"></Loader>
                                </button>
                            </div>
                        </div>
                        <section v-else class="view-skill flex">
                            <div class="article-title flex-grow">
                                <h5 class="text-green-400 font-bold">{{ skill.name }}</h5>
                                <h6 class="text-muted">
                                    <StarRating :value="skills[index].rating"></StarRating>
                                </h6>
                            </div>

                            <div class="flex flex-row self-end">
                                <div class="article-cta candidate-skill-edit-delete flex">
                                    <a href="javascript:void(0)" @click.prevent="EditSkill(index)" class="btn btn-warning action-btn edit-skill text-green-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" @click="remove(index)" class="btn btn-danger action-btn delete-skill text-red-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
            </div>
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 justify-right px-2 py-4 self-center" v-if="skills.length && allow_add">
                <span @click.prevent="newSkill" class="p-1 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500 self-center">
                    <a href="#" @click.prevent="">
                        <span>Add Another Skill</span>
                    </a>
                </span>
                <Link :href="route('my-resume.edit.sectional', 'awards')" class="bg-green-500 p-1 text-white text-center self-center">
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
        name: "EditSkill",
        props: {
            countries: {
                type: Object
            },
            industries: {
                type: Object
            },
            skills: {
                type: Object
            },
            skill_levels: {
                type: Object
            },
            candidate_id: {
                type: Number
            }
        },
        components: {
            Loader, ActionMessage, StarRating, Head, Link
        },
        mounted(){
            //console.log($page.props.)

        },
        data(){
            return {
                allow_add: true,
                /*skills: [
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
                        if(this.skills[index].id){
                            //alert('this is an already saved skill')
                            axios.delete(route('delete.candidate.data', ['skill', this.skills[index].id])).then((result) => {
                                if(result.data){
                                    // remove the skill from the list
                                    this.skills.splice(index, 1)
                                }
                            }).catch((error) => {
                                console.log(error.response.data)
                            })
                        }
                        //this.skills.splice(index, 1)
                        /*Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )*/
                    }
                })


            },
            currently_studyingControl(index){
                this.skills[index].currently_studying = !this.skills[index].currently_studying;
            },
            allowAddControl(){
                let editing = 0;
                for(let x = 0; x < this.skills.length; x++){
                    if(this.skills[x].editing){
                        editing += 1;
                    }
                }
                this.allow_add = editing;
            },
            cancelEdit(index){
                this.skills[index].editing = false;
                this.skills[index] = this.skills[index].old;
                if(!this.skills[index].old){
                    this.skills.splice(index, 1);
                }
                this.allow_add = true;
            },
            EditSkill(index){
                this.skills[index].editing = true;
                this.skills[index].old = this.skills[index];
            },
            newSkill(){
                let newEdu = {
                    name: '',
                    candidate_id: this.candidate_id,
                    rating: 4,
                    editing: true,
                    saving: false,
                    old: {}
                };
                this.allow_add = false;
                console.log(newEdu);
                this.skills.push(newEdu);
            },
            /*controlRating(index){
                this.skills[index].rating = ;
            },*/
            addSkill(index){
                this.skills[index].saving = true;
                this.skills[index].old = [];
                axios.post(route('save.candidate.data', 'skills'), {
                    data: this.skills[index]
                }).then((result) => {
                    console.log(result.data);
                    if(result.data){
                        this.skills[index].editing = false;
                        this.skills[index].saving = false;
                        if(result.data.id){
                            this.skills[index].id = result.data.id;
                            this.skills[index].saving = false;
                            //this.controlRating(index);
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
