<template>
    <QuillEditor @textChange="changing" v-model:content="content" theme="snow" />
</template>

<script>
    import { QuillEditor } from '@vueup/vue-quill'
    import '@vueup/vue-quill/dist/vue-quill.snow.css';
    import { QuillDeltaToHtmlConverter } from 'quill-delta-to-html';
    export default {
        name: "TextEditor",
        components: {
            QuillEditor, QuillDeltaToHtmlConverter
        },
        data() {
          return {
              content: ''
          }
        },
        methods: {
            changing(){
                let converter = new QuillDeltaToHtmlConverter(this.content.ops, {});
                let html = converter.convert();
                this.$emit('change', html);
            }
        }
    }
</script>

<style scoped>

</style>
