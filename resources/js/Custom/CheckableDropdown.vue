<template>
    <Menu ref="hello" v-slot="{ active }" as="div" class="relative inline-block text-left self-center">
        <div>
            <MenuButton
                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-gray-500 border border-gray-400 bg-white rounded-md bg-opacity-20 hover:bg-opacity-30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
            >
                <button class="self-center">{{ label }}</button>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </MenuButton>
        </div>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems
                class="absolute left-0 w-72 z-50 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
            >
                <div class="px-1 py-1">
                    <MenuItem v-slot="{ close }" :key="`${item}-${index}`" v-for="(item, index) in items">                   
                        <button
                            @click="[event.preventDefault()]"
                            :class="[
                                                  active ? 'bg-violet-500 text-green-500' : 'text-gray-900',
                                                  'group flex rounded-md items-center space-x-2 w-full px-2 py-2 text-sm',
                                                ]"
                        >
                            <!--<EditIcon
                                :active="active"
                                class="w-5 h-5 mr-2 text-violet-400"
                                aria-hidden="true"
                            />-->
                            <input class="self-center" :checked="isSelected(item.value)" :id="item.value" @change="controlSelection" type="checkbox">
                            <section class="flex flex-col items-start self-start">
                                <span>{{ item.label.toUpperCase() }}</span>
                                <small class="float-left" v-if="item.alternative_label" @click.prevent="">{{ item.alternative_label?item.alternative_label:item.label.toUpperCase() }}</small>
                            </section>
                            
                        </button>
                    </MenuItem>
                </div>

            </MenuItems>
        </transition>
    </Menu>
</template>

<script>
    import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
    export default {
        name: "CheckableDropdown",
        components: {
            Menu, MenuButton, MenuItems, MenuItem
        },
        props: {
            items: {
                type: Object
            },
            label: {
                type: String
            },
            alternative_label: {
                type: String,
            },
            selected_options: {
                type: Array
            }
        },
        computed: {
            isSelected(){
                return value => {
                    if(this.selected_options.indexOf(value) > -1){
                        return true;
                    }
                    return false;
                }
            }
        },
        mounted(){
            this.selected = this.selected_options;
        },  
        data(){
            return {
                selected: [], 
                active: true
            }
        },
        methods: {
            controlSelection(event){
                let id = isNaN(Number(event.target.id))?event.target.id:Number(event.target.id);
                if(event.target.checked){
                    this.selected_options.push(id);
                }else{
                    let index = this.selected_options.indexOf(id);
                    if(index > -1){
                        this.selected_options.splice(index, 1);
                    }
                }
                //console.log(event.target)
                console.log('these are the filters');
                console.log(this.selected_options);
                this.$emit('changed', this.selected_options);
                //this.$refs.hello.click()
            }
        }
    }
</script>

<style scoped>

</style>
