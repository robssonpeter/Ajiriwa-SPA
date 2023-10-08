<template>
    <div>
        <section class=" gap-2">
            <div class=" border-dotted focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400 text-center flex gap-3 px-2 py-8 self-center" v-if="!referees.length">
                <span class="p-2 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newReferee">
                        <span>Add Referee</span>
                    </a>
                </span>
                <span class="p-2 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newReferee">
                        <span>Skip Step</span>
                    </a>
                </span>
            </div>
            <transition v-for="(referee, index) in referees" :key="referee" type="fade">
                    <div class="article-details border-gray-300 border p-2 my-1">
                        <div class="edit-referee grid sm:grid-cols-2 md:grid-cols-6 gap-2"  v-if="referee.editing">
                            <div class="col-span-2 flex flex-col">
                                <label :for="'name_'+index" class="font-bold">Name</label>
                                <input placeholder="Full Name" type="text" v-model="referees[index].name" class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400" :id="'name_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'position_'+index" class="font-bold">Position</label>
                                <input type="text" v-model="referees[index].position" class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400" :id="'position_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'company_'+index" class="font-bold">Company</label>
                                <input type="text" v-model="referees[index].company" class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400" :id="'job_company_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'email_'+index" class="font-bold">Email</label>
                                <input type="email" v-model="referees[index].email" class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400" :id="'email_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'phone_'+index" class="font-bold">Phone</label>
                                <input class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400" type="tel" v-model="referees[index].phone" :id="'phone_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'postal_address_'+index" class="font-bold">Postal Address</label>
                                <input type="text" v-model="referees[index].postal_address" class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400" :id="'postal_address_'+index">
                            </div>

                            <div class="flex flex-row gap-2">
                                <button @click="cancelEdit(index)" class="rounded-md bg-gray-400 hover:shadow-lg text-white p-2">Cancel</button>
                                <button :disabled="false" @click="addReferee(index)" class="bg-green-500 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-md hover:shadow-lg text-white p-2">
                                    <span v-if="!referees[index].saving">Save</span>
                                    <Loader v-else :color="'white'"></Loader>
                                </button>
                                <!--<div class="bg-blue-600 justify-center py-4 px-2">
                                    <Loader :color="'white'"></Loader>
                                </div>-->
                            </div>
                        </div>
                        <section v-else class="view-referee">
                            <div class="article-title">
                                <h5 class="text-green-400 font-bold">{{ referee.name }}</h5>
                                <h6 class="text-muted">{{ referee.position }} <span class="font-bold">{{ referee.position? "at " : "" }}{{ referee.company }}</span></h6>
                            </div>
                            <span class="text-muted italic"></span>

                            <div class="w-28">
                                <p class="text-green-500 border-green-500 text-sm self-center">{{ referee.email }}</p>
                            </div>


                            <div class="flex flex-row">
                                <span class="flex-grow flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <strong>{{ referee.phone }}</strong>
                                </span>
                                <div class="article-cta candidate-referee-edit-delete flex">
                                    <a href="javascript:void(0)" @click.prevent="editReferee(index)" class="btn btn-warning action-btn edit-referee text-green-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" @click="remove(index)" class="btn btn-danger action-btn delete-referee text-red-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
            </transition>
            <div class=" border-dotted focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400 text-center flex gap-3 justify-right px-2 py-4 self-center" v-if="referees.length && allow_add">
                <span @click="newReferee" class="rounded-md py-2 px-1 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="">
                        <span>Add Another Referee</span>
                    </a>
                </span>
                <Link :href="route('my-resume')" class="bg-green-500 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-md p-2 text-white text-center">
                    <span>View Final CV</span>
                </Link>

                <Link
                    :title="$page.props.return_to_link.description?$page.props.return_to_link.description:''"
                    class="bg-gray-600 hover:bg-black text-white font-semibold px-4 py-2 rounded-md p-2 text-white text-center self-center"
                    v-if="$page.props.return_to_link" 
                    :href="$page.props.return_to_link.link">{{ $page.props.return_to_link.label }}</Link>
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
        name: "EditReferee",
        props: {
            countries: {
                type: Object
            },
            industries: {
                type: Object
            },
            referees: {
                type: Object
            },
            candidate_id: {
                type: Number
            }
        },
        components: {
            Loader, ActionMessage, Head, Link
        },
        mounted(){
            //console.log($page.props.)

        },
        data(){
            return {
                allow_add: true,
                /*referees: [
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
                        if(this.referees[index].id){
                            //alert('this is an already saved referee')
                            axios.delete(route('delete.candidate.data', ['referee', this.referees[index].id])).then((result) => {
                                if(result.data){
                                    // remove the referee from the list
                                    this.referees.splice(index, 1);
                                    this.$emit('updated', true);
                                }
                            }).catch((error) => {
                                console.log(error.response.data)
                            })
                        }
                        //this.referees.splice(index, 1)
                        /*Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )*/
                    }
                })


            },
            currently_workingControl(index){
                this.referees[index].currently_working = !this.referees[index].currently_working;
            },
            allowAddControl(){
                let editing = 0;
                for(let x = 0; x < this.referees.length; x++){
                    if(this.referees[x].editing){
                        editing += 1;
                    }
                }
                this.allow_add = editing;
            },
            cancelEdit(index){
                this.referees[index].editing = false;
                this.referees[index] = this.referees[index].old;
                if(!this.referees[index].old){
                    this.referees.splice(index, 1);
                }
                this.allow_add = true;
            },
            editReferee(index){
                this.referees[index].editing = true;
                this.referees[index].old = this.referees[index];
            },
            newReferee(){
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
                this.referees.push(newExp);
            },
            addReferee(index){
                this.referees[index].saving = true;
                this.referees[index].old = [];
                axios.post(route('save.candidate.data', 'referee'), {
                    data: this.referees[index]
                }).then((result) => {
                    console.log(result.data);
                    if(result.data){
                        this.referees[index].editing = false;
                        this.referees[index].saving = false;
                        if(result.data.id){
                            this.referees[index].id = result.data.id;
                            this.referees[index].saving = false;
                            this.allow_add = true;
                        }
                        this.$emit('updated', true);
                    }
                }).catch((error) => {
                    console.log(error.response.data)
                })
            }
        }
    }
    //<style src="vue-tel-input/dist/vue-tel-input.css"></style>;
</script>

<style scoped>

</style>
