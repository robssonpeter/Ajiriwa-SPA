<template>
    <app-layout title="Company Info">
        <div class="mt-8 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <!-- Subscription Packages Section -->
        <section class="py-10 bg-gray-100">
            <ajiriwa-balance :show_modal="balance_modal" :recharge_amount="recharge_amount"></ajiriwa-balance>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold text-gray-700 mb-6">Choose Your Subscription Plan</h2>
                <div class="flex flex-col md:flex-row justify-center gap-8">
                <!-- Basic Subscription Card -->
                <div class="bg-white shadow-lg rounded-lg p-6 flex-1 border border-green-400" v-for="plan in plans">
                    <span v-if="plan.id == current_plan" class="bg-green-500 text-white text-sm float-right -mt-6 -mr-6 rounded-tr-lg px-2 rounded-bl-lg">current</span>
                    <h3 class="text-lg font-bold text-gray-800 mb-4">{{ plan.name }}</h3>
                    <p class="text-gray-600 mb-4">{{ planPrice(plan) }}</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                    <li v-for="content in plan.contents">{{ renderLabel(content) }}</li>
                    </ul>
                    <a href="#" v-if="plan.id != current_plan" @click.prevent="getStarted(plan.id)" class="bg-green-500 text-white px-4 py-2 mt-8 rounded hover:bg-green-700 transition duration-300">Get Started</a>
                </div>
                <!-- Premium Subscription Card -->
                <!-- <div class="bg-white shadow-lg rounded-lg p-6 flex-1">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Premium Subscription</h3>
                    <p class="text-gray-600 mb-4">$19.99/month</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                    <li>Access to all premium features</li>
                    <li>Unlimited projects</li>
                    <li>Priority email and phone support</li>
                    </ul>
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 mt-8 rounded hover:bg-blue-700 transition duration-300">Get Started</a>
                </div> -->
                <!-- Enterprise Subscription Card -->
                <!-- <div class="bg-white shadow-lg rounded-lg p-6 flex-1">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Enterprise Subscription</h3>
                    <p class="text-gray-600 mb-4">Custom Pricing</p>
                    <ul class="list-disc list-inside text-gray-600 mb-4">
                    <li>Access to all premium features</li>
                    <li>Custom number of projects</li>
                    <li>24/7 priority email and phone support</li>
                    </ul>
                    <a href="#" class="bg-blue-600 text-white px-4 py-2 mt-8 rounded hover:bg-blue-700 transition duration-300">Contact Us</a>
                </div> -->
                </div>
            </div>
        </section>
    </div>
    </app-layout>
</template>

<script>
    import {Head, Link} from '@inertiajs/inertia-vue3';
    import AppLayout from "@/Layouts/AppLayout";
    import Loader from "@/Custom/Loader";
    import Swal from "sweetalert2";
    import AjiriwaBalance from "../../Custom/AjiriwaBalance.vue";
    import axios from 'axios';
    import { shallowEqual } from '@babel/types';
    import iziToast from 'izitoast';
    import "izitoast/dist/css/iziToast.css";
    export default {
        name: "InitialInfo",
        components: {
            Link, Head, AppLayout, Loader, AjiriwaBalance
        },
        mounted(){
              //document.getElementById('next').click();
            console.log(this.company)
            iziToast.success({title: "Success", message: "New plan has been activated"});
        },
        data(){
            return {
                current_plan: this.$page.props.current_plan.id,
                saving: false,
                balance_modal: false,
                recharge_amount: 5000,
                plans: this.$page.props.plans,
            }
        },
        computed: {
            renderLabel(content){
                return content => {
                    return content.label.replace(':val', content.value);
                }
            },
            planPrice(){
                return plan => {
                    let price = plan.price;
                    if(price){
                        return this.$page.props.currency+price.toLocaleString();
                    }
                    return "Free";
                }
            },
            allowed_active_jobs() {
                //console.log(this.$page.subscription);
                let content = this.$page.props.subscription.contents.find(element => element.name === 'allowed_active_jobs');
                if(content){
                    return content.value;
                }
            }    
        },
        methods: {
            submit(){
                //this.$inertia.post('')
                this.saving = true;
                axios.post(route('company.initial.save'), { company: this.company, user: this.user }).then((result) => {
                    if(result.data){
                        document.getElementById('next').click();
                    }
                }).catch((error) => {
                    console.log(error.response.data);
                })
            },
            getStarted(plan_id){
                //alert('You are about to subscribe to '+plan_id);
                // check the current balance
                let plan = this.plans.find(plan => plan.id == plan_id);
                axios.post(route('current.balance')).then(response => {
                    if(plan.price > response.data){
                        // show a sweet alert for confirmation
                        Swal.fire({
                            title: 'Insufficient Balance',
                            text: "Your current balance "+response.data.toLocaleString()+" is not enough for this package. Recharge?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#22C55E',
                            cancelButtonColor: '#A3A3A3',
                            confirmButtonText: 'Recharge!'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                this.balance_modal = true;
                                this.recharge_amount = plan.price - response.data;
                                /* Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                ) */
                            }
                        })
                    }else{
                        Swal.fire({
                            title: 'Subscribe?',
                            text: "This will deduct "+plan.price.toLocaleString()+" from your current balance. Continue?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#22C55E',
                            cancelButtonColor: '#A3A3A3',
                            confirmButtonText: 'Continue!'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                /* this.balance_modal = true;
                                this.recharge_amount = plan.price - response.data; */
                                axios.post(route('subscription.charge'), {
                                    amount: plan.price,
                                    plan_id: plan.id
                                }).then((response) => {
                                    // if successful change the current plan
                                    if(response.data){
                                        this.current_plan = plan_id;
                                    }
                                    // display a success message
                                    iziToast.success({title: "Success", message: "New plan has been activated"});
                                })
                                /* Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                ) */
                            }
                        })
                    }
                }).catch(error => {

                })
                // if the balance is sufficient display a confirmation that plan will cost the amount for the user to continue
                // if the balance is not sufficient as the user to recharge

            }
        }
    }
</script>

<style scoped>

</style>
