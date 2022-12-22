require('./bootstrap');
import { createApp, h } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

createApp({
    data(){
        return {
            dropdowns: {
                one: {
                    is_open: false
                },
                two: {
                    is_open: false
                }
            }
        }
    },
    mounted(){

    },
    components: {
        Link
    },
    methods: {
        dropdownControl: function (type, is_open) {
            this.dropdowns.one.is_open = false;
            this.dropdowns.two.is_open = false;
            this.dropdowns[type].is_open = !is_open
        }
    }
}).mount('#app')
