<template>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <div class="flex">
        <Head :title="title" />
        <aside class="h-screen sticky top-0">
            <section class="h-16 align-middle shadow-md pt-2 w-full">
                <Link :href="route('dashboard')" class="flex space-x-2 place-self-center">
                    <span class="sr-only">Workflow</span>
                    <!-- <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt=""> -->
                    <img class="h-8 w-auto sm:h-10" :src="route('root')+'/images/ajiriwa-new-logo.png'" alt="">
                    <span class=" self-center text-2xl font-bold text-gray-500">Ajiriwa.net</span>
                </Link>
            </section>
            <ul class="flex flex-col py-4">
                <li>
                    <Link :href="route('dashboard')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-home"></i></span>
                        <span class="text-sm font-medium">Dashboard</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('company.candidates.browse')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-search"></i></span>
                        <span class="text-sm font-medium">Search Candidates</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('company.jobs.index')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-collection"></i></span>
                        <span class="text-sm font-medium">Manage Jobs</span>
                    </Link>
                </li>
                <!-- <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-chat"></i></span>
                        <span class="text-sm font-medium">Chat</span>
                    </a>
                </li> -->
                <li>
                    <Link :href="route('my-company.customize')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-user"></i></span>
                        <span class="text-sm font-medium">Company Profile</span>
                    </Link>
                </li>
                <li>
                    <Link :href="route('company.email-templates')" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-envelope"></i></span>
                        <span class="text-sm font-medium">Email Templates</span>
                    </Link>
                </li>
                <!-- <li>
                    <a href="#" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-bell"></i></span>
                        <span class="text-sm font-medium">Notifications</span>
                        <span class="ml-auto mr-6 text-sm bg-red-100 rounded-full px-3 py-px text-red-500">5</span>
                    </a>
                </li> -->
                <li>
                    <a href="#" @click.prevent="$inertia.post(route('logout'))" class="flex flex-row items-center h-12 transform hover:translate-x-2 transition-transform ease-in duration-200 text-gray-500 hover:text-gray-800">
                        <span class="inline-flex items-center justify-center h-12 w-12 text-lg text-gray-400"><i class="bx bx-log-out"></i></span>
                        <span class="text-sm font-medium">Logout</span>
                    </a>
                </li>
            </ul>
        </aside>
        <main class="">
            <div class="h-16 bg-white shadow-md z-50 sticky top-0 w-full">
                
            </div>
            hello
            <slot></slot>
        </main>
    </div>
</template>

<script>
    import TheFooter from '@/Layouts/TheFooter';
    import { Head, Link } from '@inertiajs/inertia-vue3';
    export default {
        name: "EmployerLayout",
        components: {
            Head, Link
        },
        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            }
        }
    }
</script>

<style scoped>

</style>
