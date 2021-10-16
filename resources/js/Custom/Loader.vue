<template>
    <div class="flex space-x-2 py-2 object-center">
        <div :class="loader_class" id="loader-1"></div>
        <div :class="loader_class" id="loader-2"></div>
        <div :class="loader_class" id="loader-3"></div>
    </div>
</template>

<script>
    export default {
        name: "Loader",
        props: {
            color: {
                type: String
            }
        },
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
