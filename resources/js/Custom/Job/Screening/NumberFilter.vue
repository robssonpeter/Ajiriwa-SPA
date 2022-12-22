<template>
    <section class="pb-2 flex flex-col">
        <span class="text-gray-500" v-if="data.variable_name == 'Experience' || data.variable_name=='Expertise'"><strong>Experience in {{ data.name }} (Years)</strong></span>
        <span class="text-gray-500" v-else><strong>{{ data.name }}</strong></span>
        <div class="flex flex-row w-full">
            <div class="input-group-prepend">
                <select class="border-t border-l border-b border-gray-400 py-1 rounded-l-md text-gray-500" v-model="data.operator_value" @change='update'>
                    <option :value="option.sign" v-for="option in operators">{{ option.name }}</option>
                </select>
            </div>
            <input type="number" step="any" v-model="data.filter_value" @change='update' class="border rounded-r-md border-gray-400 py-1 text-gray-500 flex-grow" aria-label="Text input with dropdown button">
        </div>
    </section>
</template>
<script>
export default {
    name: "NumberFilter",
    props: {
        data: {
            type: Object
        },
        index: {
            type: Number
        }
    },
    methods: {
        update: function(){
            //this.data.filter_operator = this.operatorSign;
            /* vue.assessments[this.index].filter_operator = this.operatorSign;
            vue.assessments[this.index].filter_value = this.value; */
            //this.data.filter_value = this.value;
            console.log('data from number filter');
            console.log(this.data);
            this.$emit('changed', {data: this.data, index: this.index});
        }
    },
    mounted(){
        if(!this.data.operator_value){
            this.data.operator_value = ">";
        }
        console.log('number filter loaded');
        console.log(this.data)
    },
    data: function(){
        return {
            operators: [
                {name: 'Greater than', sign: '>'},
                {name: 'Less than', sign: '<'},
                {name: 'Equals to', sign: '='},
            ],
            operatorSign: this.data.operator_value??'>',
            value: this.data.operator_value??''
        }
    },
}
</script>
<style>

</style>