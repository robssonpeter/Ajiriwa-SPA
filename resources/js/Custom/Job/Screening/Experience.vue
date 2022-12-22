<template>
    <div class="border py-2 px-2 pt-4 mt-2">
        <p class="d-flex">
            <span class="align-self-center">How many years of </span>
            <span class="px-2 col-3">
            <input placeholder="e.g Accounting" type = 'text' v-model="name" class="pl-2 flex-fill focus:border-green-400 focus:ring focus:ring-green-200" v-bind:id="'name-'+index"  @change="update" required></span>
            <span class="align-self-center">experience do you currently have?</span>
        </p>
        <p class="flex py-2">
            <span class="self-center mr-2">Ideal Answer </span>
            <span class="col-2 self-center"><input type="number" class="text-center focus:border-green-400 focus:ring focus:ring-green-200" v-model="answer" v-bind:id="'answer-'+index" @change="update" required></span>
            <span class="self-center ml-2">years minimum</span>
        </p>
        <hr>
        <section class="flex py-2">
        <span class="col-11 flex-grow"><strong>Qualification Type: </strong><label class="ml-3"><input type="radio" v-bind:id="'required-'+index" :name="'qualification-'+index" @change="update" class="mr-3" value="required" :checked="necessity == 'required'?true:false"> Required</label> 
            <label class="ml-3 flex-grow"><input type="radio" v-bind:id="'preferred-'+index" :name="'qualification-'+index" @change="update" :checked="necessity == 'preferred'?true:false" class="mr-3" value="preferred"> Preferred</label></span>
    
            <box-icon type='solid' color="gray" class="text-gray-600 font-weight-bold" name='trash' @click="remove(data.index)"></box-icon>
        </section>
    </div>
</template>
<script>
    export default {
        name: 'Experience',
        components: [],
        props: {
                data: {
                    type: Object
                },
                index: {
                    type: Number
                }/* ,
                name: {
                    type: String
                },
                answer: {

                } */
            },
            mounted: function(){
                const preferred = document.getElementById('preferred-'+this.index);
                const required = document.getElementById('required-'+this.index);
                if(this.data.necessity === 'required'){
                    required.checked = true
                }else if(this.data.necessity === 'preferred'){
                    preferred.checked = true
                }
                console.log(this.answer);
            },
            methods: {
                remove: function(){
                    this.$emit('removed', this.index);
                },
                changed: function(){
                    //this.$emit('change', this.data);
                    console.log('something has changed')
                    console.log(this.data)
                },
                update: function(){
                    let index = this.index;
                    const name = document.getElementById('name-'+index);
                    //vue.questions[index].name = this.data.name;
                    const answer = document.getElementById('answer-'+this.index);
                    const preferred = document.getElementById('preferred-'+this.index);
                    const required = document.getElementById('required-'+this.index);
                    let necessity = "";
                    if(preferred.checked){
                        necessity = "preferred";
                    }else if(required.checked){
                        necessity = "required";
                    }
                    this.data.name = this.name;
                    this.data.question = 'How many years of '+this.data.name+" experience do you currently have?";
                    this.data.answer = this.answer;
                    this.data.necessity = necessity;
                    console.log(this.data)
                    //this.changed();
                }
            },
            data(){
                return {
                    name: this.data.name,
                    answer: this.data.answer,
                    question: 'How many years of '+this.data.name+" experience do you currently have?",
                    answer_type: "minimum",
                    type: "experience",
                    necessity: "preferred",
                    options: null,
                    input: "number"
                }
            }
    }
    
</script>