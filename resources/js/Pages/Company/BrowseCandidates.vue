<template>
    <employer-layout title="Browse Candidates">
        <div class="md:grid sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-6 xl:grid-7 gap-12 h-screen border border-b-2">
            <section class="col-span-1 sm:col-span-2 md:col-span-2 2xl:col-span-2 h-100 shadow-lg p-4 overflow-y-auto pb-8">
                <div class="flex flex-row py-2">
                    <input type="text" class="flex-grow border border-gray-300 rounded-l-md" placeholder="Search Jobs">
                    <button class="bg-green-500 px-2 text-white rounded-r-md">Search</button>
                </div>
                <div v-for="candidate in candidates" class="my-1 grid grid-cols-3 border border-gray-300 sm:rounded-md">
                    <img :src="candidate.logo_url??'https://placeimg.com/150/150/any?1'" class="h-24 rounded-l-md" alt="">
                    <div class="col-span-2 px-2">
                        <a href="#" @click.prevent="showCandidate(candidate)" class="text-green-500 font-bold">{{ candidate.full_name }}</a>
                        <p>{{ candidate.professional_title }}</p>
                        <small>{{ candidate.address }}</small>
                    </div>
                </div>
                
            </section>
            <section class="hidden md:block md:col-span-2 lg:col-span-4 2xl:col-span-3 shadow-lg p-2 self-auto overflow-y-auto">
                <profile-embed v-if="!current_candidate.empty" :candidate="current_candidate" :show_profile="true"></profile-embed>
            </section>
            <section class="hidden 2xl:block xl:col-span-2 shadow-lg">
                
            </section>
            
        </div>
    </employer-layout>
</template>

<script>
    import EmployerLayout from "@/Layouts/EmployerLayout";
    import ProfileEmbed from "@/Custom/Resume/ProfileEmbed"
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Input from "@/Jetstream/Input";
    import Loader from "@/Custom/Loader";
    import TimeAgo from 'vue3-timeago';
    import Dropdown from "@/Jetstream/Dropdown";
    import DropdownLink from "@/Jetstream/DropdownLink";
    import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
    import Modal from "@/Jetstream/Modal";
    import iziToast from "izitoast";
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
            ProfileEmbed
        },
        data(){
            return {
                candidates: this.$page.props.candidates,
                loading: false,
                current_candidate: {
                    empty: true
                }
            }
        },
        mounted(){
            //console.log(this.$data);
            //this['greet'].call(this, 'peter');
             console.log(this.applications);
             console.log(this.statuses)
        },
        methods: {
            showCandidate(candidate){
                //alert("showing canddate "+candidate.full_name)
                axios.post(route('candidate.get-info', candidate.id)).then(response => {
                    console.log('candidate information below')
                    console.log(response.data.candidate);
                    this.loading = false;
                    this.current_candidate = response.data.candidate;
                }).catch(error => {
                    this.loading = false;
                })
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
