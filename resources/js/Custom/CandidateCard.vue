<template>
    <section>
        <div class="bg-white border border-gray-100 rounded-lg shadow-lg p-6">
            <div class="flex items-center mb-4">
                <img class="w-12 h-12 rounded-full mr-4" :src="candidate.logo_url" :alt="candidate.full_name">
                <div>
                    <h3 class="text-xl font-semibold cursor-pointer" @click="candidate_modal = true; showCandidate(candidate)">{{ candidate.full_name }}</h3>
                    <p class="text-green-500" v-if="application">{{ application.title }}</p>
                    <small class="text-gray-500" v-if="application">{{ application.location }}</small>
                </div>
            </div>
            <div class="mt-4">
                <!-- <span>{{ candidate.skills.length }}</span> -->
                <span v-for="(skill, index) in candidate.skills" class="mt-2 bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2 mb-2">
                    {{ skill.name }}
                </span>
            </div>
            <span v-if="application" class="text-sm text-italic float-right text-gray-500 mb-2">{{ application.time_ago
            }}</span>
        </div>
        <!-- Profile Modal -->
        <dialog-modal :show="candidate_modal" closeable="true" :max-width="'4xl'">
            <template v-slot:title>
                <div class="flex flex-row">
                    <span class="flex-grow text-gray-500 font-bold">Candidate</span>
                    <button @click="candidate_modal = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
            <template v-slot:content>
                <section class="flex" v-if="loading">
                    <span class="flex-grow"></span>
                    <loader color="green"></loader>
                    <span class="flex-grow"></span>
                </section>
                <profile-embed v-if="candidate.id && !loading" :candidate="candidate"
                    :show_profile="show_profile"></profile-embed>
            </template>
            <template v-slot:footer>
                <a v-if="candidate.id && !loading" :href="route('cv.print', candidate.id)"
                    class="bg-red-500 text-white rounded-md p-1 mr-2">
                    <span class="text-sm">Export to PDF</span>
                </a>
            </template>
        </dialog-modal>
    </section>
</template>
<script>
import DialogModal from "@/Jetstream/DialogModal";
import Loader from "@/Custom/Loader";
import ProfileEmbed from "@/Custom/Resume/ProfileEmbed";
export default {
    name: "TextEditor",
    components: {
        DialogModal, Loader, ProfileEmbed
    },
    props: {
        candidate: {
            type: Object,
            required: true,
        },
        application: {
            type: Object
        },
    },
    mounted() {
        console.log("the content is below");
        console.log(this.candidate)
    },
    data() {
        return {
            show_profile: false,
            loading: false,
            candidate_modal: false,
        }
    },
    methods: {
        showCandidate(candidate) {
            this.loading = true;
            axios.post(route('candidate.get-info', candidate.id)).then(response => {
                console.log('candidate information below')
                console.log(response.data.candidate);
                this.loading = false;
                this.candidate = response.data.candidate;
                console.log(this.candidate)
            }).catch(error => {
                this.loading = false;
            })
        },
    }
}
</script>