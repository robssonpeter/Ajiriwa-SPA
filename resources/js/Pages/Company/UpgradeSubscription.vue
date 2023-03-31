<template>
    <app-layout title="Company Info">
        <div class="mt-8 flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="border py-6 px-8 shadow-md rounded-lg bg-white">
            <span>Your current subscription plan only allows {{ allowed_active_jobs }} active job at a time</span>
            <p class="my-4"><strong>Current Plan:</strong> <span class="text-green-500">{{ $page.props.subscription.name }}</span></p>   
            <section class="flex space-x-1 pt-4">
                <Link class="bg-gray-400 px-4 py-2 rounded" :href="route('company.jobs.index')">Manage Jobs</Link>
                <span class="invisible flex-grow">H</span>
                <Link class="bg-green-400 text-white px-4 py-2 rounded" :href="route('subscription.packages')">Change Subscription</Link>
            </section>
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
        computed: {
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
            }
        }
    }
</script>

<style scoped>

</style>
