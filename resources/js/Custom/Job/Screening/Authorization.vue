<template>
    <div class="border py-2 px-2 pt-4 mt-2">
        <section class="flex">    
            <p class="self-center mr-2">Are you authorized to work in the country? </p>
            <input type="text" placeholder="Country Name" @change="update" v-model="name">
        </section>
        <p class="flex py-2">
            <span class="self-center mr-2">Ideal Answer </span>
            <span class="col-2">
                <select class="focus:border-green-400 focus:ring focus:ring-green-200 pl-3" v-model="answer" @change="update" required>
                    <option :value="option" v-for="option in options">{{ option }}</option>
                </select>
            </span>
        </p>
        <hr>
        <section class="flex py-2">
            <span class="col-11 flex-grow"><strong>Qualification Type: </strong><input type="radio" v-bind:id="'required-' + index"
                    :name="'qualification-' + index" @change="update" class="mr-3" value="required"> Required
                <label class="ml-3"><input type="radio" v-bind:id="'preferred-' + index" :name="'qualification-' + index"
                        @change="update" class="mr-3" value="preferred"> Preferred</label>
                    </span>
                    <box-icon type='solid' color="gray" class="text-gray-600 font-weight-bold" name='trash' @click="remove(data.index)"></box-icon>
        </section>
    </div>

</template>
<script>
export default {
    name: "Authorization",
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
        this.name = this.data.name;
    },
    methods: {
        remove: function () {
            //vue.remove(this.index);
            this.$emit('removed', this.index);
            //vue.added.authorization = false;
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
            this.data.question = "Are you authorized to work in "+this.name+"?";
        }

    },
    data: function () {
        return {
            name: this.data.name,
            answer: "Yes",
            question: "Are you authorized to work in "+this.name+"?",
            answer_type: "ideal",
            type: "authorization",
            necessity: "required",
            options: [
                "Yes", "No"
            ],
            input: "select"
        }
    }
}

</script>