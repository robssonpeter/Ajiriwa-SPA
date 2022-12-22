<template>
    <div class="border py-2 px-2 pt-4 mt-2">
        <section class="flex">
            <input type="text" v-model="data.name" title="Subject of your question preferably in one word e.g Age" placeholder="Subject of your question preferably in one word e.g Age" @change="update" class="focus:border-green-400 focus:ring focus:ring-green-200 focus:border-r my-2 flex-grow border-r-0" required>
            <!--<span v-if="question.length">Question</span>-->
            <input type="text" v-model="question" placeholder="Write your question here" @change="update" class="focus:border-green-400 focus:ring focus:ring-green-200 my-2 flex-grow" required>
        </section>
        <div class="d-flex flex-row">
            <p>Question Type
            <span>
                <select name="" id="" v-model="question_type" class="focus:border-green-400 focus:ring focus:ring-green-200" @change="questionTypeControl" required>
                    <option value="">Select</option>
                    <option value="select">Choice Question</option>
                    <option value="open">Open Question</option>
                    <option value="date">Date</option>
                </select>
            </span>
            </p>
            <p class="ml-3" v-if="question_type == 'open'">Answer Type
            <span>
                <select name="" id="" class="focus:border-green-400 focus:ring focus:ring-green-200" v-model="input" @change="update" required>
                    <option value="">Select</option>
                    <option value="number">Number</option>
                    <option value="text">Text</option>
                    <option value="text-rich">Rich Text</option>
                </select>
            </span>
            </p>
        </div>
        <div v-if="question_type == 'select'">
            <span><strong>Choices</strong></span>
            <div class="d-flex flex-row my-1" v-for="(choice, index) in options">
                <input type="text" class="focus:border-green-400 focus:ring focus:ring-green-200" :placeholder="'Choice '+Number(index+1)" @change="update" v-model="options[index]" required>
                <span class="align-self-center text-danger ml-2" v-if="index > 1"><a href="#remove" @click.prevent="options.splice(index, 1)" class="text-red-500"><i class="bx bx-trash"></i></a></span>
            </div>
            <div class="py-2">
                <a href="##" class="my-2 text-green-500 font-bold" @click.prevent="options.push('')">Add another choice</a>
            </div>
        </div>
        <section class="d-flex flex-row py-2">
            <p v-if="input == 'number' || question_type == 'select' || question_type == 'date'" class="align-self-center">Ideal Answer</p>
            <div class="d-flex flex-row px-2 align-self-center">
                <input :ref="'answer-'+index" v-if="input == 'number'" @change="update" type="number" class="pl-1 focus:border-green-400 focus:ring focus:ring-green-200" v-model="answer" v-bind:id="'answer-'+index" required>
                <select :ref="'answer-'+index" v-model="answer" @change="update" class="focus:border-green-400 focus:ring focus:ring-green-200" v-else-if="question_type == 'select'" required>
                    <option :value="option" v-for="option in options">{{ option.length?option:'Undefined Option' }}</option>
                </select>
                <input :ref="'answer-'+index" type="date" v-else-if="question_type == 'date'" @change="update" v-model="answer" class="flex-fill focus:border-green-400 focus:ring focus:ring-green-200">
            </div>
        </section>

        <hr>
        <section class="flex py-2">
            <span class="col-11 flex-grow"><strong>Qualification Type: </strong><label class="ml-3">
            <input type="radio" v-bind:id="'required-'+index" :name="'qualification-'+index" @change="update" class="mr-3" value="required" :checked="necessity == 'required'?true:false"> Required</label>
            <label class="ml-3 flex-grow"><input type="radio" v-bind:id="'preferred-'+index" :checked="necessity == 'preferred'?true:false" :name="'qualification-'+index" @change="update" class="mr-3" value="preferred"> Preferred</label></span>
            <box-icon type='solid' color="gray" class="text-gray-600 font-weight-bold" name='trash' @click="remove(data.index)"></box-icon>
        </section>
    </div>
</template>
<script>
    export default {
        name: 'Custom',
        components: [],
        mounted(){

        },
        props: {
            data: {
                type: Object
            },
            index: {
                type: Number
            },
            name: {
                type: String
            },
            /* answer: {

            } */
        },
        mounted: function(){
            this.question = this.data.question;
            let open = ['text', 'number', 'text-rich'];
            if(open.find(element => element === this.data.input)){
                this.question_type = 'open';
            }else if(this.data.input_type === 'date'){
                this.question_type = 'date';
            }
            if(this.data.input_type){
                this.input = this.data.input_type;
            }else{
                this.input = this.data.input;
            }
            
            this.answer = this.data.answer;
            this.necessity = this.data.necessity;
            //this.name = this.data.name;
        },
        methods: {
            remove: function(){
                this.$emit('removed', this.index);
            },
            update: function(){
                let index = this.index;
                /*const name = document.getElementById('name-'+index);*/
                /*vue.questions[index].name = name.value;*/
                /*const answer = document.getElementById('answer-'+this.index);*/
                const preferred = document.getElementById('preferred-'+this.index);
                const required = document.getElementById('required-'+this.index);
                let necessity = "";
                if(preferred.checked){
                    necessity = "preferred";
                }else if(required.checked){
                    necessity = "required";
                }
                //vue.questions[this.index] = this.question;
                this.data.question = this.question;
                this.data.answer = this.answer;
                let answered = this.$refs['answer-'+this.index];
            
                if(answered){
                    this.data.answer = this.$refs['answer-'+this.index].value;
                }
                //console.log(this.index);
                this.data.answer_type = this.answer_type;
                this.data.input = this.input;
                this.data.options = this.options;
                //this.data.name = this.name;
                this.data.necessity = necessity;
            },
            questionTypeControl: function(){
                if(this.question_type === "select"){
                    this.options = ['', ''];
                }else{
                    if(this.question_type === "date"){
                        this.input = 'date';
                    }
                    this.options = null;
                }
            }
        },
        data(){
            return {
                questions_types: {

                },
                question: "",
                question_type: "",
                answer_type: "custom",
                type: "custom",
                necessity: "preferred",
                options: null,
                input: "",
                answer: "",
            }
        }
    }
</script>