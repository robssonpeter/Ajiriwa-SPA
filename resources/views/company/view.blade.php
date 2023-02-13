@extends('layouts.app')
@section('content')
    <style>
        /*#search-section {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E") !important;
        }*/
    </style>
    <div class="bg-gray-200 min-h-screen px-8 mb-2" id="page">

                <!--<div class="bg-white h-32 px-2 align-center max-w-7xl mx-auto sm:px-6">

                </div>-->
        <section class="bg-white max-w-7xl mx-auto sm:px-6">
            <div class="bg-gray-200 h-32 w-100">

            </div>
            <div class="h-32 w-32 bg-gray-100 -mt-16">
                <img src="{{ $company->logo_url }}" class="object-contain">
            </div>

        </section>


        <section class="bg-white max-w-7xl mx-auto sm:px-6 py-3">
            <span class="text-lg font-bold">{{ $company->name }}</span>
            <br>
            <small class="text-gray-500">{{ $company->industry->name??'' }}</small>
        </section>
        @if($company->website)
        <section class="bg-white max-w-7xl mx-auto sm:px-6 py-3">
            <a href="" class="border-green-400 border py-1 px-2 rounded-2xl text-green-400">Visit website</a>
        </section>
        @endif
        <section class="bg-white flex max-w-7xl mx-auto sm:px-6 py-2 border-t-2 border-top border-gray-200 space-x-4 sticky top-12">
            <span :class="sectionClass('about')" @click="getSectionDetails('about')">About</span>
            <span :class="sectionClass('jobs')" @click="getSectionDetails('jobs')">Jobs</span>
            <span :class="sectionClass('reviews')" @click="getSectionDetails('reviews')">Reviews</span>
        </section>

        <section class="bg-white max-w-7xl mx-auto sm:px-6 py-2 mt-2 text-gray-500 mb-2">
            <div id="about" v-if="current_section === 'about'">
                <div v-if="!entering.description && company.description">
                    <div>
                        {!! htmlspecialchars_decode($company->description) !!}
                    </div>
                </div>
            </div>
            <div id ="jobs" v-if="current_section === 'jobs'">
                <section class="py-2">
                    <div class="text-center">
                        <span v-if="!jobs.length" class="text-gray-400">This company has not posted any job</span>
                    </div>
                </section>
            </div>
            <div id="reviews" class="py-2" v-if="current_section === 'reviews'">
                <div class="text-center" v-if="!reviews.length">
                    <span class="text-gray-400" v-if="canCustomize">Reviews about your company will appear here</span>
                    <span class="text-gray-400" v-else>There arent any reviews left for this company</span>
                </div>
            </div>
        </section>
        <!--        <v-tour name="myTour" :steps="tour_steps"></v-tour>-->
        <!--        <cropper
                    class="cropper"
                    ref="cropper"

                    :src="'http://127.0.0.1:8001/uploads/8/tembo-nickel.jpg'"
                    :stencil-props="{
                aspectRatio: 10/10
            }"
                    @change="greet"
                />-->

    </div>
    <script>
        let company = @json($company);
        let user = @json(Auth::user());
    </script>
    <script src="{{ mix('js/Company/details.js') }}">

    </script>
@endsection
