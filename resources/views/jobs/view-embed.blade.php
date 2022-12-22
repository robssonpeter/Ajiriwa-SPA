@extends('layouts.app')

@section('content')
    <style>
        /*#search-section {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E") !important;
        }*/
        input[type=file]::file-selector-button{
            background: rgba(243, 244, 246, var(--tw-bg-opacity)) !important;
            color: black;
        }
    </style>
    <div class="w-full md:max-w-7xl mx-auto pt-5 mb-12 md:grid md:grid-cols-6 gap-2" id="job-page">
        <div class="col-span-4 mr-8 md:mr-0">
            <div class="bg-white shadow-lg  ml-8 p-4">
                <section class="md:grid grid-cols-4">
                    <div class="col-span-3 flex flex-col">
                        <span class="text-xl text-gray-500 font-bold">{{ $job->title }}</span>
                        <span class="text-green-500">{{ $job->company->name }}</span>
                        <span class="text-gray-500">{{ $job->location }}</span>
                    </div>
                    <div class="md:grid md:grid-cols-2 md:gap-4 hidden md:block">
                        <button class="bg-green-500 rounded-md text-white p-2 self-center" @click="apply">Apply</button>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6 self-center text-green-500 cursor-pointer"
                             data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z"/>
                        </svg>
                    </div>


                </section>
                <div class="bg-gray-200 w-100 p-4 mt-2 md:grid md:grid-cols-4">
                    <section class="md:flex md:flex-col flex-row">
                        <span class="font-bold hidden md:block">Job Type:</span>
                        <div class="items-center md:hidden block px-2 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                            </svg>
                            <span class="pl-4 md:pl-0 self-center md:self-start">{{ $job->type->name }}</span>
                        </div>
                        <span class="pl-4 md:pl-0 hidden md:block self-start">{{ $job->type->name }}</span>
                    </section>
                    <section class="md:flex md:flex-col flex-row">
                        <span class="font-bold hidden md:block">Closing Date:</span>
                        <div class="items-center md:hidden block px-2 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                            </svg>
                            <span class="pl-4 md:pl-0 self-center md:self-start">{{ Carbon\Carbon::parse($job->deadline)->format('jS F Y') }}</span>
                        </div>
                        <span class="pl-4 md:pl-0 hidden md:block self-start">{{ Carbon\Carbon::parse($job->deadline)->format('jS F Y') }}</span>
                    </section>
                    <section class="md:flex md:flex-col flex-row">
                        <span class="font-bold hidden md:block">Location:</span>
                        <div class="items-center md:hidden block px-2 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span class="pl-4 md:pl-0 self-center md:self-start">{{ $job->location }}</span>
                        </div>
                        <span class="pl-4 md:pl-0 hidden md:block self-start">{{ $job->location }}</span>
                    </section>
                    <section class="md:flex md:flex-col flex-row">
                        <span class="font-bold hidden md:block">Views:</span>
                        <div class="items-center md:hidden block px-2 flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-green-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="pl-4 md:pl-0 self-center md:self-start">300</span>
                        </div>
                        <span class="pl-4 md:pl-0 hidden md:block self-start">300</span>
                    </section>
                    <div class="flex flex-row py-2 md:hidden">
                        <button class="bg-green-500 rounded-md w-full text-white p-2 self-center" @click="apply">Apply</button>

                    </div>
                </div>
            </div>

            <div class="bg-white shadow-lg  ml-8 p-4 mt-2 description text-gray-600">
                {!! $job->description !!}
            </div>
        </div>
        <div class="bg-white col-span-2 mr-16 px-4 self-start py-4 shadow-lg hidden md:block">
            <section class="flex flex-row border-b pb-2">
                <div class="h-16 w-16 bg-green-200">
                    <img src="{{ $job->company->logo_url }}" alt="">
                </div>
                <section class="px-4 flex flex-col ">
                    <a href="{{ route('company.show', $job->company->slug) }}"
                       class="font-bold text-green-600 cursor-pointer">{{ $job->company->name }}</a>
                    <span class="text-gray-600">Banking</span>
                    @if($job->company->website)
                        <small class="text-green-500" onclick="window.location.href = '{{ $job->company->website }}'">Website</small>
                    @endif
                </section>
            </section>

        </div>
        <TransitionRoot
            :show="true"
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100"
            leave-to="opacity-0"
        >
            <Dialog as="div" :open="application_means.show_modal" class="relative z-50">
                <!-- The backdrop, rendered as a fixed sibling to the panel container -->
                <div class="fixed inset-0 bg-black/40" aria-hidden="true"/>

                <!-- Full-screen container to center the panel -->
                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <!-- The actual dialog panel -->
                    <DialogPanel
                        class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                        <DialogTitle
                            as="h3"
                            class="text-lg font-medium leading-6 text-gray-600 p-4"
                        >
                            <strong>Application</strong>
                            <button type="button" @click="closeApply"
                                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline text-xs float-right"
                                    data-bs-dismiss="modal" aria-label="Close"></button>

                        </DialogTitle>
                        <DialogDescription>
                            <div class="mt-2">
                                @if($allow_apply)
                                    <div class="modal-body relative p-4 text-gray-700">
                                        <span>How do you want to apply?</span>
                                    </div>
                                    <div class="mt-4 px-4">
                                        <button
                                            type="button"
                                            class="inline-flex justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white hover:bg-green-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                            @click="loginToApply"
                                        >
                                            Login to Quickly Apply
                                        </button>
                                        <button
                                            type="button"
                                            class="ml-2 inline-flex justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                            @click="applyWithoutLogin"
                                        >
                                            Apply Without Login
                                        </button>
                                    </div>
                                @else
                                    <div class="mt-4 px-4">
                                        <span class="text-gray-700">Sorry, this job no longer accepts new applications</span>
                                        <div class="pt-4">
                                            <button class="bg-gray-700 rounded-md float-right text-white p-2 text-white" @click="closeApply">Okay</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </DialogDescription>

                        <!-- ... -->
                    </DialogPanel>
                </div>
            </Dialog>

            <Dialog as="div" :open="guest_application.show_modal" class="relative z-50">
                <!-- The backdrop, rendered as a fixed sibling to the panel container -->
                <div class="fixed inset-0 bg-black/40" aria-hidden="true"/>

                <!-- Full-screen container to center the panel -->
                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <!-- The actual dialog panel -->
                    <DialogPanel
                        class="w-full max-w-3xl transform overflow-hidden rounded-2xl bg-gray-100 p-6 text-left align-middle shadow-xl transition-all">
                        <DialogTitle
                            as="h3"
                            class="text-lg font-medium leading-6 text-gray-600 p-4"
                        >
                            <strong>Applying...</strong>
                            <button type="button" @click="guest_application.show_modal=false"
                                    class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline text-xs float-right"
                                    data-bs-dismiss="modal" aria-label="Close"></button>

                        </DialogTitle>
                        <DialogDescription>
                            <div class="mt-2">
                                <form action="" id="guest-application" @submit.prevent="">
                                <div class="modal-body relative p-4 text-gray-700">
                                    <div class="md:flex justify-start">
                                        <div class="mb-3 w-full flex flex-col">
                                            <label for="exampleFormControlInput1"
                                                   class="form-label inline-block mb-2 text-gray-700 font-bold"
                                            >Full Name</label
                                            >
                                            <input type="text" name="full_name" v-model="application.name" placeholder="Your name" class="w-full focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                        </div>
                                        <div class="mb-3 w-full flex flex-col md:ml-2">
                                            <label for="exampleFormControlInput1"
                                                   class="form-label inline-block mb-2 text-gray-700 font-bold"
                                            >Email</label
                                            >
                                            <input type="email" name="email" v-model="application.email" placeholder="Your email" class="w-full focus:border-green-300 focus:ring focus:ring-green-200 focus:outline-none border-gray-300">
                                        </div>
                                    </div>
                                    <section>
                                        <span class="font-bold">Cover Letter</span>
                                        <input type="hidden" name="job_id" value="{{$job->id}}">
                                        <input type="hidden" name="cover_letter" v-model="application.cover_letter">
                                        <text-editor @change="editorChanged" text="Write you cover letter here" class="bg-white max-h-52 overflow-y-auto" v-model="application.cover_letter"></text-editor>
                                    </section>

                                    <div class="flex">
                                        <div class="mb-3 w-full pt-4">
                                            <label for="formFileMultiple" class="form-label inline-block mb-2 text-gray-700 font-bold">Attachments</label>
                                            <input name="attachments[]" class="form-control
                                                            button
                                                            block
                                                            w-full
                                                            px-3
                                                            py-1
                                                            font-normal
                                                            text-gray-600
                                                            bg-white bg-clip-padding
                                                            border border-solid border-gray-300
                                                            file:bg-amber-500, file:text-sm
                                                            transition
                                                            ease-in-out
                                                            m-0
                                                            focus:text-gray-700 focus:bg-white focus:border-green-600 focus:ring focus:ring-green-200 focus:outline-none" type="file" id="formFileMultiple" multiple>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 px-4">
                                    <button
                                        type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-green-500 px-4 py-2 text-sm font-medium text-white hover:bg-green-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="sendApplication"
                                        :disabled="applying"
                                    >
                                       <loader v-if="applying" color="white"></loader>
                                       <span v-else>Send Application</span>
                                    </button>
                                    <button
                                        type="button"
                                        class="ml-2 inline-flex justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="guest_application.show_modal=false"
                                    >
                                        Cancel
                                    </button>
<!--                                    <button v-if="applying" @click="applying = false">Unload</button>-->
                                </div>
                                </form>
                            </div>
                        </DialogDescription>

                        <!-- ... -->
                    </DialogPanel>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
    <script type="text/javascript">
        const checkbox = document.getElementById("flexCheckIndeterminate");
        checkbox.indeterminate = true;
    </script>
    <script>
        let job = @json($job);
        let loginPage = "{{ route('login') }}";
        let applyUrl = "{{ route('job.guest-apply') }}";
        let sessionUrl = "{{ route('session.create') }}";
    </script>
    <script src="{{ mix('js/job.js') }}"></script>
@endsection
