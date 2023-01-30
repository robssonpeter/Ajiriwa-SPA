<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="relative bg-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div
                class="flex justify-between items-center border-gray-100 py-2 md:justify-start md:space-x-10">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <Link :href="route('dashboard')" class="flex space-x-2" id="home-link">
                        <span class="sr-only">Workflow</span>
                        <!-- <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt=""> -->
                        <img class="h-8 w-auto sm:h-10" :src="route('root')+'/images/ajiriwa-new-logo.png'" alt="">
                        <span class=" self-center text-2xl font-bold text-gray-500">Ajiriwa.net</span>
                    </Link>
                </div>
                <div class="-mr-2 -my-2 md:hidden">
                    <button type="button"
                            class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                            aria-expanded="false">
                        <span class="sr-only">Open menu</span>
                        <!-- Heroicon name: outline/menu -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
                <nav class="hidden md:flex space-x-10">
                    <Link :href="route('jobs.browse')" class="text-gray-500">Jobs</Link>
                    <div class="relative">
                        <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                        <Menu>
                            <MenuButton>
                                <a type="button"
                                   class="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                   aria-expanded="false">
                                    <span>Menu</span>
                                    <!--
                                      Heroicon name: solid/chevron-down

                                      Item active: "text-gray-600", Item inactive: "text-gray-400"
                                    -->
                                    <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                         aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </MenuButton>

                            <!--
                              'Solutions' flyout menu, show/hide based on flyout menu state.

                              Entering: "transition ease-out duration-200"
                                From: "opacity-0 translate-y-1"
                                To: "opacity-100 translate-y-0"
                              Leaving: "transition ease-in duration-150"
                                From: "opacity-100 translate-y-0"
                                To: "opacity-0 translate-y-1"
                            -->
                            <Menu as="div" class="relative inline-block text-left">
<!--                                <div>
                                    <MenuButton class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                                        Options
                                        <ChevronDownIcon class="-mr-1 ml-2 h-5 w-5" aria-hidden="true" />
                                    </MenuButton>
                                </div>-->

                                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems class="absolute right-0 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <div class="py-1">
                                            <MenuItem v-slot="{ active }">
                                                <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Account settings</a>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">Support</a>
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">License</a>
                                            </MenuItem>
                                            <form method="POST" action="#">
                                                <MenuItem v-slot="{ active }">
                                                    <button type="submit" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block w-full px-4 py-2 text-left text-sm']">Sign out</button>
                                                </MenuItem>
                                            </form>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>
                            <MenuItems>
                                <div
                                    class="absolute z-10 -ml-4 mt-3 transform px-2 w-screen max-w-md sm:px-0 lg:ml-0 lg:left-1/2 lg:-translate-x-1/2">
                                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                        <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                            <MenuItem>
                                                <Link :href="route('my-resume')"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    <!-- Heroicon name: outline/chart-bar -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            My Resume
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Have a look at your current CV that is visible to employers
                                                        </p>
                                                    </div>
                                                </Link>
                                            </MenuItem>
                                            <MenuItem>
                                                <Link :href="route('my-resume.edit')"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    <!-- Heroicon name: outline/chart-bar -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            Update My Resume
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Make changes to your CV Info
                                                        </p>
                                                    </div>
                                                </Link>
                                            </MenuItem>
                                            <MenuItem>
                                                <Link :href="route('my-applications')"
                                                      class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    <!-- Heroicon name: outline/cursor-click -->
                                                    <svg class="flex-shrink-0 h-6 w-6 text-green-600"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            My Applications
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Keep track of the status of all applications that you've made.
                                                        </p>
                                                    </div>
                                                </Link>
                                            </MenuItem>

                                            <MenuItem>
                                                <Link :href="route('saved-jobs')"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    <!-- Heroicon name: outline/shield-check -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            Saved Jobs
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            See your bookmarked jobs here.
                                                        </p>
                                                    </div>
                                                </Link>
                                            </MenuItem>

<!--                                            <MenuItem>
                                                <a href="#"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    &lt;!&ndash; Heroicon name: outline/view-grid &ndash;&gt;
                                                    <svg class="flex-shrink-0 h-6 w-6 text-green-600"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            Integrations
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Connect with third-party tools that you&#039;re already
                                                            using.
                                                        </p>
                                                    </div>
                                                </a>
                                            </MenuItem>-->

<!--                                            <MenuItem>
                                                <a href="#"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    &lt;!&ndash; Heroicon name: outline/refresh &ndash;&gt;
                                                    <svg class="flex-shrink-0 h-6 w-6 text-green-600"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            Automations
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Build strategic funnels that will drive your customers to
                                                            convert
                                                        </p>
                                                    </div>
                                                </a>
                                            </MenuItem>-->
                                        </div>
                                        <!-- <div
                                            class="px-5 py-5 bg-gray-50 space-y-6 sm:flex sm:space-y-0 sm:space-x-10 sm:px-8">
                                            <div class="flow-root">
                                                <a href="#"
                                                   class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">
                                                    
                                                    <svg class="flex-shrink-0 h-6 w-6 text-gray-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="ml-3">Watch Tutorials</span>
                                                </a>
                                            </div>

                                            <div class="flow-root">
                                                <a href="#"
                                                   class="-m-3 p-3 flex items-center rounded-md text-base font-medium text-gray-900 hover:bg-gray-100">
                                                    
                                                    <svg class="flex-shrink-0 h-6 w-6 text-gray-400"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                    </svg>
                                                    <span class="ml-3">Contact Us</span>
                                                </a>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </MenuItems>
                        </Menu>
                    </div>

                    <!--<router-link :to="{ name: 'Jobs'}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                      Jobs
                    </router-link>
                    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                      Blog
                    </a>
                    <a href="#" class="text-base font-medium text-gray-500 hover:text-gray-900">
                      Employers
                    </a>-->

                    <div class="relative">
                        <Menu v-if="0">
                            <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                            <MenuButton>
                                <a type="button"
                                   class="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                   aria-expanded="false">
                                    <span>More</span>
                                    <!--
                                      Heroicon name: solid/chevron-down

                                      Item active: "text-gray-600", Item inactive: "text-gray-400"
                                    -->
                                    <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                         aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </a>
                            </MenuButton>

                            <!--
                              'More' flyout menu, show/hide based on flyout menu state.

                              Entering: "transition ease-out duration-200"
                                From: "opacity-0 translate-y-1"
                                To: "opacity-100 translate-y-0"
                              Leaving: "transition ease-in duration-150"
                                From: "opacity-100 translate-y-0"
                                To: "opacity-0 translate-y-1"
                            -->
                            <MenuItems>
                                <div
                                    class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-md sm:px-0">
                                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                        <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                            <MenuItem>
                                                <a href="#"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    <!-- Heroicon name: outline/support -->
                                                    <svg class="flex-shrink-0 h-6 w-6 text-green-600"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            Help Center
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Get all of your questions answered in our forums or contact
                                                            support.
                                                        </p>
                                                    </div>
                                                </a>
                                            </MenuItem>

                                            <MenuItem>
                                                <a href="#"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    <!-- Heroicon name: outline/bookmark-alt -->
                                                    <svg class="flex-shrink-0 h-6 w-6 text-green-600"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            Guides
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Learn how to maximize our platform to get the most out of
                                                            it.
                                                        </p>
                                                    </div>
                                                </a>
                                            </MenuItem>

                                            <MenuItem>
                                                <a href="#"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    <!-- Heroicon name: outline/calendar -->
                                                    <svg class="flex-shrink-0 h-6 w-6 text-green-600"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            Events
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            See what meet-ups and other events we might be planning near
                                                            you.
                                                        </p>
                                                    </div>
                                                </a>
                                            </MenuItem>

                                            <MenuItem>
                                                <a href="#"
                                                   class="-m-3 p-3 flex items-start rounded-lg hover:bg-green-50">
                                                    <!-- Heroicon name: outline/shield-check -->
                                                    <svg class="flex-shrink-0 h-6 w-6 text-green-600"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                    <div class="ml-4">
                                                        <p class="text-base font-medium text-gray-900">
                                                            Security
                                                        </p>
                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Understand how we take your privacy seriously.
                                                        </p>
                                                    </div>
                                                </a>
                                            </MenuItem>
                                        </div>
                                        <div class="px-5 py-5 bg-gray-50 sm:px-8 sm:py-8">
                                            <div>
                                                <h3 class="text-sm tracking-wide font-medium text-gray-500 uppercase">
                                                    Recent Posts
                                                </h3>
                                                <ul class="mt-4 space-y-4">
                                                    <li class="text-base truncate">
                                                        <a href="#"
                                                           class="font-medium text-gray-900 hover:text-gray-700">
                                                            Boost your conversion rate
                                                        </a>
                                                    </li>

                                                    <li class="text-base truncate">
                                                        <a href="#"
                                                           class="font-medium text-gray-900 hover:text-gray-700">
                                                            How to use search engine optimization to drive traffic to
                                                            your site
                                                        </a>
                                                    </li>

                                                    <li class="text-base truncate">
                                                        <a href="#"
                                                           class="font-medium text-gray-900 hover:text-gray-700">
                                                            Improve your customer experience
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="mt-5 text-sm">
                                                <a href="#" class="font-medium text-green-600 hover:text-green-500">
                                                    View all posts <span aria-hidden="true">&rarr;</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </MenuItems>
                        </Menu>
                    </div>
                </nav>

                <dropdown align="right" width="48" v-if="$page.props.user" class="hidden md:block float-right">
                    <template #trigger>
                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                        </button>

                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                    </template>

                    <template #content>

                        <form @submit.prevent="$inertia.post(route('logout'))">
                            <dropdown-link as="button">
                                Log Out
                            </dropdown-link>
                        </form>
                    </template>
                </dropdown>


                <div v-else class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                    <Link :href="route('login')" class="whitespace-nowrap text-base font-medium text-gray-500 hover:text-gray-900">
                        Sign in
                    </Link>
                    <Link :href="route('register')"
                       class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-500 hover:bg-green-700">
                        Register
                    </Link>
                </div>
            </div>
        </div>

        <!--
          Mobile menu, show/hide based on mobile menu state.

          Entering: "duration-200 ease-out"
            From: "opacity-0 scale-95"
            To: "opacity-100 scale-100"
          Leaving: "duration-100 ease-in"
            From: "opacity-100 scale-100"
            To: "opacity-0 scale-95"
        -->
        <Menu>
            <div class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right hidden md:hidden">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                <div class="pt-5 pb-6 px-5">


                    <div class="flex items-center justify-between">
                        <div>
                            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg"
                                 alt="Workflow">
                        </div>
                        <div class="-mr-2">
                            <button type="button"
                                    class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <span class="sr-only">Close menu</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-6">
                        <nav class="grid gap-y-8">
                            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                <!-- Heroicon name: outline/chart-bar -->
                                <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="ml-3 text-base font-medium text-gray-900">
                Analytics
              </span>
                            </a>

                            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                <!-- Heroicon name: outline/cursor-click -->
                                <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                                </svg>
                                <span class="ml-3 text-base font-medium text-gray-900">
                Engagement
              </span>
                            </a>

                            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                <!-- Heroicon name: outline/shield-check -->
                                <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span class="ml-3 text-base font-medium text-gray-900">
                Security
              </span>
                            </a>

                            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                <!-- Heroicon name: outline/view-grid -->
                                <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                </svg>
                                <span class="ml-3 text-base font-medium text-gray-900">
                Integrations
              </span>
                            </a>

                            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-green-50">
                                <!-- Heroicon name: outline/refresh -->
                                <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span class="ml-3 text-base font-medium text-gray-900">
                Automations
              </span>
                            </a>
                        </nav>
                    </div>
                </div>
                <div class="py-6 px-5 space-y-6">
                    <div class="grid grid-cols-2 gap-y-4 gap-x-8">
                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                            Pricing
                        </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                            Docs
                        </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                            Help Center
                        </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                            Guides
                        </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                            Events
                        </a>

                        <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">
                            Security
                        </a>
                    </div>
                    <div>
                        <a href="#"
                           class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Sign up
                        </a>
                        <p class="mt-6 text-center text-base font-medium text-gray-500">
                            Existing customer?
                            <a href="#" class="text-green-600 hover:text-green-500">
                                Sign in
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </Menu>
    </div>
</template>
<script>
    import {Menu, MenuButton, MenuItems, MenuItem} from "@headlessui/vue";
    import { Link } from '@inertiajs/inertia-vue3';
    import Dropdown from "@/Jetstream/Dropdown";
    import DropdownLink from "@/Jetstream/DropdownLink";


    export default {
        components: {
            Menu, MenuButton, MenuItems, MenuItem, Link, Dropdown, DropdownLink
        },
        data() {
            return {
                dropdowns: {
                    one: {
                        is_open: false
                    },
                    two: {
                        is_open: false
                    }
                }
            };
        },
        methods: {
            dropdownControl: function (type, is_open) {
                this.dropdowns.one.is_open = false;
                this.dropdowns.two.is_open = false;
                this.dropdowns[type].is_open = !is_open
            }
        }
    }
</script>
