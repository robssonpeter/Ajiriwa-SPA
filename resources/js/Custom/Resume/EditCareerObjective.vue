<template>
    <div class="gap-y-4">
        <div class="content" id="personalContent" style="display: block;">
            <section class="">
                <div class="input flex flex-col">
                    <label for="firstName" class="input-placeholder">Career Objectives</label>
                    <quill-editor class="w-100" @textChange="changes" theme="snow" content-type="html"  :content="personal.career_objective" v-model:content="personal.career_objective"></quill-editor>
                </div>
            </section>
            <section class="md:grid md:grid-cols-3 gap-4 gap">

                <div class="input flex flex-col">
                    <span class="invisible">save</span>
                    <button v-if="changed" :disabled="saving" class="bg-green-500 p-2 text-white items-center" @click="savePersonal" id="personalSave">
                        <Loader color="white" class="justify-center" v-if="saving"></Loader>
                        <span v-else>Save</span>
                    </button>
                    <Link :href="route('my-resume.edit.sectional', 'experience')" v-if="!changed" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-md">
                        <span class="flex flex-row gap-1 place-self-center justify-center">
                            Go to Experience
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 self-center" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                            </span>
                    </Link>
                </div>
            </section>

            <Modal :show="false">hello</Modal>
        </div>
    </div>

</template>

<script>
import Modal from "@/Jetstream/Modal";
import {Head, Link} from '@inertiajs/inertia-vue3';
import Loader from "@/Custom/Loader";
import {QuillEditor} from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
        name: "EditPersonal",
        components: {
            Modal, Head, Link, Loader, QuillEditor
        },
        mounted(){
            console.log(this.old.first_name);
        },
        data(){
            return {
                personal: this.$page.props.data.personal,
                old: this.$page.props.data.old,
                changed: false,
                saving: false
            }
        },
        methods: {
            savePersonal(){
                //alert('saving personal information')
                this.saving = true;
                axios.post(route('save.candidate.data', 'personal'), {data: this.personal}).then((response) => {
                    console.log(response.data);
                    this.saving = false;
                    this.changed = false;
                }).catch((error) => {
                    console.log(error.response.data);
                })
            },
            changes(){
                let old = this.old.career_objective;
                let newOne = this.personal.career_objective;
                this.changed = old !== newOne;
                console.log(this.changed);
            }
        }
    }
</script>

<style scoped>
    input:focus {
        border: none white;
    }

    select:focus {
        border: 0px none white;
    }

</style>
