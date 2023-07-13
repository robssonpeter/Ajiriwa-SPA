<template>
    <div class="bg-gray-200 min-h-screen px-8">
      <app-layout title="Company Info">
        <div class="bg-gray-200 min-h-screen px-8">
  
          <section class="bg-white max-w-7xl mx-auto sm:px-6">
            <div class="bg-gray-200 h-32 w-100">
              <span title="Edit Cover Image" v-if="canCustomize"
                class="mt-2 ml-2 absolute p-1 rounded-md end-0 float-right bg-green-400 text-white"
                @click="$refs.cover_select.click()"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4 font-bold cursor-pointer"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" data-v-6d6ef73a=""></path>
                </svg>
              </span>
              <img v-if="company.cover" type="image" :src="company.cover_url" alt="">
            </div>
            <div class="h-32 w-32 bg-gray-100 -mt-16">
              <span
                title="Change Logo"
                v-if="canCustomize"
                class="ml-2 mt-2 p-1 rounded-md mr-1 absolute bg-green-400 text-white"
                id="add-logo"
                ref="el"
                @click="$refs.logo_select.click()"
              >
                <button v-if="!company.logo" class="">Add Logo</button>
                <svg
                  v-else
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-4 w-4 text-white font-bold cursor-pointer"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  stroke-width="2"
                >
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" data-v-6d6ef73a=""></path>
                </svg>
              </span>
              <img
                :src="currentLogo"
                class="object-contain"
                :style="{ 'height': 'auto', 'width': 'auto', 'object-fit': 'contain', 'object-position': logoPosition }"
                @click="$refs.cropper.showCropper()"
              />
            </div>
            <div class="w-32">
              <div
                :class="'bg-green-400 h-1'"
                :style="{ width: logo_upload_progress + '%' }"
              ></div>
            </div>
  
            <input
              type="file"
              class="hidden"
              id="cover"
              ref="cover_select"
              @change="startCropCover"
              name="cover"
              accept="image/*"
            />
            <input
              type="file"
              class="hidden"
              id="logo"
              ref="logo_select"
              @change="startCrop"
              name="logo"
              accept="image/*"
            />
            <dialog-modal :show="logo_crop_cover_modal" closeable="true" :max-height="md" :max-width="'5xl'">
                <template v-slot:title>
                    <div class="flex flex-row">
                        <span class="flex-grow text-gray-500 font-bold">Crop Cover</span>
                        <button @click="logo_crop_cover_modal = false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
                <template v-slot:content>
                    <cropper
                    ref="cropperCover"
                    @crop="saveCroppedCoverImage"
                    @change="logoChanged"
                    :src="coverSrc"
                    :stencil-props="cropperCoverOptions"
                    />
                </template>
                <template v-slot:footer>
                    <button class="bg-green-500 text-white p-2 hover:bg-green-400" @click="saveCroppedCoverImage()">Save Cover</button>
                </template>
            </dialog-modal>
            <dialog-modal :show="logo_crop_modal" closeable="true" :max-width="'md'">
                <template v-slot:title>
                    <div class="flex flex-row">
                        <span class="flex-grow text-gray-500 font-bold">Crop Logo</span>
                        <button @click="logo_crop_modal = false">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
                <template v-slot:content>
                    <cropper
                    ref="cropper"
                    @crop="saveCroppedImage"
                    @change="logoChanged"
                    :src="logoSrc"
                    :stencil-props="cropperOptions"
                    />
                </template>
                <template v-slot:footer>
                    <button class="bg-green-500 text-white p-2 hover:bg-green-400" @click="saveCroppedImage()">Save Logo</button>
                </template>
            </dialog-modal>
          </section>
  
          <section class="bg-white max-w-7xl mx-auto sm:px-6 py-3">
            <span class="text-lg font-bold">{{ company.name }}</span>
            <br />
            <small class="text-gray-500" v-html="companyIndustry"></small>
          </section>
          <section class="bg-white max-w-7xl mx-auto sm:px-6 py-3">
            <a
              href=""
              class="border-green-400 border py-1 px-2 rounded-2xl text-green-400"
            >Visit website</a>
          </section>
          <section
            class="bg-white flex max-w-7xl mx-auto sm:px-6 py-2 border-t-2 border-top border-gray-200 space-x-4 sticky top-12"
          >
            <span
              :class="sectionClass('about')"
              @click="getSectionDetails('about')"
            >About</span>
            <span
              :class="sectionClass('jobs')"
              @click="getSectionDetails('jobs')"
            >Jobs</span>
            <span
              :class="sectionClass('reviews')"
              @click="getSectionDetails('reviews')"
            >Reviews</span>
          </section>
  
          <section
            class="bg-white max-w-7xl mx-auto xs:px-4 md:m sm:px-6 py-2 mt-2 text-gray-500"
          >
            <div v-if="current_section === 'about'">
              <div
                class="border border-dashed p-4 text-center text-gray-500"
                v-if="!company.description && canCustomize && !entering.description"
              >
                <span
                  class="cursor-pointer"
                  id="add-company-description"
                  @click="addCompanyDescription"
                >Click to add description</span>
              </div>
              <div v-if="!entering.description && company.description">
                <span
                  class="float-right"
                  title="Edit Description"
                  @click="entering.description = true"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 text-gray-500 hover:text-green-400 font-bold cursor-pointer"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" data-v-6d6ef73a=""></path>
                  </svg>
                </span>
                <div v-html="company.description"></div>
              </div>
              <div v-if="entering.description">
                <quill-editor
                  theme="snow"
                  content-type="html"
                  :content="company.description"
                  v-model:content="new_description"
                ></quill-editor>
                <button
                  class="bg-green-400 py-1 px-2 text-white mt-1"
                  @click="saveDescription"
                  :disabled="saving.description"
                >
                  <span v-if="!saving.description">Save</span>
                  <Loader color="white" v-else></Loader>
                </button>
                <button
                  class="bg-gray-400 py-1 px-2 text-white mt-1 ml-2"
                  @click="cancelCompanyDescription"
                >Cancel</button>
              </div>
            </div>
            <div v-if="current_section === 'jobs'">
              <section v-if="canCustomize" class="py-2">
                <div class="text-center">
                  <span v-if="!jobs.length" class="text-gray-400"
                    >Jobs that you post will appear here</span
                  >
                  <Link
                    :href="route('company.post-job')"
                    class="text-green-400 font-bold ml-4"
                    >Post A Job</Link
                  >
                </div>
                <div class="class" v-if="jobs.length">
                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Job Card 1 -->
                    <div
                      class="bg-white rounded-lg border border-gray-300 p-4"
                      v-for="job in jobs"
                    >
                      <h3 class="text-l text-green-500 font-bold mb-2">
                        {{ job.title }}
                      </h3>
                      <p class="text-gray-600 mb-2 text-sm">{{ job.location }}</p>
                      <div class="flex justify-between">
                        <p class="text-gray-600">{{ job.type.name }}</p>
                        <p class="text-gray-500">Views: {{ job.views_count }}</p>
                      </div>
                    </div>
                    <!-- Add more job cards as needed -->
                  </div>
                </div>
              </section>
            </div>
            <div v-if="current_section === 'reviews'" class="py-2">
              <div class="text-center" v-if="!reviews.length">
                <span v-if="canCustomize"
                  >Reviews about your company will appear here</span
                >
                <span v-else>There aren't any reviews left for this company</span>
              </div>
            </div>
          </section>
          <div>
            <v-tour name="myTour" :steps="tour_steps"></v-tour>
          </div>
        </div>
      </app-layout>
    </div>
  </template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import {Head, Link} from '@inertiajs/inertia-vue3';
import Button from "@/Jetstream/Button";
import {QuillEditor} from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Swal from "sweetalert2";
import Loader from "@/Custom/Loader";
import { Cropper } from 'vue-advanced-cropper'
import 'vue-advanced-cropper/dist/style.css';
import { ResizeEvent } from 'vue-advanced-cropper';
import DialogModal from "@/Jetstream/DialogModal";

export default {
        name: "Customize",
        components: {
            AppLayout, Head, Link, Button, QuillEditor, Loader, Cropper, DialogModal
        },
        mounted() {
            //console.log(this.company);
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
            //this.$tours['myTour'].start();
            /* this.createTour();
            this.tour.start(); */
            //window.scrollTo(0, 0);
            
        },
        data(){
            return {
                new_description: 'Industry',
                current_section: 'about',
                logo_crop_modal: false,
                logo_crop_cover_modal: false,
                company: this.$page.props.company,
                logo_upload_progress: 0,
                cover_upload_progress: 0,
                cover_dimensions: {
                    height: 191,
                    width: 1128,
                    top: 0,
                    left: 0,
                },
                logo_dimensions: {
                    height: 208,
                    width: 208,
                    top: 0,
                    left: 0,
                },
                logoSrc: "", // Stores the URL of the selected logo image
                coverSrc: "",
                cropperCoverOptions: {
                    aspectRatio: 50/5, // Crop aspect ratio (square in this example)
                    guides: true, // Show crop guides
                    viewMode: 1, // Show cropped area within the container
                    autoCropArea: 0.8, // Set initial crop area size
                    checkOrientation: false, // Disable auto-rotation
                },
                cropperOptions: {
                    aspectRatio: 1, // Crop aspect ratio (square in this example)
                    guides: true, // Show crop guides
                    viewMode: 1, // Show cropped area within the container
                    autoCropArea: 0.8, // Set initial crop area size
                    checkOrientation: false, // Disable auto-rotation
                },
                tr: null,
                current_logo: '',
                jobs: this.$page.props.jobs,
                reviews: [],
                entering: {
                    description: false,
                },
                saving: {
                    description: false,
                    logo: false,
                    cover: false,
                },
                shepherd_steps: [
                    {
                    id: 'step1',
                    attachTo: { element: '#add-logo', on: 'bottom' },
                    text: 'Step 1 description',
                    }
                ],
                tour_steps: [
                    {
                        target: '#add-logo',  // We're using document.querySelector() under the hood
                        header: {
                            title: 'Get Started',
                        },
                        content: `Click here to add your company logo!`,
                        params: {
                            placement: 'right' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
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
            logoChanged({coordinates, canvas}){
                console.log(coordinates, canvas)
            },
            startCropCover(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                    this.coverSrc = reader.result;
                    this.logo_crop_cover_modal = true;
                    this.$refs.cropperCover.showCropper();
                    };
                    reader.readAsDataURL(file);
                }
            },
            startCrop(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = () => {
                    this.logoSrc = reader.result;
                    this.logo_crop_modal = true;
                    this.$refs.cropper.showCropper();
                    };
                    reader.readAsDataURL(file);
                }
            },

            saveCroppedCoverImage() {
                const { canvas } = this.$refs.cropperCover.getResult();
                if (canvas) {
                    canvas.toBlob(blob => {
                        let formData = new FormData();
                        formData.append('files', blob);
                        formData.append('model', 'App\\Models\\Company');
                        formData.append('collection', "cover"/* type */);
                        formData.append('model_id', this.company.id);
                        formData.append('upload_dir', 'covers');
                        axios.post(route('file.save'), formData, {
                            headers: {
                                'Content-type' : 'multipart/form-data'
                            },
                            onUploadProgress: function(progressEvent) {
                                this.cover_upload_progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                                console.log(this.cover_upload_progress)
                            }
                        }).then((response) => {
                            console.log(response.data.link);
                            this.company.cover_url = response.data.link;
                            this.cover_upload_progress = 0;
                            this.saving.cover = false;
                            this.company.cover = 1;
                            this.logo_crop_cover_modal = false;
                        }).catch(error => {
                            Swal.fire({
                                title: "Failed",
                                text: "The upload has failed",
                                icon: "error",
                            })
                            console.log(error.response.data)
                            this.saving.cover = false;
                        })
                    }, 'image/jpeg');
                }
            },
            saveCroppedImage() {
                const { canvas } = this.$refs.cropper.getResult();
                if (canvas) {
                    canvas.toBlob(blob => {
                        let formData = new FormData();
                        formData.append('files', blob);
                        formData.append('model', 'App\\Models\\Company');
                        formData.append('collection', "logo"/* type */);
                        formData.append('model_id', this.company.id);
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
                            this.logo_crop_modal = false;
                        }).catch(error => {
                            Swal.fire({
                                title: "Failed",
                                text: "The upload has failed",
                                icon: "error",
                            })
                            console.log(error.response.data)
                            this.saving.logo = false;
                        })
                    }, 'image/jpeg');
                }
            },
            createTour(){
                this.tour = this.$shepherd({
                useModalOverlay: true,

                });
                for (let x = 0; x < this.shepherd_steps.length; x++){
                    this.tour.addStep(this.shepherd_step[x]);
                }
                
            
            },
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
            companyIndustry(){
                if(this.company.industry){
                    return this.company.industry.name
                }
                return ''
            },
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
                return this.company.original_user === this.$page.props.user.id;
            },
            logoUploadProgress(){
                return ''
            }
        }
    }
</script>

<style scoped>
    .active {
        border-bottom-width: 2px;
        border-color: rgba(49, 196, 141, var(--tw-border-opacity));
        color: rgba(49, 196, 141, var(--tw-text-opacity));
    }

    ::v-deep(li) {
        list-style-type: circle;
        list-style-position: inside;
        margin-left: 10px;
        margin-inside: 10px;
    }

    ::v-deep(h2){
        font-size: x-large;
        font-weight: bold;
        margin-top: 8px
    }
</style>
