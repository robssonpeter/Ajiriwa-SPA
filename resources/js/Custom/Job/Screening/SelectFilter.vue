<template>
    <div class="pb-2 w-full flex space-x-2">
        <span class="text-gray-500 self-center" v-if="data.variable_name == 'Education'"><strong>Has completed {{ data.name }}</strong></span>
        <span class="text-gray-500 self-center" v-else-if="data.variable_name == 'Location'"><strong>Can commute to {{ data.name }} for work</strong></span>
        <span class="text-gray-500 self-center" v-else-if="data.type == 'custom'"><strong>{{ data.name }}</strong></span>
        <span class="text-gray-500 self-center" v-else-if="data.variable_name == 'Authorization'"><strong>Can work in {{ data.name }}</strong></span>
        <span class="text-gray-500 self-center" v-else-if="data.variable_name == 'Certification'"><strong>Has {{ data.name }}</strong></span>
        <select class="border border-gray-400 py-1 rounded-md text-gray-500 ml-2 self-center" v-model="data.filter_value">
            <option :value="option" v-for="option in data.options_decoded">{{ option }}</option>
        </select>
    </div>
</template>
<script>
export default {
    name: "SelectFilter",
    props: ['data','index'],
    mounted: function(){
        this.update();
        this.data.filter_operator = '=';
        if(!this.data.filter_value){
            this.data.filter_value = "Yes";
        }
    },
    methods: {
        update: function(){
            //this.data.filter_operator = this.operatorSign;
            //this.data.filter_value = this.value;
            /*this.$emit('change', this.value);*/
        }
    },
    data: function(){
        return {
            operatorSign: '=',
            value: JSON.parse(this.data.options)[0]
        }
    }
}
</script>
<style>

</style>