<template>
    <div class="mx-2 flex py-2 space-x-2">
        <span class=" text-blue-500 self-center"><a href="#">Hello</a></span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class=" text-blue-500">There</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span>how are you</span>
    </div>
</template>

<script>
    export default {
        name: "BreadCrumb",
        props: {
            links: {
                type: Object,
            }
        }
    }
</script>

<style scoped>

</style>
