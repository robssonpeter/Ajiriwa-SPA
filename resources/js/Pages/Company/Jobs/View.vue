<template>
    <employer-layout title="Add Job">
        <div class="grid grid-cols-3 gap-3">
            <div class="z-40 px-4 min-h-screen col-span-2 bg-gray-50 my-4 p-4 shadow-md" v-html="$page.props.job.description">

            </div>
            <div class="col-span-1">
                <div class="sticky top-20 shadow-md p-4 flex flex-col">
                    <span>Views: 123</span>
                    <span>Applications: 56</span>
                </div>
            </div>
        </div>
    </employer-layout>
</template>

<script>
    import EmployerLayout from "@/Layouts/EmployerLayout";
    export default {
        name: "View",
        components: {
            EmployerLayout
        }
    }
</script>

<style scoped>

</style>
