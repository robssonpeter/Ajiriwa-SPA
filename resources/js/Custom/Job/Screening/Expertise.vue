<template>
    <div class="border py-2 px-2 pt-4 mt-2">

        <p class="d-flex">
            <span class="align-self-center">How many years of experience do you have using </span>
            <span class="pl-2"><input type='text' v-model="name" @change="update" class="pl-2 focus:border-green-400 focus:ring focus:ring-green-200"
                    placeholder="Tool or Technology" required></span>
        </p>
        <p class="flex py-2">
            <span class="self-center mr-2">Ideal Answer </span>
            <span class="px-2 col-2 self-center"><input type="number" class="focus:border-green-400 focus:ring focus:ring-green-200"
                    v-model="answer" @change="update" required></span>
            <span class="px-2 self-center">years minimum</span>
        </p>
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
    name: "Expertise",
    components: [],
    props: ['data', 'index'],
    mounted: function () {
        const preferred = document.getElementById('preferred-' + this.index);
        const required = document.getElementById('required-' + this.index);
        if (this.data.necessity === 'required') {
            required.checked = true
        } else if (this.data.necessity === 'preferred') {
            preferred.checked = true
        }
    },
    methods: {
        remove: function () {
            this.$emit('removed', this.index);
        },
        update: function () {
            let index = this.index;
            const name = document.getElementById('name-' + index);
            const answer = document.getElementById('answer-' + this.index);
            const preferred = document.getElementById('preferred-' + this.index);
            const required = document.getElementById('required-' + this.index);
            let necessity = "";

            if (preferred.checked) {
                necessity = "preferred";
            } else if (required.checked) {
                necessity = "required";
            }

            this.data.name = this.name;
            this.data.question = "How many years of experience do you have using " + this.name+"?";
            this.data.answer = this.answer;
            this.data.necessity = necessity;
        }
    },
    data: function () {
        return {
            name: this.data.name,
            answer: this.data.answer,
            question: "How many years of experience do you have using " + this.data.name,
            answer_type: "minimum",
            type: "expertise",
            necessity: "required",
            options: null,
            input: 'number'
        }
    }
}

</script>