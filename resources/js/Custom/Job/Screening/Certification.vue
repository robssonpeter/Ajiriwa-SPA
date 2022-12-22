<template>
    <div class="border py-2 px-2 pt-4 mt-2">

        <p class="d-flex">
            <span class="align-self-center">Do you have the following licence or certification? </span>
            <span class="col-4"><input type='text' @change="update" v-model="name" class="focus:border-green-400 focus:ring focus:ring-green-200"
                    required></span>
        </p>
        <p class="d-flex py-2">
            <span class="align-self-center">Ideal Answer </span>
            <span class="col-2">
                <select @change="update" class="pl-3 focus:border-green-400 focus:ring focus:ring-green-200" v-model="answer" required>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </span>
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
export default {
    name: 'Location',
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
            //alert(necessity);
            this.data.name = this.name;
            this.data.answer = this.answer;
            this.data.necessity = necessity;
            this.data.question = "Do you have the licence or certification on " + this.data.name + "?";
        }
    },
    data() {
        return {
            name: this.data.name,
            answer: "Yes",
            question: "Do you have the licence or certification on " + this.data.name + "?",
            answer_type: "ideal",
            type: "certification",
            necessity: "required",
            options: [
                "Yes", "No"
            ],
            input: "select"
        }
    }
}
</script>