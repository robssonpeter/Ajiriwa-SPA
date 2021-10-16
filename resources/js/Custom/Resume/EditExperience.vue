<template>
    <div>
        <section class=" gap-2">
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 px-2 py-8 self-center" v-if="!experiences.length">
                <span class="p-2 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newExperience">
                        <span>Add Experience</span>
                    </a>
                </span>
                <span class="p-2 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newExperience">
                        <span>Skip Step</span>
                    </a>
                </span>
            </div>
            <transition v-for="(experience, index) in experiences" :key="experience" type="fade">
                    <div class="article-details border-gray-300 border p-2 my-1">
                        <div class="edit-experience grid sm:grid-cols-2 md:grid-cols-6 gap-2"  v-if="experience.editing">
                            <div class="col-span-2 flex flex-col">
                                <label :for="'job_title_'+index" class="font-bold">Job Title</label>
                                <input type="text" v-model="experiences[index].title" class="border border-gray-300" :id="'job_title_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'company_'+index" class="font-bold">Company</label>
                                <input type="text" v-model="experiences[index].company" class="border border-gray-300" :id="'job_company_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'industry_'+index" class="font-bold">Industry</label>
                                <select class="border border-gray-300" v-model="experiences[index].industry_id" :id="'industry_'+index">
                                    <option value="">Select Industry</option>
                                    <option :value="industry.id" v-for="industry in industries">{{ industry.name }}</option>
                                </select>
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'country_'+index" class="font-bold">Country</label>
                                <select class="border border-gray-300" v-model="experiences[index].country_id" :id="'country_'+index">
                                    <option value="">Select Country</option>
                                    <option :value="country.id" v-for="country in countries">{{ country.name }}</option>
                                </select>
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'start_date_'+index" class="font-bold">Start Date</label>
                                <input type="date" v-model="experiences[index].start_date" class="border border-gray-300" :id="'start_date_'+index">
                            </div>
                            <div class="col-span-2 flex flex-col">
                                <label :for="'end_date_'+index" class="font-bold">End Date</label>
                                <div class="flex flex-row gap-2">
                                    <input v-if="experiences[index].currently_working" v-model="experiences[index].end_date" type="date" :disabled="experiences[index].currently_working" class="border border-gray-300 disabled:bg-gray-200" :id="'end_date_'+index">
                                    <input v-else type="date" v-model="experiences[index].end_date" class="border border-gray-300 disabled:bg-gray-200" :id="'end_date_'+index">
                                    <span class="self-center text-green-400 font-bold">Working</span>
                                    <input @change="currently_workingControl(index)" :checked="experiences[index].currently_working" class="self-center text-green-500 focus:border-green-500 focus:border" type="checkbox">
                                </div>
                            </div>

                            <div class="col-span-6 flex flex-col">
                                <label :for="'responsibilities_'+index" class="font-bold">Responsibilities</label>
                                <textarea v-model="experiences[index].description" class="border border-gray-300" :id="'responsibilities_'+index"></textarea>
                            </div>
                            <div class="flex flex-row gap-2">
                                <button @click="cancelEdit(index)" class="bg-gray-400 hover:shadow-lg text-white p-2">Cancel</button>
                                <button :disabled="false" @click="addExperience(index)" class="bg-green-500 hover:shadow-lg text-white p-2">
                                    <span v-if="!experiences[index].saving">Save</span>
                                    <Loader v-else :color="'white'" class="text-red"></Loader>
                                </button>
                                <!--<div class="bg-blue-600 justify-center py-4 px-2">
                                    <Loader :color="'white'"></Loader>
                                </div>-->
                            </div>
                        </div>
                        <section v-else class="view-experience">
                            <div class="article-title">
                                <h5 class="text-green-400 font-bold">{{ experience.title }}</h5>
                                <h6 class="text-muted">{{ experience.company }}</h6>
                            </div>
                            <span class="text-muted italic">1st Dec, 2020 - </span>

                            <span class="text-muted italic">{{ experience.currently_working?'Present':experience.end_date}}</span>
                            <span> | Tanzania</span>
                            <div class="w-28" v-if="experience.currently_working">
                                <p class="text-green-500 border-green-500 text-sm self-center">Works Here</p>
                            </div>


                            <div class="flex flex-row">
                                <span class="flex-grow"><strong>8 months 3 weeks</strong></span>
                                <div class="article-cta candidate-experience-edit-delete flex">
                                    <a href="javascript:void(0)" @click.prevent="editExperience(index)" class="btn btn-warning action-btn edit-experience text-green-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <a href="javascript:void(0)" @click="remove(index)" class="btn btn-danger action-btn delete-experience text-red-500" data-id="2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
            </transition>
            <div class=" border-dotted border border-gray-300 text-center flex gap-3 justify-right px-2 py-4 self-center" v-if="experiences.length && allow_add">
                <span class="p-1 cursor-pointer border border-green-500 text-green-500 hover:text-white hover:bg-green-500">
                    <a href="#" @click.prevent="newExperience">
                        <span>Add Another Experience</span>
                    </a>
                </span>
                <span class="p-1 cursor-pointer border border-green-500 text-white bg-green-500">
                    <a href="#" @click.prevent="newExperience">
                        <span>Next</span>
                    </a>
                </span>
            </div>
        </section>
    </div>
    <!--<div class="grid grid-row grid-cols-2">
        <div class="form-group flex flex-col">
            <label for="experience_title">Experience Title: <span class="text-danger">*</span></label>
            <input class="form-control" required="" name="experience_title" type="text" id="experience_title">
        </div>
        <div class="form-group flex flex-col">
            <label for="career_level_id">Career Level:</label><span class="text-danger"></span>
            <select class="form-control" id="career_level_id" name="career_level_id"><option selected="selected" value="">Select Level</option><option value="1">Entry</option><option value="2">Intermediate</option><option value="3">Senior</option><option value="4">Highly Skilled</option><option value="5">Specialist</option><option value="6">Developing</option><option value="7">Advanced</option><option value="8">Expert</option><option value="9">Principal</option><option value="10">Supervisor</option><option value="11">Sr. Supervisor</option><option value="12">Manager</option><option value="13">Sr. Manager</option><option value="14">Director</option><option value="15">Sr. Director</option><option value="16">Vice President</option></select>
        </div>
        <div class="form-group flex flex-col">
            <label for="industry_id">Industry:</label><span class="text-danger"></span>
            <select class="form-control" id="industry_id" name="industry_id"><option selected="selected" value="">Select Industry</option><option value="2">Advertising</option><option value="6">Automobile</option><option value="1">Manufacturing</option><option value="4">Marketing</option><option value="5">Sales</option><option value="3">Technology</option></select>
        </div>
        <div class="form-group flex flex-col">
            <label for="job_category_id">Job Category:</label><span class="text-danger"></span>
            <select class="form-control" id="job_category_id" name="job_category_id"><option selected="selected" value="">Select Category</option><option value="4">Accountants</option><option value="6">Actuaries</option><option value="1">Agricultural Inspectors</option><option value="8">Biomedical Engineers</option><option value="3">Broadcast Technicians</option><option value="2">Civil Engineers</option><option value="7">Climate Change Analysts</option><option value="5">Coaches and Scouts</option><option value="9">Human Resources</option></select>
        </div>
        <div class="form-group col-12">
            <label for="functionAreas">Functional Areas:</label>
            <select id="addModalFunctionalAreas" class="form-control select2-hidden-accessible" multiple="" name="functional_areas[]" data-select2-id="addModalFunctionalAreas" tabindex="-1" aria-hidden="true"><option value="5">Accounting and Finance</option><option value="8">Administrative/Management</option><option value="3">Customer Service Support</option><option value="6">Distribution</option><option value="1">Human Resource</option><option value="11">IT Support</option><option value="2">Marketing/Promotion</option><option value="10">Operations</option><option value="9">Production</option><option value="7">Research and Development</option><option value="4">Sales</option></select><span class="select2 select2-container select2-container&#45;&#45;default" dir="ltr" data-select2-id="23" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection&#45;&#45;multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="false"><ul class="select2-selection__rendered"><li class="select2-search select2-search&#45;&#45;inline"><input class="select2-search__field" type="search" tabindex="0" autocomplete="off" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" placeholder="" style="width: 0.75em;"></li></ul></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
        </div>
        <div class="form-group col-sm-12">
            <label for="company">Company:</label><span class="text-danger">*</span>
            <input class="form-control" required="" name="company" type="text" id="company">
        </div>
        <div class="form-group col-sm-6">
            <label for="country">Country:</label><span class="text-danger">*</span>
            <select id="countryId" class="form-control select2-hidden-accessible" data-modal-type="experience" name="country_id" data-select2-id="countryId" tabindex="-1" aria-hidden="true"><option selected="selected" value="" data-select2-id="2">Select Country</option><option value="1">Afghanistan</option><option value="2">Albania</option><option value="3">Algeria</option><option value="4">American Samoa</option><option value="5">Andorra</option><option value="6">Angola</option><option value="7">Anguilla</option><option value="8">Antarctica</option><option value="9">Antigua And Barbuda</option><option value="10">Argentina</option><option value="11">Armenia</option><option value="12">Aruba</option><option value="13">Australia</option><option value="14">Austria</option><option value="15">Azerbaijan</option><option value="16">Bahamas The</option><option value="17">Bahrain</option><option value="18">Bangladesh</option><option value="19">Barbados</option><option value="20">Belarus</option><option value="21">Belgium</option><option value="22">Belize</option><option value="23">Benin</option><option value="24">Bermuda</option><option value="25">Bhutan</option><option value="26">Bolivia</option><option value="27">Bosnia and Herzegovina</option><option value="28">Botswana</option><option value="29">Bouvet Island</option><option value="30">Brazil</option><option value="31">British Indian Ocean Territory</option><option value="32">Brunei</option><option value="33">Bulgaria</option><option value="34">Burkina Faso</option><option value="35">Burundi</option><option value="36">Cambodia</option><option value="37">Cameroon</option><option value="38">Canada</option><option value="39">Cape Verde</option><option value="40">Cayman Islands</option><option value="41">Central African Republic</option><option value="42">Chad</option><option value="43">Chile</option><option value="44">China</option><option value="45">Christmas Island</option><option value="46">Cocos (Keeling) Islands</option><option value="47">Colombia</option><option value="48">Comoros</option><option value="49">Republic Of The Congo</option><option value="50">Democratic Republic Of The Congo</option><option value="51">Cook Islands</option><option value="52">Costa Rica</option><option value="53">Cote D''Ivoire (Ivory Coast)</option><option value="54">Croatia (Hrvatska)</option><option value="55">Cuba</option><option value="56">Cyprus</option><option value="57">Czech Republic</option><option value="58">Denmark</option><option value="59">Djibouti</option><option value="60">Dominica</option><option value="61">Dominican Republic</option><option value="62">East Timor</option><option value="63">Ecuador</option><option value="64">Egypt</option><option value="65">El Salvador</option><option value="66">Equatorial Guinea</option><option value="67">Eritrea</option><option value="68">Estonia</option><option value="69">Ethiopia</option><option value="70">External Territories of Australia</option><option value="71">Falkland Islands</option><option value="72">Faroe Islands</option><option value="73">Fiji Islands</option><option value="74">Finland</option><option value="75">France</option><option value="76">French Guiana</option><option value="77">French Polynesia</option><option value="78">French Southern Territories</option><option value="79">Gabon</option><option value="80">Gambia The</option><option value="81">Georgia</option><option value="82">Germany</option><option value="83">Ghana</option><option value="84">Gibraltar</option><option value="85">Greece</option><option value="86">Greenland</option><option value="87">Grenada</option><option value="88">Guadeloupe</option><option value="89">Guam</option><option value="90">Guatemala</option><option value="91">Guernsey and Alderney</option><option value="92">Guinea</option><option value="93">Guinea-Bissau</option><option value="94">Guyana</option><option value="95">Haiti</option><option value="96">Heard and McDonald Islands</option><option value="97">Honduras</option><option value="98">Hong Kong S.A.R.</option><option value="99">Hungary</option><option value="100">Iceland</option><option value="101">India</option><option value="102">Indonesia</option><option value="103">Iran</option><option value="104">Iraq</option><option value="105">Ireland</option><option value="106">Israel</option><option value="107">Italy</option><option value="108">Jamaica</option><option value="109">Japan</option><option value="110">Jersey</option><option value="111">Jordan</option><option value="112">Kazakhstan</option><option value="113">Kenya</option><option value="114">Kiribati</option><option value="115">Korea North</option><option value="116">Korea South</option><option value="117">Kuwait</option><option value="118">Kyrgyzstan</option><option value="119">Laos</option><option value="120">Latvia</option><option value="121">Lebanon</option><option value="122">Lesotho</option><option value="123">Liberia</option><option value="124">Libya</option><option value="125">Liechtenstein</option><option value="126">Lithuania</option><option value="127">Luxembourg</option><option value="128">Macau S.A.R.</option><option value="129">Macedonia</option><option value="130">Madagascar</option><option value="131">Malawi</option><option value="132">Malaysia</option><option value="133">Maldives</option><option value="134">Mali</option><option value="135">Malta</option><option value="136">Man (Isle of)</option><option value="137">Marshall Islands</option><option value="138">Martinique</option><option value="139">Mauritania</option><option value="140">Mauritius</option><option value="141">Mayotte</option><option value="142">Mexico</option><option value="143">Micronesia</option><option value="144">Moldova</option><option value="145">Monaco</option><option value="146">Mongolia</option><option value="147">Montserrat</option><option value="148">Morocco</option><option value="149">Mozambique</option><option value="150">Myanmar</option><option value="151">Namibia</option><option value="152">Nauru</option><option value="153">Nepal</option><option value="154">Netherlands Antilles</option><option value="155">Netherlands The</option><option value="156">New Caledonia</option><option value="157">New Zealand</option><option value="158">Nicaragua</option><option value="159">Niger</option><option value="160">Nigeria</option><option value="161">Niue</option><option value="162">Norfolk Island</option><option value="163">Northern Mariana Islands</option><option value="164">Norway</option><option value="165">Oman</option><option value="166">Pakistan</option><option value="167">Palau</option><option value="168">Palestinian Territory Occupied</option><option value="169">Panama</option><option value="170">Papua new Guinea</option><option value="171">Paraguay</option><option value="172">Peru</option><option value="173">Philippines</option><option value="174">Pitcairn Island</option><option value="175">Poland</option><option value="176">Portugal</option><option value="177">Puerto Rico</option><option value="178">Qatar</option><option value="179">Reunion</option><option value="180">Romania</option><option value="181">Russia</option><option value="182">Rwanda</option><option value="183">Saint Helena</option><option value="184">Saint Kitts And Nevis</option><option value="185">Saint Lucia</option><option value="186">Saint Pierre and Miquelon</option><option value="187">Saint Vincent And The Grenadines</option><option value="188">Samoa</option><option value="189">San Marino</option><option value="190">Sao Tome and Principe</option><option value="191">Saudi Arabia</option><option value="192">Senegal</option><option value="193">Serbia</option><option value="194">Seychelles</option><option value="195">Sierra Leone</option><option value="196">Singapore</option><option value="197">Slovakia</option><option value="198">Slovenia</option><option value="199">Smaller Territories of the UK</option><option value="200">Solomon Islands</option><option value="201">Somalia</option><option value="202">South Africa</option><option value="203">South Georgia</option><option value="204">South Sudan</option><option value="205">Spain</option><option value="206">Sri Lanka</option><option value="207">Sudan</option><option value="208">Suriname</option><option value="209">Svalbard And Jan Mayen Islands</option><option value="210">Swaziland</option><option value="211">Sweden</option><option value="212">Switzerland</option><option value="213">Syria</option><option value="214">Taiwan</option><option value="215">Tajikistan</option><option value="216">Tanzania</option><option value="217">Thailand</option><option value="218">Togo</option><option value="219">Tokelau</option><option value="220">Tonga</option><option value="221">Trinidad And Tobago</option><option value="222">Tunisia</option><option value="223">Turkey</option><option value="224">Turkmenistan</option><option value="225">Turks And Caicos Islands</option><option value="226">Tuvalu</option><option value="227">Uganda</option><option value="228">Ukraine</option><option value="229">United Arab Emirates</option><option value="230">United Kingdom</option><option value="231">United States</option><option value="232">United States Minor Outlying Islands</option><option value="233">Uruguay</option><option value="234">Uzbekistan</option><option value="235">Vanuatu</option><option value="236">Vatican City State (Holy See)</option><option value="237">Venezuela</option><option value="238">Vietnam</option><option value="239">Virgin Islands (British)</option><option value="240">Virgin Islands (US)</option><option value="241">Wallis And Futuna Islands</option><option value="242">Western Sahara</option><option value="243">Yemen</option><option value="244">Yugoslavia</option><option value="245">Zambia</option><option value="246">Zimbabwe</option></select><span class="select2 select2-container select2-container&#45;&#45;default" dir="ltr" data-select2-id="1" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection&#45;&#45;single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-countryId-container"><span class="select2-selection__rendered" id="select2-countryId-container" role="textbox" aria-readonly="true" title="Select Country">Select Country</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
        </div>
        <div class="form-group col-sm-6">
            <label for="state">Region:</label>
            <select id="stateId" class="form-control select2-hidden-accessible" data-modal-type="experience" name="state_id" data-select2-id="stateId" tabindex="-1" aria-hidden="true"><option selected="selected" value="" data-select2-id="20">Select Region</option></select><span class="select2 select2-container select2-container&#45;&#45;default" dir="ltr" data-select2-id="19" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection&#45;&#45;single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-stateId-container"><span class="select2-selection__rendered" id="select2-stateId-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select Region</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
        </div>
        <div class="form-group col-sm-6">
            <label for="city">City:</label>
            <select id="cityId" class="form-control select2-hidden-accessible" name="city_id" data-select2-id="cityId" tabindex="-1" aria-hidden="true"><option selected="selected" value="" data-select2-id="22">Select City</option></select><span class="select2 select2-container select2-container&#45;&#45;default" dir="ltr" data-select2-id="21" style="width: 100%;"><span class="selection"><span class="select2-selection select2-selection&#45;&#45;single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-cityId-container"><span class="select2-selection__rendered" id="select2-cityId-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select City</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
        </div>
        <div class="form-group col-sm-6">
            <label for="start_date">Start Date:</label><span class="text-danger">*</span>
            <input class="form-control" id="startDate" autocomplete="off" required="" name="start_date" type="text">
        </div>
        <div class="form-group col-sm-6">
            <label for="end_date">End Date:</label>
            <input class="form-control" id="endDate" autocomplete="off" name="end_date" type="text">
        </div>
        <div class="form-group col-sm-6 mb-0 pt-3">
            <label>Currently currently_working</label>
            <div class="col-6 pl-0">
                <label class="custom-switch pl-0">
                    <input type="checkbox" name="currently_currently_working" class="custom-switch-input" value="1" id="default">
                    <span class="custom-switch-indicator"></span>
                </label>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label for="notes">Achievements:</label>
            <div class="ql-toolbar ql-snow"><span class="ql-formats"><span class="ql-header ql-picker"><span class="ql-picker-label" tabindex="0" role="button" aria-expanded="false" aria-controls="ql-picker-options-0"><svg viewBox="0 0 18 18"> <polygon class="ql-stroke" points="7 11 9 13 11 11 7 11"></polygon> <polygon class="ql-stroke" points="7 7 9 5 11 7 7 7"></polygon> </svg></span><span class="ql-picker-options" aria-hidden="true" tabindex="-1" id="ql-picker-options-0"><span tabindex="0" role="button" class="ql-picker-item" data-value="1"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="2"></span><span tabindex="0" role="button" class="ql-picker-item" data-value="3"></span><span tabindex="0" role="button" class="ql-picker-item ql-selected"></span></span></span><select class="ql-header" style="display: none;"><option value="1"></option><option value="2"></option><option value="3"></option><option selected="selected"></option></select></span><span class="ql-formats"><button type="button" class="ql-bold"><svg viewBox="0 0 18 18"> <path class="ql-stroke" d="M5,4H9.5A2.5,2.5,0,0,1,12,6.5v0A2.5,2.5,0,0,1,9.5,9H5A0,0,0,0,1,5,9V4A0,0,0,0,1,5,4Z"></path> <path class="ql-stroke" d="M5,9h5.5A2.5,2.5,0,0,1,13,11.5v0A2.5,2.5,0,0,1,10.5,14H5a0,0,0,0,1,0,0V9A0,0,0,0,1,5,9Z"></path> </svg></button><button type="button" class="ql-italic"><svg viewBox="0 0 18 18"> <line class="ql-stroke" x1="7" x2="13" y1="4" y2="4"></line> <line class="ql-stroke" x1="5" x2="11" y1="14" y2="14"></line> <line class="ql-stroke" x1="8" x2="10" y1="14" y2="4"></line> </svg></button><button type="button" class="ql-underline"><svg viewBox="0 0 18 18"> <path class="ql-stroke" d="M5,3V9a4.012,4.012,0,0,0,4,4H9a4.012,4.012,0,0,0,4-4V3"></path> <rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="12" x="3" y="15"></rect> </svg></button><button type="button" class="ql-link"><svg viewBox="0 0 18 18"> <line class="ql-stroke" x1="7" x2="11" y1="7" y2="11"></line> <path class="ql-even ql-stroke" d="M8.9,4.577a3.476,3.476,0,0,1,.36,4.679A3.476,3.476,0,0,1,4.577,8.9C3.185,7.5,2.035,6.4,4.217,4.217S7.5,3.185,8.9,4.577Z"></path> <path class="ql-even ql-stroke" d="M13.423,9.1a3.476,3.476,0,0,0-4.679-.36,3.476,3.476,0,0,0,.36,4.679c1.392,1.392,2.5,2.542,4.679.36S14.815,10.5,13.423,9.1Z"></path> </svg></button></span><span class="ql-formats"><button type="button" class="ql-list" value="ordered"><svg viewBox="0 0 18 18"> <line class="ql-stroke" x1="7" x2="15" y1="4" y2="4"></line> <line class="ql-stroke" x1="7" x2="15" y1="9" y2="9"></line> <line class="ql-stroke" x1="7" x2="15" y1="14" y2="14"></line> <line class="ql-stroke ql-thin" x1="2.5" x2="4.5" y1="5.5" y2="5.5"></line> <path class="ql-fill" d="M3.5,6A0.5,0.5,0,0,1,3,5.5V3.085l-0.276.138A0.5,0.5,0,0,1,2.053,3c-0.124-.247-0.023-0.324.224-0.447l1-.5A0.5,0.5,0,0,1,4,2.5v3A0.5,0.5,0,0,1,3.5,6Z"></path> <path class="ql-stroke ql-thin" d="M4.5,10.5h-2c0-.234,1.85-1.076,1.85-2.234A0.959,0.959,0,0,0,2.5,8.156"></path> <path class="ql-stroke ql-thin" d="M2.5,14.846a0.959,0.959,0,0,0,1.85-.109A0.7,0.7,0,0,0,3.75,14a0.688,0.688,0,0,0,.6-0.736,0.959,0.959,0,0,0-1.85-.109"></path> </svg></button><button type="button" class="ql-list" value="bullet"><svg viewBox="0 0 18 18"> <line class="ql-stroke" x1="6" x2="15" y1="4" y2="4"></line> <line class="ql-stroke" x1="6" x2="15" y1="9" y2="9"></line> <line class="ql-stroke" x1="6" x2="15" y1="14" y2="14"></line> <line class="ql-stroke" x1="3" x2="3" y1="4" y2="4"></line> <line class="ql-stroke" x1="3" x2="3" y1="9" y2="9"></line> <line class="ql-stroke" x1="3" x2="3" y1="14" y2="14"></line> </svg></button></span><span class="ql-formats"><button type="button" class="ql-clean"><svg class="" viewBox="0 0 18 18"> <line class="ql-stroke" x1="5" x2="13" y1="3" y2="3"></line> <line class="ql-stroke" x1="6" x2="9.35" y1="12" y2="3"></line> <line class="ql-stroke" x1="11" x2="15" y1="11" y2="15"></line> <line class="ql-stroke" x1="15" x2="11" y1="11" y2="15"></line> <rect class="ql-fill" height="1" rx="0.5" ry="0.5" width="7" x="2" y="14"></rect> </svg></button></span></div><div id="addExperienceAchievement" class="mb-3 ql-container ql-snow"><div class="ql-editor ql-blank" data-gramm="false" contenteditable="true" data-placeholder="Type your achievements here"><p><br></p></div><div class="ql-clipboard" contenteditable="true" tabindex="-1"></div><div class="ql-tooltip ql-hidden"><a class="ql-preview" target="_blank" href="about:blank"></a><input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL"><a class="ql-action"></a><a class="ql-remove"></a></div></div>

        </div>
        <div class="form-group col-sm-12">

            <input id="addExperienceAchievementOriginal" class="form-control textarea-sizing" rows="5" name="description" type="hidden">
            <textarea name="" class="invisible" id="" cols="30" rows="2"></textarea>
        </div>
    </div>-->
</template>

<script>
    import axios from 'axios';
    import Loader from "@/Custom/Loader";
    import ActionMessage from "@/Jetstream/ActionMessage";
    import Swal from 'sweetalert2'

    export default {
        name: "EditExperience",
        props: {
            countries: {
                type: Object
            },
            industries: {
                type: Object
            },
            experiences: {
                type: Object
            },
            candidate_id: {
                type: Number
            }
        },
        components: {
            Loader, ActionMessage
        },
        mounted(){
            //console.log($page.props.)

        },
        data(){
            return {
                allow_add: true,
                /*experiences: [
                    {
                        title: 'Accountant',
                        company: 'Sr Financial Consultants',
                        start_date: '2020',
                        end_date: '2021',
                        currently_working: true,
                        description: "worked as the manager of the firm",
                        editing: false,
                        old: {}
                    },
                    {
                        title: 'Accountant',
                        company: 'Sr Financial Consultants',
                        start_date: '2020',
                        end_date: '2021',
                        currently_working: false,
                        description: "worked as the manager of the firm",
                        editing: true,
                        old: {}
                    },
                ]*/
            }
        },
        methods: {
            remove(index){
                // perform database removal
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',

                }).then((result) => {
                    //Swal.showLoading();
                    if (result.isConfirmed) {
                        if(this.experiences[index].id){
                            //alert('this is an already saved experience')
                            axios.delete(route('delete.candidate.data', ['experience', this.experiences[index].id])).then((result) => {
                                if(result.data){
                                    // remove the experience from the list
                                    this.experiences.splice(index, 1)
                                }
                            }).catch((error) => {
                                console.log(error.response.data)
                            })
                        }
                        //this.experiences.splice(index, 1)
                        /*Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )*/
                    }
                })


            },
            currently_workingControl(index){
                this.experiences[index].currently_working = !this.experiences[index].currently_working;
            },
            allowAddControl(){
                let editing = 0;
                for(let x = 0; x < this.experiences.length; x++){
                    if(this.experiences[x].editing){
                        editing += 1;
                    }
                }
                this.allow_add = editing;
            },
            cancelEdit(index){
                this.experiences[index].editing = false;
                this.experiences[index] = this.experiences[index].old;
                if(!this.experiences[index].old){
                    this.experiences.splice(index, 1);
                }
                this.allow_add = true;
            },
            editExperience(index){
                this.experiences[index].editing = true;
                this.experiences[index].old = this.experiences[index];
            },
            newExperience(){
                let newExp = {
                    title: '',
                    company: '',
                    start_date: '',
                    end_date: '',
                    currently_working: false,
                    country_id: '',
                    industry_id: '',
                    candidate_id: this.candidate_id,
                    description: "",
                    editing: true,
                    saving: false,
                    old: {}
                };
                this.allow_add = false;
                console.log(newExp);
                this.experiences.push(newExp);
            },
            addExperience(index){
                this.experiences[index].saving = true;
                this.experiences[index].old = [];
                axios.post(route('save.candidate.data', 'experience'), {
                    data: this.experiences[index]
                }).then((result) => {
                    console.log(result.data);
                    if(result.data){
                        this.experiences[index].editing = false;
                        this.experiences[index].saving = false;
                        if(result.data.id){
                            this.experiences[index].id = result.data.id;
                            this.experiences[index].saving = false;
                            this.allow_add = true;
                        }
                    }
                }).catch((error) => {
                    console.log(error.response.data)
                })
            }
        }
    }
</script>

<style scoped>

</style>
