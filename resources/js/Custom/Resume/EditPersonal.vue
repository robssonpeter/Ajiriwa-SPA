<template>

    <div class="gap-y-4">
        <transition class="animate__animated" enter-active-class="animate__fadeInDown" leave-active-class="animate__fadeOut">
            <div class="content" id="personalContent" style="display: block;">
            <section class="md:grid md:grid-cols-3 gap-4 gap-y-4">
                <div class="input flex flex-col">
                    <label for="firstName" class="input-placeholder">First Name</label>
                    <input type="text" @change="changes" class="focus:border-green-400" id="firstName" v-model="personal.first_name">
                </div>
                <div class="input flex flex-col">
                    <label for="middleName" class="input-placeholder">Middle Name</label>
                    <input type="text" @change="changes" id="middleName" v-model="personal.middle_name">
                </div>
                <div class="input flex flex-col">
                    <label for="lastName" class="input-placeholder">Last Name</label>
                    <input type="text" @change="changes" id="lastName" v-model="personal.last_name">
                </div>
            </section>
            <section class="md:grid md:grid-cols-3 gap-4 mt-4">
                <div class="input flex flex-col">
                    <label>Gender</label>
                        <select name="gender" @change="changes" id="gender" v-model="personal.gender">
                            <option :value="''">Select</option>
                            <option :value="gender.id" v-for="gender in genders">{{ gender.name}}</option>
                        </select>
                </div>

                <div class="input flex flex-col">
                    <label for="nationality">Nationality</label>
                    <input type="text" @change="changes" id="nationality" placeholder="Nationality" v-model="personal.nationality">
                </div>
                <div class="input flex flex-col">
                    <label for="location">Location</label>
                    <input type="text" @change="changes" id="location" v-model="personal.address">
                </div>

                <div class="input flex flex-col">
                    <label for="professionalTitle">Professional Title</label>
                    <input type="text" @change="changes" name="professionalTitle" id="professionalTitle" v-model="personal.professional_title" placeholder="e.g Accountant">
                </div>

                <div class="input flex flex-col">
                    <label for="phone" class="input-placeholder">Phone Number</label>
                    <input type="text" name="phone" @change="changes" v-model="personal.phone" id="phone" placeholder="Phone Number">
                </div>
                <div class="input flex flex-col">
                    <label>Date of Birth</label>
                    <input type="date" @change="changes" name="date_of_birth" id="date_of_birth" placeholder="date of birth" v-model="personal.dob">
                </div>

                <div class="input flex flex-col">
                    <label>Work Status?</label>
                    <select name="workingStatus" id="workingStatus">
                    <option value="Working">Working</option>
                    <option value="Not Working">Not Working</option>
                </select>
                </div>
                <div class="input flex flex-col">
                <label>Marital Status</label>
                    <select name="maritalStatus" @change="changes" v-model="personal.marital_status" id="maritalStatus">
                        <option value="1">I'm Single</option>
                        <option value="2">I'm Married</option>
                    </select>
                </div>
                <div class="input flex flex-col">
                    <span class="invisible">save</span>
                    <transition enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">
                    <button v-if="changed" class="bg-green-500 p-2 text-white justify-center" @click="savePersonal" id="personalSave">
                        <Loader color="white" class="justify-center" v-if="saving"></Loader>
                        <span v-else>Save</span>
                    </button>
                    </transition>
<!--                    <transition enter-active-class="animate__animated animate__fadeIn" leave-active-class="animate__animated animate__fadeOut">-->
                    <Link :href="route('my-resume.edit.sectional', 'career')" v-if="personal.first_name && personal.last_name && !changed" class="hover:bg-green-500 hover:text-white text-white border bg-green-500 p-2 text-center">
                        <span class="flex flex-row gap-1 justify-center">
                            Next
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        </span>
                    </Link>
<!--                    </transition>-->
                </div>
            </section>

            <Modal :show="false">hello</Modal>
        </div>
        </transition>
    </div>

</template>

<script>
    import Modal from "@/Jetstream/Modal";
    import {Head, Link} from '@inertiajs/inertia-vue3';
    import Loader from "@/Custom/Loader";
    import 'animate.css'
    export default {
        name: "EditPersonal",
        components: {
            Modal, Head, Link, Loader
        },
        mounted(){
            console.log(Object.values(this.$page.props.data.personal));
        },
        data(){
            return {
                personal: this.$page.props.data.personal,
                genders: this.$page.props.data.genders,
                old: this.$page.props.data.personal2,
                changed: false,
                saving: false
            }
        },
        methods: {
            savePersonal(){
                //alert('saving personal information')
                this.saving = true;
                axios.post(route('save.candidate.data', 'personal'), {data: this.personal}).then((response) => {
                    console.log(response.data);
                    this.saving = false;
                    this.changed = false;
                }).catch((error) => {
                    console.log(error.response.data);
                })
            },
            changes(){
                let old = Object.values(this.$page.props.data.old);
                let newOne = Object.values(this.personal);
                console.log(old);
                let changed = false;

                for(let x = 0; x < old.length; x++){
                    console.log(old[x]+" - "+newOne[x]);
                    if(old[x] !== newOne[x]){
                        changed = true;
                    }
                }
                this.changed = changed;

                /*if(Object.values(this.personal) === Object.values(this.old)){
                    alert('nothing changed');
                }else{
                    alert('yeah we have some changes');
                }*/
                //this.changed = true;
            }
        }
    }
</script>

<style scoped>
    input:focus {
        border: none white;
    }

    select:focus {
        border: 0px none white;
    }

</style>
