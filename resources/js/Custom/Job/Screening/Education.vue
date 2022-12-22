<template>
    <div class="border py-2 px-2 pt-4 mt-2">
        <section class="flex py-2">
            <p class="mr-2 self-center">Have you completed the following level of education? </p>
        
            <input placeholder="e.g Bachelor of Accounting"
                    type='text' @change="update" :ref="'education-'+index" v-model="name" name="education[]"
                    class="pl-2 focus:border-green-400 focus:ring focus:ring-green-200" required>
        </section>
        <section class="flex py-2">
            <p class="self-center mr-2">Ideal Answer</p> 
            <select name="edu_answer" @change="update" class="col-2 pl-3 focus:border-green-400 focus:ring focus:ring-green-200"
                v-model="answer" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </section>
    
        <hr>
        <section class="flex py-2">
            <span class="col-11 flex-grow"><strong>Qualification Type: </strong><label class="ml-3"><input type="radio"
                        v-bind:id="'required-' + index" :ref="'required-' + index" :name="'qualification-' + index" @change="update" class="mr-3"
                        value="required"> Required</label> <label class="ml-3"><input type="radio"
                        v-bind:id="'preferred-' + index" :ref="'preferred-' + index" :name="'qualification-' + index" @change="update" class="mr-3"
                        value="preferred"> Preferred</label></span>
            <box-icon type='solid' color="gray" class="text-gray-600 font-weight-bold" name='trash' @click="remove(data.index)"></box-icon>
        </section>
    </div>
</template>
<script>
export default {
    name: 'Education',
    props: {
        data: {
            type: Object
        },
        index: {
            type: Number
        },
        /* name: {
            type: String
        },
        answer: {

        } */
    },
    mounted: function () {
        const preferred = document.getElementById('preferred-' + this.index);
        const required = document.getElementById('required-' + this.index);
        if (this.data.necessity === 'required') {
            required.checked = true
        } else if (this.data.necessity === 'preferred') {
            preferred.checked = true
        }
        console.log('the education component has loaded')
        console.log(this.data);
        //this.name = this.data.name;
    
        /*console.log(this.data);
        this.update();*/
    },
    methods: {
        remove: function () {
            this.$emit('removed', this.index);
        },
        update: function () {
            let index = this.index;
            const name = document.getElementById('name-' + this.index);
            const answer = document.getElementById('answer-' + this.index);
            const preferred = document.getElementById('preferred-' + this.index);
            const required = document.getElementById('required-' + this.index);
            let necessity = "";

            if (preferred.checked) {
                //alert('preferred chosen');
                necessity = "preferred";
            } else if (required.checked) {
                //alert('required is checked');
                necessity = "required";
            }
            //alert(necessity);
            this.data.question = 'Have you completed ' + this.name + ' level of education?';
            this.data.name = this.name;
            this.data.answer = this.answer;
            this.data.necessity = necessity;
            //console.log(this.data);
        }
    },
    data: function () {
        return {
            name: this.data.name,
            question: 'Have you completed ' + this.data.name + ' level of education?',
            answer: "Yes",
            answer_type: "ideal",
            type: "education",
            necessity: "required",
            options: [
                "Yes", "No"
            ],
            input: "select"
        }
    }
}
</script>