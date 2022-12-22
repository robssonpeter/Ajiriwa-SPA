import {createApp} from "vue";
import TextEditor from "@/Custom/TextEditor";
import iziToast from "izitoast";
import 'izitoast/dist/css/iziToast.min.css'
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    DialogDescription,
    TransitionRoot,
    TransitionChild,
} from "@headlessui/vue";
import Loader from "@/Custom/Loader";

createApp({
    components: {
        Dialog, DialogPanel, DialogTitle, DialogDescription, TransitionRoot,
        TransitionChild, TextEditor, Loader
    },
    data(){
        return {
            application_means:{
                show_modal: false,
            },
            guest_application:{
                show_modal: false,
            },
            application:{
                name: '',
                email: '',
                cover_letter: '',
                attachments: []
            },
            applying: false,
            job: job,
        }
    },
    mounted(){
        console.log(this.job);
    },
    methods: {
        apply(){
            if(this.job.apply_method === 'url'){
                // redirect to application url
                window.open(
                    this.job.application_url,
                    '_blank' // <- This is what makes it open in a new window.
                );
            }else if(this.job.apply_method === 'email'){
                this.application_means.show_modal = true;
            }else{
                // you must be signed in to apply
                iziToast.warning({
                    title: "Sign in Required",
                    message: "you must be signed in to apply"
                })
                // create a session redirect variable
                axios.post(sessionUrl, {
                    name: "redirect",
                    value: window.location.href
                }).then((response) => {
                    console.log('the response is as below')
                    console.log(response.data)
                    if(response.data){
                        window.location.href = loginPage
                    }
                }).catch((error) => {
                    console.log("the eeror is righ below")
                    console.log(error.response.data)
                })

                /*iziToast.success({
                    title: 'done',
                    message: 'Application successfully sent'
                })*/
            }
        },
        closeApply(){
            this.application_means.show_modal = false;
        },
        loginToApply(){
            this.application_means.show_modal = false;
            window.location.href = loginPage;
        },
        editorChanged(text){
            this.application.cover_letter = text;
        },
        applyWithoutLogin(){
            this.application_means.show_modal = false;
            this.guest_application.show_modal = true;
        },
        sendApplication(){
            let form = document.getElementById('guest-application');
            this.applying = true;
            let formData = new FormData(form);

            axios
                .post(applyUrl, formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((res) => {
                    console.log(res);
                    if(res.data){
                        // clear the application details
                        this.application = {
                            name: '',
                            email: '',
                            cover_letter: '',
                            attachments: []
                        }
                        this.applying=false;
                        // close the application modal
                        this.guest_application.show_modal = false;

                        // show a message that the application was successfull
                        iziToast.success({
                            title: 'Done',
                            message: 'Application successfully sent'
                        })
                    }
                })
                .catch((err) => {
                    console.log(err);
                });
        }
    }
}).mount('#job-page')
