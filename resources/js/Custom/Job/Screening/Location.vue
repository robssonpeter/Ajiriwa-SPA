<template>
    <div class="border py-2 px-2 pt-4 mt-2">
        <p class="d-flex">
            <span class="align-self-center">Are you comfortable commuting to this job location?</span>
            <span class="col-3 px-2"><input type='text' @change="update" v-model="name" name="education[]"
                    class="pl-2 focus:border-green-400 focus:ring focus:ring-green-200" placeholder="Location" required></span>
        </p>
        <div class="d-flex py-2">
            <span class="align-self-center mr-4">Ideal Answer</span>
            <select type="number" v-model="answer" @change="update" class="col-2 pl-3 border border-gray-500 focus:border-green-400 focus:ring focus:ring-green-200" required>
                <option :value="option" v-for="option in options">{{ option }}</option>
            </select>
        </div>

        <hr>
        <section class="flex py-2">
            <span class="col-11 flex-grow"><strong>Qualification Type: </strong><input type="radio" v-bind:id="'required-' + index"
                    :name="'qualification-' + index" @change="update" class="mr-3" value="required"> Required
                <label class="ml-3 flex-grow"><input type="radio" v-bind:id="'preferred-' + index" :name="'qualification-' + index"
                        @change="update" class="mr-3" value="preferred"> Preferred</label></span>
                <box-icon type='solid' color="gray" class="text-gray-600 font-weight-bold" name='trash' @click="remove(data.index)"></box-icon>
        </section>
    </div>
</template>
<script>
import 'boxicons'
export default {
    name: 'Location',
    components: {},
    props: {
        data: {
            type: Object
        },
        index: {
            type: Number
        },
    },
    mounted: function () {
        const preferred = document.getElementById('preferred-' + this.index);
        const required = document.getElementById('required-' + this.index);
        if (this.data.necessity === 'required') {
            required.checked = true
        } else if (this.data.necessity === 'preferred') {
            preferred.checked = true
        }
        console.log('location component loaded here');
    },
    methods: {
        remove: function(){
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
            this.data.question = 'Are you comfortable commuting to ' + this.name + ' for work?';
            this.data.name = this.name;
            this.data.answer = this.answer;
            this.data.necessity = necessity;
            console.log(this.data);
        }
    },
    data(){
        return {
            name: this.data.name,
            question: 'Are you comfortable commuting to  ' + this.data.name + ' for work?',
            answer: "Yes",
            answer_type: "ideal",
            type: "location",
            necessity: "required",
            options: [
                "Yes", "No"
            ],
            input: "select"
        }
    }
}
</script>