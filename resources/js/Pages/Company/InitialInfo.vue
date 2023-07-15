<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="border py-6 px-8 shadow-md rounded-lg bg-white">
            <form action="" v-on:submit.prevent="submit">
                <div class="flex flex-col gap-4" id="account-content">
                    <div class="flex flex-col relative">
                        <label>What is your company name:</label>
                        <input required type="text" @keyup="searchCompany" v-model="company.name" placeholder="Company Name"
                            class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400"
                            id="company" />
                        <div v-if="show_autocomplete && companies.length && company.name"
                            class="absolute z-10 mt-16 bg-white border border-gray-300 rounded-md shadow-lg w-full left-0">
                            <div class="px-4 py-2 cursor-pointer hover:text-white hover:bg-green-500"
                                @click="companySelected(comp.code); company.name = comp.label;" v-for="comp in companies">
                                {{ comp.label }}</div>
                        </div>
                        <p class="w3-text-red w3-small" id="error-company"></p>
                    </div>

                    <div class="flex flex-col">
                        <label>What is your company industry?</label>
                        <select v-model="company.industry_id" :disabled="show_autocomplete"
                            class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400"
                            id="hires-per-year">
                            <option value="">Select</option>
                            <option :value="industry.id" v-for="industry in industries">{{ industry.name }}</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label>How many times do you hire per year?</label>
                        <select v-model="company.hires_per_year" :disabled="show_autocomplete"
                            class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400"
                            id="hires-per-year">
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
                        <input required type="text" v-model="user.name" :disabled="show_autocomplete"
                            class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400"
                            placeholder="Full Name" id="name">
                        <p class="w3-text-red w3-small" id="error-name"></p>
                    </div>
                    <div class="flex flex-col">
                        <label>Your Phone:</label>
                        <input required type="number" v-model="user.phone" :disabled="show_autocomplete"
                            class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400"
                            placeholder="Your Phone Number">
                        <p class="w3-text-red w3-small" id="error-phone"></p>
                    </div>
                    <div class="flex flex-col">
                        <label>How did you hear about us?:</label>
                        <select v-model="company.source" :disabled="show_autocomplete"
                            class="focus:border-green-400 border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-green-400"
                            id="how-heard">
                            <option value="">Select</option>
                            <option value="search">Search Engine (Google, yahoo etc)</option>
                            <option value="friend">Friend</option>
                            <option value="tv/radio">TV/Radio</option>
                            <option value="youtube">Youtube</option>
                            <option value="social">Social Media (Facebook, Twitter etc)</option>
                            <option value="newspaper">Newspaper</option>
                        </select>
                    </div>
                    <button value="Continue" :disabled="show_autocomplete"
                        class="bg-green-500 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-md p-2 text-white text-center">
                        <span class="mt-2 mb-2" v-if="!saving">Continue</span>
                        <Loader v-else :color="'white'" class="p-4 container mx-auto"></Loader>
                    </button>
                    <button class="invisible">
                        <Link :href="route('my-company.customize')" id="next">Next</Link>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <dialog-modal :show="existing_company" :closeable="true" :max-width="'2xl'">
        <template v-slot:title>
            <div class="flex flex-row">
                <span class="flex-grow text-gray-500 font-bold">Existing Company</span>
                <!-- <button @click="existing_company = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button> -->
            </div>
        </template>
        <template v-slot:content class="text-lg">
            <div class="text-lg text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span>There is already a profile for company <strong>{{ company.name }}.</strong></span>
                <p>If you are working for this company, you can claim this profile by submitting some verification documents
                </p>
            </div>
        </template>
        <template v-slot:footer>
            <Link :href="route('company.claim.verify')" class="hidden" id="go_to_verify">Verify</Link>
            <button :disabled="verifying" @click="beginVerification" class="bg-green-500 rounded-md p-2 text-white">
                <span v-if="!verifying">Begin Verification</span>
                <loader v-else color="white"></loader>
            </button>
        </template>
    </dialog-modal>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import AppLayout from "@/Layouts/AppLayout";
import EmployerLayout from "@/Layouts/EmployerLayout";
import Loader from "@/Custom/Loader";
import DialogModal from "@/Jetstream/DialogModal";
export default {
    name: "InitialInfo",
    components: {
        Link, Head, AppLayout, Loader, EmployerLayout, DialogModal
    },
    mounted() {
        //document.getElementById('next').click();
        console.log(this.company)
    },
    data() {
        return {
            saving: false,
            verifying: false,
            industries: this.$page.props.industries,
            company: {
                name: this.$page.props.company.name,
                hires_per_year: this.$page.props.company.hires_per_year ?? "",
                source: this.$page.props.company.source ?? '',
                industry_id: this.$page.props.company.industry_id ?? "",
                id: null,
            },
            companies: [],
            show_autocomplete: false,
            existing_company: false,
            user: {
                name: this.$page.props.user.name,
                phone: this.$page.props.user.phone,
            }
        }
    },
    methods: {
        beginVerification(){
            this.verifying = true;
            axios.post(route('company.claiming', {company_id: this.company.id})).then((response) => {
                if(response.data){
                    // redirect to the page for verifying
                    document.getElementById('go_to_verify').click();
                }
            }).catch((error) => {
                this.verifying = false;
            })
        },
        companySelected(company_id) {
            // make
            this.company.id = company_id;
            this.companies = [];
            this.show_autocomplete = false;
            // prompt the user that the profile for that company already exist
            this.existing_company = true;
            // ask them that they have to verify their account to continue
            // 
        },
        searchCompany() {
            //alert('searching')
            if (this.company.name.length < 4) {
                return this.show_autocomplete = false;
            }
            axios.post(route("companies.search"), { keyword: this.company.name }).then((response) => {
                console.log(response.data);
                this.companies = response.data;
                this.show_autocomplete = true;
            }).catch((error) => {

            })
        },
        submit() {
            //this.$inertia.post('')
            this.saving = true;
            axios.post(route('company.initial.save'), { company: this.company, user: this.user }).then((result) => {
                if (result.data) {
                    document.getElementById('next').click();
                }
            }).catch((error) => {
                console.log(error.response.data);
            })
        }
    }
}
</script>

<style scoped></style>
