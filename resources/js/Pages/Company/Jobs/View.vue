<template>
    <employer-layout title="Add Job">
        <div class="grid grid-cols-3 gap-3">
            <div class="z-40 px-4 min-h-screen col-span-2 bg-gray-50 text-gray-700 my-4 p-4 shadow-md description" v-html="$page.props.job.description">

            </div>
            <div class="col-span-1">
                <div class="sticky top-20 shadow-md p-4 flex flex-col text-gray-700">
                    <span><strong>Views:</strong> {{ $page.props.job.views_count }}</span>
                    <span><strong>Applications:</strong> <Link :class="$page.props.job.applications_count?'text-green-500 font-bold':''" :href="route('company.job.applications', $page.props.job.slug)">{{ $page.props.job.applications_count }}</Link></span>
                    <div>
                        <button @click="getRecommendedCandidates()" class="bg-green-500 text-white p-2 font-bold hover:bg-green-600 mt-2 rounded-md">Show Recommended Candidates</button>
                    </div>
                </div>
            </div>
        </div>
        <dialog-modal :show="candidates_modal" closeable="true" :max-width="candidates_modal_size">
            <template v-slot:title class="border-b">
                <div class="flex flex-row">
                    <span class="flex-grow text-gray-500 font-bold">Recommended Candidates</span>
                    <button @click="candidates_modal = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
            <template v-slot:content>
                <section v-if="candidate" class="hidden md:block md:col-span-2 lg:col-span-4 2xl:col-span-3 shadow-md pt-4 p-2 self-auto overflow-y-auto">
                    <button class="text-green-500  flex space-x-1 ml-8 hover:text-gray-700" title="Back to Candidates" @click="candidate = false; candidates_modal_size = 'md'">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 self-center">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        <span class="self-center">Back</span>
                    </button>
                    <profile-embed :candidate="candidate" :show_profile="true"></profile-embed>
                </section>
                <div class="text-gray-500" v-else>
                    <div v-if="!loading_candidates && !recommended_candidates.length">
                        <span>No candidates to display</span>
                    </div>
                    <div role="status" v-if="loading_candidates" v-for="x in 5" class="mb-2 space-y-8 animate-pulse md:space-y-0 md:space-x-8 md:flex md:items-center">
                        <div class="flex justify-center items-center h-24 bg-gray-300 rounded sm:w-48 md:w-32 dark:bg-gray-700">
                            <svg class="w-8 h-12 text-gray-200" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" fill="currentColor" viewBox="0 0 640 512"><path d="M480 80C480 35.82 515.8 0 560 0C604.2 0 640 35.82 640 80C640 124.2 604.2 160 560 160C515.8 160 480 124.2 480 80zM0 456.1C0 445.6 2.964 435.3 8.551 426.4L225.3 81.01C231.9 70.42 243.5 64 256 64C268.5 64 280.1 70.42 286.8 81.01L412.7 281.7L460.9 202.7C464.1 196.1 472.2 192 480 192C487.8 192 495 196.1 499.1 202.7L631.1 419.1C636.9 428.6 640 439.7 640 450.9C640 484.6 612.6 512 578.9 512H55.91C25.03 512 .0006 486.1 .0006 456.1L0 456.1z"/></svg>
                        </div>

                        <div class="w-full">
                            <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full mb-4"></div>
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 max-w-[480px] mb-2.5"></div>
                            <div class="h-2 bg-gray-200 rounded-full dark:bg-gray-700 mb-2.5"></div>
                        </div>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="my-1 grid grid-cols-3 border border-gray-300 sm:rounded-md" v-for="candidate in recommended_candidates">
                    <img :src="'https://placeimg.com/150/150/any?1'" class="h-24 rounded-l-md" alt="">
                    <div class="col-span-2 px-2">
                        <a href="#" class="text-green-500 font-bold md:text-xl" @click="viewCandidate(candidate.id)">{{ candidate.full_name }}</a>
                        <p>{{ candidate.professional_title }}</p>
                        <small>Experience: 4 Years</small>
                    </div>
                </div>
                </div>
            </template>
            <template v-slot:footer>
                <a v-if="candidate" :href="route('cv.print', candidate.id)" class="cursor-pointer bg-green-500 hover:bg-green-600 text-white font-bold p-1 rounded-md" @click="candidates_modal_size = '4xl'">Download CV</a>
            </template>

        </dialog-modal>
    </employer-layout>
</template>

<script>
    import EmployerLayout from "@/Layouts/EmployerLayout";
    import { Link } from "@inertiajs/inertia-vue3";
    import DialogModal from "@/Jetstream/DialogModal";
    import axios from "axios";
    import ProfileEmbed from "@/Custom/Resume/ProfileEmbed" 
    
    export default {
        name: "View",
        components: {
            EmployerLayout, Link, DialogModal, ProfileEmbed
        },
        data(){
            return {
                candidates_modal: false,
                candidates_modal_size: 'md',
                loading_candidates: false,
                recommended_candidates: [],
                candidate: false,
            }
        },
        methods: {
            getRecommendedCandidates(){
                this.candidates_modal = true; 
                //alert('fetching candidates');
                axios.post(route('company.candidates.recommend'), {
                    job_id: this.$page.props.job.id
                }).then((response) => {
                    this.recommended_candidates =  response.data;
                })
            },
            viewCandidate(id){
                this.candidates_modal_size = '4xl';
                let candidate = this.recommended_candidates.find(element => element.id === id);
                if(candidate){
                    this.candidate = candidate;
                }
            },
            
        }
    }
</script>

<style>

    div.description li {
        list-style-type: circle !important;
        list-style-position: outside !important;
        margin-left: 20px !important;
        /*margin-inside: 10px;*/

    }

    div.description li::before {
        color: mediumseagreen;
    }

    div.description h1{
        font-size: xx-large;
        font-weight: bold;
        margin-top: 10px;
    }
    div.description h2{
        font-size: x-large;
        font-weight: bold;
        margin-top: 8px
    }
    div.description h3{
        font-size: large;
        font-weight: bold;
    }
    div.description h4{
        margin-top: 8px;
    }
    div.description h5{
        margin-top: 8px;
    }
    .w-24 {
        width: 6rem !important;
    }
</style>
