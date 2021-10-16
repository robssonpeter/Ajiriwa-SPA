<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="border p-6 shadow-md rounded-lg bg-white">
            <div class="flex content-center lg:w-0 lg:flex-1 pt-3 pb-6">
                <Link :href="'/'" class="flex self-center space-x-2">
                    <span class="sr-only">Workflow</span>
                    <!-- <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt=""> -->
                    <img class="h-8 w-auto sm:h-10" :src="route('root')+'/images/ajiriwa-new-logo.png'" alt="">
                    <span class=" self-center text-2xl font-bold text-gray-500">Ajiriwa.net</span>
                </Link>
            </div>
            <p class="mb-3"><span class="text-green-400 font-bold">Welcome Aboard</span>, what are you looking for?</p>

            <div class="my-5 px-3">
                <Link :href="route('user.role.selected', 'candidate')"
                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-100">
                    <!-- Heroicon name: outline/cursor-click -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div class="ml-4">
                        <p class="text-base font-medium font-bold text-green-500 text-gray-900">
                            Looking for a Job
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            I'm a candidate searching for my dream job.
                        </p>
                    </div>
                </Link>
            </div>
            <div class="my-5 px-3">
                <Link :href="route('user.role.selected', 'employer')"
                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-100">
                    <!-- Heroicon name: outline/cursor-click -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <div class="ml-4">
                        <p class="text-base text-green-500 font-medium font-bold text-gray-900">
                            Looking to recruit
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            I'm an employer looking to fill a position at my company.
                        </p>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    export default {
        name: "UserSelect",
        components: {
            Link
        }
    }
</script>

<style scoped>

</style>
