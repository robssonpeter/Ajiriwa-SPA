<template>
    <div  class="mx-2 border-t border-gray-300 shadow-md bg-white flex p-2 space-x-2 w-auto" >
            <section v-for="(link, index) in links" class="flex flex-row flex-fill">
                <span class=" text-green-500 self-center" v-if="link.url"><Link :href="link.url">{{ link.label }}</Link></span>
                <span class="text-gray-400" v-else>{{ link.label }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" v-if="index < links.length-1" class="h-4 w-4 self-center text-gray-400 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </section>

<!--        <span class=" text-green-500 self-center"><a href="#">Hello</a></span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class=" text-green-500">There</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span>how are you</span>-->
        <div class="absolute right-0 pr-4 md:pr-12 flex space-x-2 items-center">
            <div v-for="action in actions" class="self-center">
                <Link :href="action.url" :class="action.classes" v-if="action.is_spa">{{action.label}}</Link>
                <a :href="action.url" :class="action.classes" v-else>{{ action.label }}</a>
            </div>


        </div>
    </div>
</template>

<script>
    import {Link} from "@inertiajs/inertia-vue3";
    export default {
        name: "BreadCrumb",
        components: {
            Link
        },
        props: {
            links: {
                type: Array,
            },
            actions: {
                type: Array,
            }
        },
        methods: {
            render(){
                let html = '';
                for(let x = 0; x < this.links.length; x++){
                    if(this.links[x].url){
                        html += '<span class=" text-green-500 self-center"><Link href="'+this.links[x].url+'">'+this.links[x].label+'</Link></span>';
                        if(x < this.links.length){
                            html +=  '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">\n' +
                                '            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />\n' +
                                '        </svg>';
                        }
                    }
                }
                console.log(html)
                return html;
            }
        }
    }
</script>

<style scoped>

</style>
