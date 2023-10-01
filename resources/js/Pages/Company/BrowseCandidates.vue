<template>
    <employer-layout title="Browse Candidates">
        <div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Search Candidates/Resumes</h1>

    <!-- Search Input -->
    <div class="mb-4">
        <div class="relative">
          <input type="text" @keyup.enter="findCandidate()" v-model="keyword" placeholder="Search..." class="w-full py-2 px-4 rounded-l bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
          <button @click="findCandidate()" class="absolute inset-y-0 right-0 flex items-center px-4 bg-green-500 hover:bg-green-600 text-white rounded-r">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
          </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 pt-2">
          <!-- Work Experience Filter -->
          <div>
            <label class="block text-gray-800 font-semibold mb-1">Work Experience</label>
            <select v-model="workExperienceFilter" class="w-full py-2 px-4 rounded bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">Any</option>
              <option value="0-1">0-1 Years</option>
              <option value="1-3">1-3 Years</option>
              <option value="3-5">3-5 Years</option>
              <option value="5+">5+ Years</option>
            </select>
          </div>

          <!-- Industry Filter -->
          <div>
            <label class="block text-gray-800 font-semibold mb-1">Industry</label>
            <select v-model="industryFilter" class="w-full py-2 px-4 rounded bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">Any</option>
              <option value="IT">IT</option>
              <option value="Finance">Finance</option>
              <option value="Healthcare">Healthcare</option>
              <option value="Marketing">Marketing</option>
              <!-- Add more industry options -->
            </select>
          </div>

          <!-- Location Filter -->
          <div>
            <label class="block text-gray-800 font-semibold mb-1">Location</label>
            <select v-model="locationFilter" class="w-full py-2 px-4 rounded bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
              <option value="">Any</option>
              <option value="New York">New York</option>
              <option value="London">London</option>
              <option value="San Francisco">San Francisco</option>
              <option value="Tokyo">Tokyo</option>
              <!-- Add more location options -->
            </select>
          </div>
        </div>
    </div>
    <!-- Search Results -->
    <div class="pt-4">
      <h2 class="text-xl font-bold text-gray-800 mb-2">Search Results</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 -mx-4 mt-4">
        <div class="w-full col-span-1 px-4 mb-4" v-for="candidate in candidates">
            <div v-if="searching" class="bg-white border border-gray-100 rounded-lg shadow-lg p-6 animate-pulse">
              <div class="flex items-center mb-4">
                <div class="h-12 w-12 bg-gray-300 rounded-full mr-4"></div>
                <div>
                  <div class="h-4 bg-gray-300 w-20 mb-2"></div>
                  <div class="h-3 bg-gray-300 w-28"></div>
                </div>
              </div>
              <div class="flex flex-wrap">
                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2 mb-2 h-5 w-20"></span>
                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2 mb-2 h-5 w-24"></span>
                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2 mb-2 h-5 w-28"></span>
              </div>
            </div>
          <div v-else class="bg-white border border-gray-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center mb-4">
              <img class="w-12 h-12 rounded-full mr-4" :src="candidate.logo_url" :alt="candidate.full_name">
              <div>
                  <h3 class="text-xl font-semibold"><a href="#" @click.prevent="candidate_modal = true; showCandidate(candidate)" class="text-green-500 font-bold cursor-pointer">{{ candidate.full_name }}</a></h3>
                  <p class="text-gray-800">{{ candidate.professional_title }}</p>
                  <small class="text-gray-500">{{ candidate.address }}</small>
              </div>
            </div>

            <div class="flex flex-wrap">
                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2 mb-2">Java</span>
                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2 mb-2">Python</span>
                <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2 mb-2">JavaScript</span>
            </div>
         </div>
        </div>        
      </div>
    </div>


      <!-- Pagination -->
      <div class="mt-4 flex justify-center" v-if="prev_page || next_page">
        <button @click="findCandidate('prev')" :disabled="prev_page?false:true" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-l">
          Previous
        </button>
        <button @click="findCandidate('next')" :disabled="next_page?false:true" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-r">
          Next
        </button>
      </div>
      <div class="mt-4 flex justify-center" v-else>
        <Link :disabled="$page.props.prev?false:true" :href="$page.props.prev" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-l">
          Previous
        </Link>
        <Link :disabled="$page.props.next?false:true" :href="$page.props.next" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-r">
          Next
        </Link>
      </div>



  </div>
        
    <!-- Profile Modal -->
    <dialog-modal :show="candidate_modal" closeable="true" :max-width="'4xl'">
        <template v-slot:title>
            <div class="flex flex-row">
                <span class="flex-grow text-gray-500 font-bold">Candidate</span>
                <button @click="candidate_modal = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </template>
        <template v-slot:content>
            <section class="flex" v-if="loading">
                <span class="flex-grow"></span>
                <loader color="green"></loader>
                <span class="flex-grow"></span>
            </section>
            <profile-embed v-if="current_candidate.id && !loading" :candidate="current_candidate" :show_profile="true"></profile-embed>
        </template>
        <template v-slot:footer>
            <a v-if="current_candidate.id && !loading" :href="route('cv.print', current_candidate.id)" class="bg-red-500 text-white rounded-md p-1 mr-2">
                <span class="text-sm">Export to PDF</span>
            </a>
        </template>
    </dialog-modal>
    </employer-layout>
</template>

<script>
    import EmployerLayout from "@/Layouts/EmployerLayout";
    import ProfileEmbed from "@/Custom/Resume/ProfileEmbed";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Input from "@/Jetstream/Input";
    import Loader from "@/Custom/Loader";
    import TimeAgo from 'vue3-timeago';
    import Dropdown from "@/Jetstream/Dropdown";
    import DropdownLink from "@/Jetstream/DropdownLink";
    import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
    import Modal from "@/Jetstream/Modal";
    import iziToast from "izitoast";
    import DialogModal from "@/Jetstream/DialogModal";
    import "izitoast/dist/css/iziToast.min.css"
import axios from "axios";
    export default {
        name: "Applications",
        components: {
            EmployerLayout,
            Head,
            Input,
            Loader,
            Link,
            TimeAgo,
            Dropdown,
            DropdownLink,
            Menu,
            MenuButton,
            MenuItems,
            MenuItem,
            Modal,
            ProfileEmbed,
            DialogModal
        },
        data(){
            return {
                candidates: this.$page.props.candidates,
                loading: false,
                searching: false,
                next_page: '',
                prev_page: '',
                keyword: '',
                locationFilter: '',
                workExperienceFilter: '',
                industryFilter: '',
                candidate_modal: false,
                current_candidate: {
                    empty: true
                }
            }
        },
        mounted(){
/*  
             console.log(this.applications);
             console.log(this.statuses) */
        },
        methods: {
            showCandidate(candidate){
                this.loading = true;
                //alert("showing canddate "+candidate.full_name)
                axios.post(route('candidate.get-info', candidate.id)).then(response => {
                    console.log('candidate information below')
                    console.log(response.data.candidate);
                    this.loading = false;
                    this.current_candidate = response.data.candidate;
                    console.log(this.current_candidate)
                }).catch(error => {
                    this.loading = false;
                })
            },
            findCandidate(page=''){
                //return alert('now searching for '+this.keyword);
                this.searching = true;
                let url;
                if(page == ''){
                    url = route('company.candidates.search');
                }
                else if(page == 'next')
                {
                    url = this.next_page
                }
                else
                {
                    url = this.prev_page
                }
                axios.post(url, {
                    keyword: this.keyword,
                    experience: this.workExperienceFilter,
                    location: this.locationFilter,
                    industry: this.industryFilter
                }).then(response => {
                    this.candidates = response.data.items;
                    this.searching = false
                    this.next_page = response.data.next;
                    this.prev_page = response.data.prev;
                }).catch(error => {
                    console.log(error.response.data);
                    this.searching = false;
                });
            }
        },
        computed: {
            total_application(){
                return this.applications[this.active_tab].length
            }
        }
    }
</script>

<style scoped>

</style>
