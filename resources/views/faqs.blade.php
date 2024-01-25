@extends('layouts.app')

@section('content')
<style>
    /*#search-section {
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%2310b981' fill-opacity='0.47' fill-rule='evenodd'/%3E%3C/svg%3E") !important;
        }*/
    input[type=file]::file-selector-button {
        background: rgba(243, 244, 246, var(--tw-bg-opacity)) !important;
        color: black;
    }

    .autocomplete {
        position: absolute;
        width: 100%;
        /* Set autocomplete div width to 100% */
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #ccc;
        background-color: #fff;
        z-index: 1000;
        /*display: none;*/
    }

    .autocomplete-item {
        padding: 8px;
        color: rgb(16 185 129);
        cursor: pointer;
    }

    .autocomplete-item:hover {
        color: #f0f0f0;
        background-color: rgb(16 185 129);
    }
    #faq-page a{
        color: rgb(16 185 129);
    }
</style>
<div class="w-full md:max-w-7xl mx-auto pt-5 mb-12 bg-white" id="faq-page">
    <div class="py-8 px-4 w-100 mx-auto sm:py-16 lg:px-6">
        <h2 class="mb-8 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Frequently asked questions</h2>
        @php
        $firstPart = floor(count($faqs)/2);
        $secondPart = count($faqs) - $firstPart
        @endphp
        <div class="grid pt-8 text-left border-t border-gray-200 md:gap-16 dark:border-gray-700 md:grid-cols-2 gap-3">
            <div>
                <div id="search-box" class="mb-8 relative invisible">
                    <input type="text" id="faq-search" @keyup="searchFaq" v-model="searchTerm" class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-full" placeholder="Search FAQs">
                    <div id="autocomplete" v-if="results.length" class="autocomplete rounded-md">
                        <div class="autocomplete-item" @click="autocompleteClicked(item)" :key="`autocomplete-${index}`" v-for="(item, index) in results">
                            @{{ item.question }}
                        </div>
                    </div>
                </div>
                @for ($x = 0; $x < $firstPart; $x++) <div class="mb-10">
                    <h3 @click="openModal({!! htmlspecialchars(json_encode($faqs[$x]), ENT_QUOTES, 'UTF-8') !!})" class="flex items-center mb-4 text-lg font-medium text-green-400 hover:text-green-300 cursor-pointer dark:text-white font-bold">
                        <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $faqs[$x]->question }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ Illuminate\Support\Str::limit(strip_tags(htmlspecialchars_decode($faqs[$x]->answer)), 200) }}</p>
            </div>
            @endfor
        </div>
        <div>
            @for ($x; $x < count($faqs); $x++) <div class="mb-10">
                <h3 @click="openModal({{ json_encode($faqs[$x]) }})" class="flex items-center mb-4 text-lg font-medium hover:text-green-300 cursor-pointer text-green-400 dark:text-white font-bold">
                    <svg class="flex-shrink-0 mr-2 w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    {!! $faqs[$x]->question !!}
                </h3>
                <p class="text-gray-500 dark:text-gray-400">{{ Illuminate\Support\Str::limit(strip_tags(htmlspecialchars_decode($faqs[$x]->answer)), 200) }}</p>
        </div>
        @endfor
    </div>
</div>
</div>
<!-- Faq Details Modal -->
<div id="faqModal" v-if="selectedFaq" :class="`fixed inset-0 z-50 overflow-auto bg-black bg-opacity-50 ${!selectedFaq ? 'hidden' : ''}`">
    <div class="flex items-center justify-center min-h-screen max-w-2xl">
        <div class="bg-white max-w-xl mx-auto rounded shadow-lg">
            <div>
                <section class="px-6 pt-8 border-b">
                    <h3 class="text-xl text-gray-700 font-semibold mb-4">@{{ selectedFaq.question }}</h3>
                </section>
                <div class="p-6">
                    <p class="text-gray-500 dark:text-gray-400" v-html="selectedFaq.answer"></p>
                </div>
            </div>
            <div class="mt-6 text-right border-t py-4 px-6">
                <button @click="closeModal" class="text-white p-2 rounded-md bg-gray-400 hover:text-gray-700 cursor-pointer">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    const searchRoute = "{{ route('faq.search') }}";
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('faq-search');
        const autocompleteContainer = document.getElementById('autocomplete');
        const faqItems = document.querySelectorAll('.mb-10'); // Adjust this selector based on your structure

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();

            // Filter FAQ items and show/hide based on the search term
            /* faqItems.forEach(function(item) {
                const faqText = item.textContent.toLowerCase();

                if (faqText.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }); */

            // Get autocomplete suggestions
            const autocompleteSuggestions = getAutocompleteSuggestions(searchTerm);

            // Display autocomplete suggestions
            displayAutocomplete(autocompleteSuggestions);
        });

        function getAutocompleteSuggestions(searchTerm) {
            // Replace this with your logic to fetch autocomplete suggestions
            //alert('you are here');
            /* let response = await axios.post("{{ route('faq.search') }}", {q: searchTerm}).then(result => {
                return result.data.results;
            }); */
            //return response;
            //console.log(response);
            //return ["Result 1", "Result 2", "Result 3"];
        }

        function displayAutocomplete(suggestions) {
            // Display autocomplete suggestions below the search box
            /* autocompleteContainer.innerHTML = '';

            if (suggestions.length > 0) {
                suggestions.forEach(function(suggestion) {
                    const autocompleteItem = document.createElement('div');
                    autocompleteItem.classList.add('autocomplete-item');
                    autocompleteItem.textContent = suggestion;

                    autocompleteItem.addEventListener('click', function() {
                        // Set the selected suggestion in the search box
                        searchInput.value = suggestion;
                        autocompleteContainer.style.display = 'none';
                    });

                    autocompleteContainer.appendChild(autocompleteItem);
                });

                autocompleteContainer.style.display = 'block';
            } else {
                autocompleteContainer.style.display = 'none';
            } */
        }

        // Close autocomplete if the user clicks outside the search box
        document.addEventListener('click', function(event) {
            if (!event.target.matches('#faq-search') && !event.target.matches('.autocomplete-item')) {
                autocompleteContainer.style.display = 'none';
            }
        });
    });
</script>
<script>
    let sessionUrl = "{{ route('session.create') }}";
</script>
<script src="{{ mix('js/faqs.js') }}" onload="document.getElementById('search-box').classList.remove('invisible')"></script>
@endsection