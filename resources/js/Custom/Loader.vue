<template>
    <div :class="'flex space-x-2 object-center '+extra_class">
        <div :class="loaderClass" id="loader-1"></div>
        <div :class="loaderClass" id="loader-2"></div>
        <div :class="loaderClass" id="loader-3"></div>
    </div>
</template>

<script>
    export default {
        name: "Loader",
        props: {
            color: {
                type: String
            },
            css_class: {
                type: String
            }
        },
        computed: {
            extra_class() {
                return this.css_class??"p-2"
            },
            loaderClass(){
                if(this.color !== 'white'){
                    return 'bg-'+this.color+"-500 w-2 h-2 rounded-full animate-bounce object-center"
                }
                return 'bg-'+this.color+" w-2 h-2 rounded-full animate-bounce object-center"
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
