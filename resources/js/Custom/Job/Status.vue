    <template>
    <dropdown align="right" width="48" class="hidden md:block float-right">
        <template #trigger>
            <span class="inline-flex rounded-md">
                <button type="button" :disabled="changing" :class="status_color">
                    <section v-if="!changing" class="flex flex-row">
                        {{ status_label }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </section>
                    <Loader v-else :color="current_color" css_class="p-1"></Loader>
                </button>
            </span>
        </template>

        <template #content>
            <dropdown-link as="button" v-for="(status, index) in options" @click="changed(status, index)">
                {{ status }}
            </dropdown-link>
        </template>
    </dropdown>
</template>

<script>
import Dropdown from "@/Jetstream/Dropdown";
import DropdownLink from "@/Jetstream/DropdownLink";
import Loader from "@/Custom/Loader";
import Swal from "sweetalert2";
export default {
    name: "Status",
    props: {
        job: {
            type: Object,
            required: true,
        },
        options: {
            type: Array,
            required: true,
        }
    },
    components: {
        Dropdown, DropdownLink, Loader
    },
    mounted() {
        this.status_code = this.job.status;
        this.status_label = this.job.current_status;
        console.log(this.status_code)

    },
    computed: {
        status_color(){
            /*let classList = this.status_classes.Draft??'';
            return ''*/
            return this.status_classes[this.status_label];
        },
        current_color(){
            return this.status_colors[this.status_label];
        }
    },
    data(){
        return {
            changing: false,
            status_label: '',
            status_code: '',
            status_classes: {
                Active: 'border border-green-500 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-500 hover:text-gray-700 focus:outline-none transition',
                Paused: 'border border-blue-500 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-500 hover:text-gray-700 focus:outline-none transition',
                Closed: 'border border-red-500 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-500 hover:text-gray-700 focus:outline-none transition',
                Draft: 'border border-gray-500 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-gray-700 focus:outline-none transition',
            },
            status_colors: {
                Active: 'green',
                Paused: 'blue',
                Closed: 'red',
                Draft: 'gray'
            }
        }
    },
    methods: {
        changed(status, index){
            this.changing = true;
            //return alert(status);
            //this.status_label = status;
            axios.post(route('job.status.change'), { job_id: this.job.id, status: index }).then((response) => {
                if(response.data){
                    this.status_label = status;
                }
                this.changing = false;
                this.$emit('change', {status:status, id: this.job.id});
            }).catch((error) => {
                if(error.response.data.message){
                    Swal.fire('Failed', error.response.data.message, 'error');
                }else{
                    Swal.fire('Failed', 'Status could not be updated', 'error');
                }
                console.log(error.response.data);
                this.changing = false;
            })

        },
        changeStatus(){
            alert('changing status');
        }
    }
}
</script>

<style scoped>

</style>
