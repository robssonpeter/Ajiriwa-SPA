<template>
    <div>
        <button v-if="job.promotion" class="rounded-md bg-black px-2 text-white" @click="promote_modal = true; getPromotionInsights()"><small>Insights</small></button>
        <button v-else class="rounded-md bg-green-400 px-2 text-white" @click="promote_modal = true"><small>Promote</small></button>
        
        <dialog-modal :show="promote_modal" :closeable="true" :max-width="'2xl'">
            <template v-slot:title>
                <div class="flex flex-row">
                    <span class="flex-grow text-gray-500 font-bold">Promote Job {{ job.title }}</span>
                    <button @click="promote_modal = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>

            <template v-slot:content>
                <span class="text-gray-600">Promote <span class="text-green-500 font-bold">{{ job.title }}</span> to reach more people</span>
                <div class="text-gray-600">
                    <section class="flex" v-if="loading">
                        <span class="flex-grow"></span>
                        <loader color="green" class="text-center"></loader>
                        <span class="flex-grow"></span>
                    </section>
                    <form v-else class="" @submit.prevent="submitPromotion">
                        <div class="mb-4 pt-2">
                            <label class="block font-bold mb-2" for="budget">
                            Budget
                            </label>
                            <input  v-model="budget" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3" id="budget" type="number" name="budget" required>
                            <small v-if="budget>=1000">You will get up to <span class="font-bold text-green-500">{{ boostedViews }}</span> boosted job views</small>
                        </div>
                        <div class="mb-4 pt-2">
                            <p class="text-lg font-bold">Targeted Audience</p>
                            <label class="block font-bold my-2" for="gender">
                            Gender
                            </label>
                            <select v-model="gender" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3" id="gender" name="gender">
                                <option value="">Any</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="location">
                            Location
                            </label>
                            <input v-model="location" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3" id="location" type="text" name="location">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="professional-title">
                            Professional Title
                            </label>
                            <input v-model="professional_title" class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3" id="professional-title" type="text" name="professional-title">
                        </div>
                        <button :id="'submit-prom-'+job.id" class="hidden bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Submit
                        </button>
                        </form>

                </div>
                <!--<text-editor></text-editor>-->
            </template>


            <template v-slot:footer>
                <div class="flex flex-row">
                    <span class="flex-grow"></span>
                    <button @click="clickSubmit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Submit
                    </button>
                    <!-- <button @click="$refs['submit-application'].click()"  class="bg-green-500 hover:shadow-lg text-white p-2 flex flex-row">
                        <span class="flex-grow"></span>
                        hello
                        <loader v-if="currently_applying" :color="'white'"></loader>
                        <span v-else>Apply</span>
                        <span class="flex-grow"></span>
                    </button> -->
                </div>
            </template>
        </dialog-modal>
    </div>
</template>
<script>
import DialogModal from "@/Jetstream/DialogModal";
import Loader from "@/Custom/Loader";
import axios from "axios";
import iziToast from "izitoast";
import "izitoast/dist/css/iziToast.min.css";
export default {
    name: "Promotion",
    components: {
        DialogModal, Loader
    },  
    props: {
        job: {
            type: Object,
            required: true
        }
    },
    mounted(){
        if(this.job.promotion){
            //this.getPromotionInsights();
            //this.loading = true;
            // call the check insights function

        }
    },
    computed: {
        boostedViews(){
            if(this.budget >= this.job.promotion_details.cost_per_impression){
                return Math.round(this.budget/(this.job.promotion_details.cost_per_impression+this.job.promotion_details.cost_per_click))
            }
            return 0;
        }
    },
    data(){
        return {
            loading: false,
            show_insights: false,
            promote_modal: false,
            budget: '',
            gender: '',
            location: '',
            professional_title: '',
        }
    },
    methods: {
        getPromotionInsights(){
            if(this.job.promotion){
                this.loading = true;
                //("fetching promotion details")
                axios.post("", {
                    promotion_id: this.job.promotion.PromotionID
                }).then(response => {
                    if(response.data){
                        
                    }
                    this.show_insights = true;
                }).catch(error => {

                })
            }
        },
        clickSubmit(){
            document.getElementById('submit-prom-'+this.job.id).click()
        },
        submitPromotion(){
            //alert('you are about to submit the promotion man')
            axios.post(route('promotion.submit'), {
                budget: this.budget,
                gender: this.gender,
                location: this.location,
                professional_title: this.professional_title,
                jobid: this.job.id
            }).then(response => {
                console.log(response.data)
                if(response.data > 0){
                    // show success message that promotion is  active
                    iziToast.success({message: "Promotion started successfully", title:"Done"});
                    // close the modal
                }else if(response.data == 0){
                    // show error message that promotion could not be started
                }else{
                    // show error message that there is insufficient balance
                    iziToast.error({message: "Promotion could not be started due to insufficient balance", title: "failed"})
                }
            }).catch(error => {

            })
        }
    }
}
</script>