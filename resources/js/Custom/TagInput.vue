<template>
    <div class="border border-dotted py-2 px-1 space-x-1 space-y-1">               
        <button class="text-xs bg-green-400 text-white p-1 rounded-md mb-2" v-for="tag, index in tags">
            <span class="self-center">{{ tag }}</span> 
            <span class="text-sm text-white cursor-pointer" @click="removeTag(index)">
                x
            </span>
        </button>
        <br v-if="tags.length">
        <!-- <small class="text-xs bg-green-400 text-white p-1 rounded-md ml-1">Nafasi za kazi serikalini</small> -->
        <textarea rows="1" @change="parseTag" @keyup="parseTag" v-model="current_tag" type="text" class="self-center ml-1 rounded-md border-gray-300 py-0 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" placeholder="Enter Keyword"></textarea>
    </div>
</template>

<script>
    export default {
        name: "TagInput",
        data(){
            return {
                tags: [],
                current_tag: ''
            }
        },
        methods: {
            removeTag(index){
                this.tags.splice(index, 1);
            },
            parseTag(event){
                if(this.current_tag.length && (event.key == 'Enter' || event.type =='change')){
                    let array = this.current_tag.split(',');
                    for(let x = 0; x < array.length; x++){
                        this.tags.push(array[x].replace('\n', ''));
                    }
                    this.current_tag = ""
                    this.$emit('changed', this.tags);
                }
            }
        }
    }
</script>

<style scoped>

</style>
