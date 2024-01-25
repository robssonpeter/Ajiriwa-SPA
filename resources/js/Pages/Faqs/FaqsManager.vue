<template>
    <employer-layout title="Manage Faqs">
        <div class="mt-4 ">
            <section class="flex px-4">
                <h2 class="text-2xl font-bold mb-4 flex-grow">FAQs Manager</h2>
                <button @click="toggleAddNewForm" class="self-start text-white bg-green-500 cursor-pointer p-1 rounded-md">
                    Add New
                </button>
            </section>
            <div>
                <div class="px-4">
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-200 border-b text-left">Question</th>
                                <th class="py-2 px-4 bg-gray-200 border-b text-left">Answer</th>
                                <th class="py-2 px-4 bg-gray-200 border-b text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(faq, index) in paginatedFaqs" :key="index">
                                <td class="py-2 px-4 border-b">{{ faq.question }}</td>
                                <td class="py-2 px-4 border-b">{{ truncatedAnswer(faq.answer) }}</td>
                                <td class="py-2 px-4 border-b">
                                    <button @click="editFaq(index)" class="text-blue-500 underline cursor-pointer">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4 flex justify-end">
                    <button v-if="currentPage > 1" @click="changePage(currentPage - 1)"
                        class="py-2 px-4 bg-gray-300 rounded-md mr-2">
                        Previous
                    </button>
                    <button v-if="currentPage < totalPages" @click="changePage(currentPage + 1)"
                        class="py-2 px-4 bg-gray-300 rounded-md">
                        Next
                    </button>
                </div>
            </div>

            <!-- Edit FAQ Modal -->
            <div v-if="showEditModal"
                class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center">
                <div class="bg-white p-6 rounded shadow-md w-1/2 max-h-full overflow-y-auto">
                    <h3 class="text-2xl font-bold mb-4">Edit FAQ</h3>
                    <form @submit.prevent="saveEditedFaq">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="editQuestion">
                                Question
                            </label>
                            <input v-model="editedFaq.question" type="text" id="editQuestion" name="editQuestion"
                                class="w-full border border-gray-300 rounded-md p-2">
                        </div>
                        <div class="mb-4 flex flex-col">
                            <label for="editCategory">Category:</label>
                            <select v-model="editedFaq.category_id" id="editCategory"
                                class="mb-4 w-full border border-gray-300 rounded-md p-2">
                                <option value="">Select</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{
                                    category.name }}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="editAnswer">
                                Answer
                            </label>
                            <text-editor v-model="editedFaq.answer" :text="editedFaq.answer" @change="onEditorChange" />
                            <!-- <textarea v-model="editedFaq.answer" id="editAnswer" name="editAnswer"
                                class="w-full border border-gray-300 rounded-md p-2"></textarea> -->
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="cancelEdit"
                                class="mr-2 px-4 py-2 bg-gray-500 text-white rounded-md">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add New FAQ Form (Inside Modal) -->
            <div>
                <div v-if="showAddNewForm"
                    class="fixed top-0 left-0 w-full h-full bg-gray-800 bg-opacity-50 flex items-center justify-center">
                    <div class="bg-white p-4 rounded-md w-1/2 max-h-full overflow-y-auto">
                        <div class="flex">
                            <h3 class="text-2xl font-bold mb-4 flex-grow">Add New FAQ</h3>
                            <button @click="toggleAddNewForm"
                                class="text-gray-500 text-xl self-start py-0 cursor-pointer">&times;</button>
                        </div>
                        <!-- Add New FAQ Form -->
                        <form @submit.prevent="addNewFaq">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="newQuestion">
                                    Question
                                </label>
                                <input v-model="newFaq.question" type="text" id="newQuestion" name="newQuestion"
                                    class="w-full border border-gray-300 rounded-md p-2">
                            </div>
                            <div class="mb-4">
                                <label for="addCategory">Category:</label>
                                <select v-model="newFaq.category_id" id="addCategory"
                                    class="mb-4 w-full border border-gray-300 rounded-md p-2">
                                    <option value="">Select</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{
                                        category.name }}</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="newAnswer">
                                    Answer
                                </label>
                                <text-editor v-model="newFaq.answer" @change="onEditorChange" />
                                <!-- <textarea v-model="newFaq.answer" id="newAnswer" name="newAnswer"
                                    class="w-full border border-gray-300 rounded-md p-2"></textarea> -->
                            </div>
                            <button type="submit" class="py-2 px-4 bg-green-500 text-white rounded-md mt-4">
                                Add FAQ
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </employer-layout>
</template>
  
<script>
import EmployerLayout from "@/Layouts/EmployerLayout";
import axios from "axios";
import TextEditor from "../../Custom/TextEditor.vue";
export default {
    components: {
        EmployerLayout, TextEditor
    },
    data() {
        return {
            categories: this.$page.props.categories,
            faqs: this.$page.props.faqs.data,
            showEditModal: false,
            showAddNewForm: false,
            editedFaq: { question: '', answer: '', category_id: '' },
            newFaq: { question: '', answer: '', category_id: '' },
            itemsPerPage: 5, // Number of FAQs per page
            currentPage: 1,
        };
    },
    mounted() {

    },
    computed: {
        truncatedAnswer() {
            return (answer) => {
                // Set the maximum number of characters to show
                const maxLength = 150;

                // Strip HTML tags using a temporary element
                const tempElement = document.createElement("div");
                tempElement.innerHTML = answer;
                let strippedText = tempElement.innerText || "";

                // Truncate the text if it exceeds the maximum length
                if (strippedText.length > maxLength) {
                    strippedText = strippedText.substring(0, maxLength) + "...";
                }

                return strippedText;
            };
        },
        totalPages() {
            return Math.ceil(this.faqs.length / this.itemsPerPage);
        },
        paginatedFaqs() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.faqs.slice(start, end);
        },
    },
    methods: {

        onEditorChange(content) {
            // Handle editor content change
            // You can use this method to update the content in your data model
            // For example, you can use it in saveEditedFaq and addNewFaq methods
            if (this.editedFaq.id) {
                this.editedFaq.answer = content;
            } else {
                this.newFaq.answer = content;
            }
        },
        editFaq(index) {
            this.showEditModal = true;
            this.editedFaq = { ...this.faqs[index] };
        },
        saveEditedFaq() {
            // Save the edited FAQ logic goes here
            axios.put(route('faq.update', this.editedFaq.id), this.editedFaq).then((response) => {
                //this.faqs.push(response.data.faq);
                let index = this.faqs.findIndex(faq => faq.id === this.editedFaq.id);
                this.faqs[index] = this.editedFaq;
                this.showEditModal = false;
            }).catch((error) => {
                console.log(error.response.data);
            })
        },
        cancelEdit() {
            this.showEditModal = false;
        },
        addNewFaq() {
            // Add new FAQ logic goes here
            //this.faqs.push({ ...this.newFaq });
            axios.post(route('faq.store'), this.newFaq).then((response) => {
                this.faqs.push(response.data.faq);
            }).catch((error) => {
                console.log(error.response.data);
            })
            this.newFaq = { question: '', answer: '' };
        },
        changePage(page) {
            this.currentPage = page;
        },
        toggleAddNewForm() {
            this.showAddNewForm = !this.showAddNewForm;
        },
    },
};
</script>
  
<style scoped>
/* Add your custom styles here */
</style>
  