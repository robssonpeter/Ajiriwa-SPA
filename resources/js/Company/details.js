import Button from "@/Jetstream/Button";
import Swal from "sweetalert2";
import Loader from "@/Custom/Loader";
import 'vue-advanced-cropper/dist/style.css';
import {createApp} from "vue";

createApp({
    name: "Customize",
    components: {
        Button, Loader,
    },
    mounted() {
        console.log(this.company);
        /*let image = new Image();
        image.src = this.company.logo_url;*/
        /*for(let x = 0; x < 100; x++){
            setTimeout(() => {
                this.logo_upload_progress += 1
            }, 2000)
        }*/
        /*image.onload = () => {
            this.logo.height = image.height;
            this.logo.width = image.width;
        }*/
    },
    data(){
        return {
            new_description: 'Industry',
            current_section: 'about',
            company: company,
            logo_upload_progress: 0,
            logo_dimensions: {
                height: 208,
                width: 208,
                top: 0,
                left: 0,
            },
            current_logo: '',
            jobs: [],
            reviews: [],
            entering: {
                description: false,
            },
            saving: {
                description: false,
                logo: false
            },
            tour_steps: [
                {
                    target: '#add-logo',  // We're using document.querySelector() under the hood
                    header: {
                        title: 'Get Started',
                    },
                    content: `Click here to add your company logo!`,
                    params: {
                        placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                    }
                }
            ],
            steps: [
                {
                    target: '#v-step-0',  // We're using document.querySelector() under the hood
                    header: {
                        title: 'Get Started',
                    },
                    content: `Discover <strong>Vue Tour</strong>!`
                },
                {
                    target: '.v-step-1',
                    content: 'An awesome plugin made with Vue.js!'
                },
                {
                    target: '[data-v-step="2"]',
                    content: 'Try it, you\'ll love it!<br>You can put HTML in the steps and completely customize the DOM to suit your needs.',
                    params: {
                        placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
                    }
                }
            ]
        }
    },
    methods: {
        greet({ coordinates, canvas }){
            console.log('Coordinates was changed', coordinates, canvas);
            console.log("The canvas width is "+canvas.width);
            let imageWidth =
                //this.logo_dimensions.width = canvas.width;
                //this.logo_dimensions.height = canvas.height;
                this.logo_dimensions.left = coordinates.left;
            this.logo_dimensions.top = coordinates.top;
            console.log(coordinates.left);
        },
        uploadImage(event){
            let type = event.target.name;
            let file = event.target.files || event.dataTransfer.files;
            if(file.length){
                //this.company.logo_url =  URL.createObjectURL(event.target.files[0]);
                let formData = new FormData();
                formData.append('files', file[0]);
                formData.append('model', 'App\\Models\\Company');
                formData.append('collection', type);
                formData.append('model_id', this.company.id);
                this.saving.logo = true;
                axios.post(route('file.save'), formData, {
                    headers: {
                        'Content-type' : 'multipart/form-data'
                    },
                    onUploadProgress: function(progressEvent) {
                        this.logo_upload_progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                        console.log(this.logo_upload_progress)
                    }
                }).then((response) => {
                    console.log(response.data.link);
                    this.company.logo_url = response.data.link;
                    this.logo_upload_progress = 0;
                    this.saving.logo = false;
                }).catch(error => {
                    Swal.fire({
                        title: "Failed",
                        text: "The upload has failed",
                        icon: "error",
                    })
                    console.log(error.response.data)
                    this.saving.logo = false;
                })
            }
            return console.log(file);
        },
        saveDescription(){
            this.saving.description = true;
            axios.post(route('company.description.save'), { company_id: this.company.id, description: this.new_description }).then((response) => {
                if(response.data){
                    this.company.description = response.data;
                }
                this.entering.description = false;
                this.saving.description = false;
            }).catch(error => {
                Swal.fire({
                    title: "Failed",
                    text: "Description could not be saved due to an error",
                    icon: 'error'
                })
                console.error(error.response.data);
                this.saving.description = false;
            })
        },
        addCompanyDescription(){
            this.entering.description = true;
            this.old_description = this.$page.props.company.description;
        },
        cancelCompanyDescription(){
            if(this.new_description !== this.company.description){
                Swal.fire({
                    title: "Warning",
                    text: "You will lose the changes you have made! Cancel?",
                    icon: "warning",
                    confirmButtonText: 'Yes, Cancel',
                    cancelButtonText: "Keep writing",
                    showCancelButton: true
                }).then((result) => {
                    if(result.isConfirmed){
                        this.entering.description = false;
                        //this.description = this.$page.props.company.description;
                    }/*else if(result.isDismissed){
                          alert('you gonna keep writing')
                      }*/
                })

            }else{
                this.entering.description = false;
            }

        },
        getSectionDetails(section){
            this.current_section = section;

            if(section === 'about'){

            }else{
                // get information from database

            }
        }
    },
    computed: {
        logoPosition(){
            console.log(this.logoLeft+" "+this.logoTop);
            return this.logoLeft+" "+this.logoTop;
        },
        logoLeft(){
            return this.logo_dimensions.left ? '-'+this.logo_dimensions.left+"px":0;
        },
        logoTop(){
            return this.logo_dimensions.top ? this.logo_dimensions.top+"px":0;
        },
        logoHeight(){
            return this.logo_dimensions.height;
        },
        logoWidth(){
            return this.logo_dimensions.width;
        },
        currentLogo(){
            return this.current_logo.length?this.current_logo:this.company.logo_url;
        },
        sectionClass(){
            return section => section === this.current_section ? "text-gray-400 hover:text-green-400 cursor-pointer active border-b":"text-gray-400 hover:text-green-400 cursor-pointer";
        },
        canCustomize(){
            return false;
        },
        logoUploadProgress(){
            return ''
        }
    }
}).mount('#page');
