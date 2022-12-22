<template>
    <app-layout title="Company Info">
        <div class="mt-8 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="border py-6 px-8 shadow-md rounded-lg bg-white">
            <form action="" v-on:submit.prevent="submit">
                <div class="flex flex-col gap-4" id="account-content">
                    <div class="flex flex-col">
                        <label>What is your company name: </label>
                        <input required type="text" v-model="company.name" placeholder="Company Name" class="border border-gray-300" id="company" >
                        <p class="w3-text-red w3-small" id="error-company"></p>
                    </div>
                    <div class="flex flex-col">
                        <label>What is your company industry?</label>
                        <select v-model="company.industry_id" class="border border-gray-300" id="hires-per-year">
                            <option value="">Select</option>
                            <option :value="industry.id" v-for="industry in industries">{{ industry.name }}</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label>How many times do you hire per year?</label>
                        <select v-model="company.hires_per_year" class="border border-gray-300" id="hires-per-year">
                            <option value="">Select</option>
                            <option value="1">1 time</option>
                            <option value="5">2-5 times</option>
                            <option value="10">6-10 times</option>
                            <option value="10+">10+</option>
                            <option value="dont-know">I don't know</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label>Your Name:</label>
                        <input required type="text" v-model="user.name" class="border border-gray-300" placeholder="Full Name" id="name">
                        <p class="w3-text-red w3-small" id="error-name"></p>
                    </div>
                    <div class="flex flex-col">
                        <label>Your Phone:</label>
                        <input required type="number" v-model="user.phone" class="border border-gray-300" placeholder="Your Phone Number">
                        <p class="w3-text-red w3-small" id="error-phone"></p>
                    </div>
                    <div class="flex flex-col">
                        <label>How did you hear about us?:</label>
                        <select v-model="company.source" class="border border-gray-300" id="how-heard">
                            <option value="">Select</option>
                            <option value="search">Search Engine (Google, yahoo etc)</option>
                            <option value="friend">Friend</option>
                            <option value="tv/radio">TV/Radio</option>
                            <option value="youtube">Youtube</option>
                            <option value="social">Social Media (Facebook, Twitter etc)</option>
                            <option value="newspaper">Newspaper</option>
                        </select>
                    </div>
                    <button value="Continue" class="bg-green-500 text-white container py-2 mx-auto">
                        <span class="mt-2 mb-2" v-if="!saving">Continue</span>
                        <Loader v-else :color="'white'" class="p-4 container mx-auto"></Loader>
                    </button>
                    <button class="invisible"><Link :href="route('my-company.customize')" id="next">Next</Link></button>
                </div>
            </form>
        </div>
    </div>
    </app-layout>
</template>

<script>
    import {Head, Link} from '@inertiajs/inertia-vue3';
    import AppLayout from "@/Layouts/AppLayout";
    import Loader from "@/Custom/Loader";
    export default {
        name: "InitialInfo",
        components: {
            Link, Head, AppLayout, Loader
        },
        mounted(){
              //document.getElementById('next').click();
            console.log(this.company)
        },
        data(){
            return {
                saving: false,
                industries: this.$page.props.industries,
                company: {
                    name: this.$page.props.company.name,
                    hires_per_year: this.$page.props.company.hires_per_year,
                    source: this.$page.props.company.source,
                    industry_id: this.$page.props.company.industry_id
                },
                user: {
                    name: this.$page.props.user.name,
                    phone: this.$page.props.user.phone,
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
            }
        }
    }
</script>

<style scoped>

</style>
