<template>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <div class="bg-gray-200 min-h-screen px-8 ">
        <div class="rounded-md bg-white p-2 align-center">
            <span>hello there how are you doing</span>
        </div>
    </div><div class="bg-gray-200 min-h-screen px-8">
        <div class="rounded-md bg-white p-2 align-center">
            <span>hello there how are you doing</span>
        </div>
    </div>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Button  from "@/Jetstream/Button";
    export default {
        name: "Customize",
        components: {
            AppLayout, Head, Link, Button
        }
    }
</script>

<style scoped>

</style>
