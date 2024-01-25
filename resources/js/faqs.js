require('./bootstrap');
import { createApp, h } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

createApp({
    data(){
        return {
            searchTerm: '',
            results: [],
            selectedFaq: null/* {
                question: "hello how are you doing",
                answer: "I'm very much fine thank you",
            } */,
            viewedFaqs: JSON.parse(localStorage.getItem('viewedFaqs')) || [], // Load viewed FAQs from localStorage
        }
    },
    mounted(){
        //alert('things have loaded')
    },
    components: {
        Link
    },
    methods: {
        searchFaq(){
            if(!this.searchTerm.length){
                this.results = [];
                return;
            }
            axios.post(searchRoute, {q: this.searchTerm}).then(result => {
                console.log(result.data.results);
                this.results =  result.data.results;
                return result.data.results;
            }); 
        },
        autocompleteClicked(faq){
            this.results = [];
            this.openModal(faq);
        },
        openModal(faq) {
            this.selectedFaq = faq;
            if (!this.viewedFaqs.includes(faq.id)) {
                this.viewedFaqs.push(faq.id);
                this.registerView(faq.id);
                // Update localStorage with the latest viewed FAQs
                localStorage.setItem('viewedFaqs', JSON.stringify(this.viewedFaqs));
                // document.getElementById('faqModal').classList.remove('hidden');
            }
        },
        closeModal() {
            this.selectedFaq = null;
            //document.getElementById('faqModal').classList.add('hidden');
        },
        async registerView(faqId) {
            try {
                // Make a POST request to the register-view endpoint
                await axios.post(`/faq/register-view`, {faqId: faqId});
            } catch (error) {
                console.error('Error registering view:', error);
            }
        },
    },
}).mount('#faq-page')
