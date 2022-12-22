<template>
    <div class="container pt-4 text-gray-700">
        <label for="" class="mr-2">{{ question.question }} <span class="text-danger" v-if="question.necessity == 'required'">*</span></label>
        <select class="py-1 border border-gray-300" @change="update" v-model="applicant_answer" v-if="question.options" :required="question.necessity == 'required'?true:false">
            <option value="">Select</option>
            <option v-for="option in question.options_decoded">{{ option }}</option>
        </select>
        <input autocomplete="off" class="py-1 border border-gray-300" type="text" @change="update" v-model="applicant_answer" v-else-if="question.input_type == 'text'" :required="question.necessity == 'required'?true:false">
        <input autocomplete="off" class="py-1 border border-gray-300 w-50" type="number" @change="update" v-model="applicant_answer" step="any" v-else-if="question.input_type == 'number'" :required="question.necessity == 'required'?true:false">
        <input autocomplete="off" class="py-1 border border-gray-300" type="date" @change="update" v-model="applicant_answer" v-else-if="question.input_type == 'date'" :required="question.necessity == 'required'?true:false">
        <textarea class="py-1 border-gray-500" @change="update" v-model="applicant_answer" v-else-if="question.input_type == 'text-long'" :required="question.necessity == 'required'?true:false"></textarea>
    </div>
</template>

<script>

export default {
    components: {
        
    },
    name: "AssessmentRender",
    props: {
        index: {
            type: Number,
            required: false
        },  
        question: {
            type: Object,
            required: true
        }
    },
    computed: {
        
    },
    data(){
        return {
            applicant_answer: '',
            question_id: '',
        }
    },  
    methods: {
        update(){
            //this.question.applicant_answer = this.applicant_answer
            this.$emit('changed', {answer: this.applicant_answer, question_id: this.question.id});
        }
    }
}
</script>

<style scoped>

</style>
