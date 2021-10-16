<template>
    <div>
        <span class="font-bold">Cover letter</span>
        <text-editor @change="coverLetterChanged"></text-editor>
    </div>
</template>

<script>
    import TextEditor from "@/Custom/TextEditor";
    export default {
        name: "Apply",
        components: {TextEditor},
        props: {
            job: {
                type: Object
            }
        },
        component: {
            TextEditor
        },
        /*mounted(){
          console.log(this.$page.props);
        },*/
        data(){
            return {
                coverRequired: this.job.cover_letter,
                cover_letter: '',
                job_id: this.job.id,
                candidate_id: this.$page.props.user.candidate.id,
                typed: ''
            }
        },
        methods:{
            coverLetterChanged(html){
                //console.log(html);
                this.cover_letter = html;
            },
            sendApplication(){
                this.$emit('applying', true);
                //alert('applying');
                axios.post(route('application.send'), this.$data).then((response) => {
                    if(response.data){
                        // applied emit applied event
                        this.$emit('applied', this.job.id);
                    }
                }).catch((error) => {
                    console.log(error.response.data);
                })
            }
        }
    }
</script>

<style scoped>

</style>
