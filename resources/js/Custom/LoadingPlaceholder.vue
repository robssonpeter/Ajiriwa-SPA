<template>
    <div role="status" class="self-center animate-pulse md:space-y-0 md:space-x-8 md:items-center">
        <div class="h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 w-full"></div>
    </div>
</template>

<script>
    export default {
        name: "LoaderPlaceholder",
        data(){
            return {
                loader_class: 'bg-'+this.color+" w-2 h-2 rounded-full animate-bounce object-center"
            }
        }
    }
</script>

<style scoped>
    #loader-1 {
        animation-delay: 0.1s;
    }
    #loader-2 {
        animation-delay: 0.2s;
    }
    #loader-3 {
        animation-delay: 0.3s;
    }
</style>
