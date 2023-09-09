<template>
    <div>
        <button v-if="job.promotion" class="rounded-md bg-black px-2 text-white"
            @click="promote_modal = true; getPromotionInsights()"><small>Insights</small></button>
        <button v-else class="rounded-md bg-green-400 px-2 text-white"
            @click="promote_modal = true"><small>Promote</small></button>

        <dialog-modal :show="promote_modal" :closeable="true" :max-width="'3xl'">
            <template v-slot:title>
                <div class="flex flex-row">
                    <span class="flex-grow text-gray-500 font-bold">Promote Job {{ job.title }}</span>
                    <button @click="promote_modal = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>

            <template v-slot:content>
                <div class="text-gray-600">
                    <section class="flex" v-if="loading">
                        <span class="flex-grow"></span>
                        <loader color="green" class="text-center"></loader>
                    </section>
                    <section class="flex flex-col animate__animated animate__slideInRight" v-if="alter_budget">
                        <section class="flex space-x-2">
                            <span class="flex-grow" :id="'stat_activate_'+job.promotion.PromotionID"></span>
                            <span class="self-center">Promotion Status</span>
                            <dropdown width="48" class="md:block float-right">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button"
                                            :class="'p-1 rounded-md border border-' + statusColor(current_status) + ' text-' + statusColor(current_status)">
                                            <section class="flex flex-row">
                                                <span v-if="!updating_status">{{ current_status }}</span>
                                                <loader v-else color="green"></loader>

                                                <svg class="ml-2 -mr-0.5 h-4 w-4 self-center"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </section>
                                            <!-- <Loader v-else :color="current_color" css_class="p-1"></Loader> -->
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <dropdown-link as="button" v-for="(stat, index) in status" @click="changeStatus(stat)">
                                        {{ stat }}
                                    </dropdown-link>
                                </template>
                            </dropdown>
                        </section>
                        <span>Please specify the amount you want to {{ change_budget.type }} and click confirm</span>
                        <div class="flex flex-row">
                            <select v-model="change_budget.type"
                                class="rounded-l-md focus:border-green-400 focus:ring-1 focus:ring-green-400" name="" id="">
                                <option value="increase">Increase</option>
                                <option value="decrease">Decrease</option>
                            </select>
                            <input v-model="change_budget.amount" type="number"
                                class="flex-grow rounded-r-md focus:border-green-400 focus:ring-1 focus:ring-green-400"
                                placeholder="Amount">
                        </div>
                        <span v-if="dissallowDecrease" class="text-red-500 text-sm">Please pause the promotion before
                            proceeding</span>
                        <span v-else-if="reduceAmountOverflowed" class="text-red-500">Max Reduce Amount: {{
                            insights.budget.balance }}</span>
                            <span v-if="insufficientBalance" class="text-red-500">Your current balance <strong>{{ insights.budget.ajiriwa_balance }}</strong> is not enought for that.</span>
                    </section>
                    <form v-else-if="!job.promotion" class="" @submit.prevent="submitPromotion">
                        <span class="text-gray-600">Promote <span class="text-green-500 font-bold">{{ job.title }}</span> to
                            reach
                            more people</span>
                        <div class="mb-4 pt-2">
                            <label class="block font-bold mb-2" for="budget">
                                Budget
                            </label>
                            <input v-model="budget"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                                id="budget" type="number" name="budget" required>
                            <small v-if="budget >= 1000">You will get up to <span class="font-bold text-green-500">{{
                                boostedViews }}</span> boosted job views</small>
                        </div>
                        <div class="mb-4 pt-2">
                            <p class="text-lg font-bold">Targeted Audience</p>
                            <label class="block font-bold my-2" for="gender">
                                Gender
                            </label>
                            <select v-model="gender"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                                id="gender" name="gender">
                                <option value="">Any</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="location">
                                Location
                            </label>
                            <input v-model="location"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                                id="location" type="text" name="location">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2" for="professional-title">
                                Professional Title
                            </label>
                            <input v-model="professional_title"
                                class="rounded-lg border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full py-2 px-3"
                                id="professional-title" type="text" name="professional-title">
                        </div>
                        <button :id="'submit-prom-' + job.id"
                            class="hidden bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            type="submit">
                            Submit
                        </button>
                    </form>
                    <section v-else>
                        <!-- Insights Tiles -->
                        <div class="md:grid md:grid-cols-4 gap-4">
                            <section class="col-span-4 flex">
                                <span class="flex-grow self-center hidden">
                                    <loader color="green" class="text-center"></loader>
                                </span>
                                <span class="font-weight-bold self-center flex-grow">Status:</span>
                                <dropdown width="48" class="md:block float-right">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                :class="'p-1 rounded-md border border-' + statusColor(current_status) + ' text-' + statusColor(current_status)">
                                                <section class="flex flex-row">
                                                    <span v-if="!updating_status">{{ current_status }}</span>
                                                    <loader v-else color="green"></loader>

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4 self-center"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </section>
                                                <!-- <Loader v-else :color="current_color" css_class="p-1"></Loader> -->
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <dropdown-link :ref="'stat_'.stat" as="button" v-for="(stat, index) in status"
                                            @click="changeStatus(stat)">
                                            {{ stat }}
                                        </dropdown-link>
                                    </template>
                                </dropdown>
                            </section>
                            <!-- Impression Tile -->
                            <div class="mb-1 bg-green-500 p-4 text-white text-center rounded-lg">
                                <div class="text-2xl font-bold">Impressions</div>
                                <div class="text-lg">{{ insights.impressions }}</div>
                            </div>

                            <!-- Views Tile -->
                            <div class="mb-1 bg-gray-500 p-4 text-white text-center rounded-lg">
                                <div class="md:text-2xl font-bold">Views</div>
                                <div class="text-lg">{{ insights.views }}</div>
                            </div>

                            <!-- Clicks Tile -->
                            <div class="mb-1 bg-gray-800 p-4 text-white text-center rounded-lg">
                                <div class="text-2xl font-bold">Clicks</div>
                                <div class="text-lg">5,000</div>
                            </div>

                            <!-- Applications Tile -->
                            <div class="mb-1 bg-black p-4 text-white text-center rounded-lg">
                                <div class="text-2xl font-bold">Applications</div>
                                <div class="text-lg">{{ insights.applications }}</div>
                            </div>
                        </div>

                        <!-- Budget Bar -->
                        <div class="mt-4 flex flex-col">
                            <section class="flex">
                                <span class="flex-grow">Amount Spent on Budget</span>
                                <span @click="alter_budget = true; getPromotionInsights()"
                                    class="cursor-pointer text-green-500">Increase/Decrease Budget</span>
                            </section>
                            <div class="bg-gradient-to-r from-green-200 via-gray-500 to-gray-500 h-4 rounded-full">
                                <div :style="{ width: insights.budget.used_percent + '%' }"
                                    class="h-full bg-gradient-to-r from-green-500 to-red-500 rounded-full"></div>
                            </div>

                            <table class="table-auto border rounded-lg flex-grow">
                                <tr class="">
                                    <td><span class="font-bold">Budget</span></td>
                                    <td><span>{{ insights.budget.budget }}</span></td>
                                    <td><span class="font-bold">Spent</span></td>
                                    <td><span>{{ insights.budget.used }}</span></td>
                                    <td><span class="font-bold">Balance</span></td>
                                    <td><span>{{ insights.budget.balance }}</span></td>
                                </tr>
                            </table>
                        </div>

                        <!-- Real-time Graph -->
                        <div class="mt-4">
                            <!-- <canvas id="promotionGraph" width="400" height="200"></canvas> -->
                            <Line id="my-chart-id" :options="chartOptions" :data="chartData" />
                        </div>
                    </section>
                </div>
                <!--<text-editor></text-editor>-->
            </template>


            <template v-slot:footer>
                <div class="flex flex-row">
                    <button v-if="insufficientBalance" @click="$refs['ajiriwa_balance'][0].click()" class="hover:bg-green-400 bg-green-500 p-1 rounded-md text-white animate__animated animate__heartBeat">Recharge</button>
                    <span class="flex-grow"></span>
                    <button v-if="!job.promotion" @click="clickSubmit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                        type="submit">
                        Submit
                    </button>
                    <section v-if="alter_budget" class="flex float-right">
                        <button @click="alter_budget = false"
                            class="hover:bg-gray-400 bg-gray-500 p-2 rounded-l-md">Cancel</button>
                        <button @click="confirmChangeBudget" :disabled="dissallowDecrease || reduceAmountOverflowed || insufficientBalance || changing_budget"
                            class="disabled:cursor-not-allowed hover:bg-green-400 bg-green-500 p-2 rounded-r-md text-white">
                            <span v-if="!changing_budget">Confirm Change</span>
                            <loader v-else color="white"></loader>
                        </button>
                    </section>
                    <!-- <button @click="$refs['submit-application'].click()"  class="bg-green-500 hover:shadow-lg text-white p-2 flex flex-row">
                        <span class="flex-grow"></span>
                        hello
                        <loader v-if="currently_applying" :color="'white'"></loader>
                        <span v-else>Apply</span>
                        <span class="flex-grow"></span>
                    </button> -->
                </div>
            </template>
        </dialog-modal>
    </div>
</template>
<script>
import Dropdown from "@/Jetstream/Dropdown";
import DropdownLink from "@/Jetstream/DropdownLink";
import DialogModal from "@/Jetstream/DialogModal";
import Loader from "@/Custom/Loader";
import axios from "axios";
import iziToast from "izitoast";
import "izitoast/dist/css/iziToast.min.css";
import Swal from 'sweetalert2'
import 'animate.css';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)
export default {
    name: "Promotion",
    components: {
        DialogModal, Loader, Dropdown, DropdownLink, Line
    },
    props: {
        job: {
            type: Object,
            required: true
        }
    },
    mounted() {
        if (this.job.promotion) {
            console.log("the object has got some keys below");
            let keys = Object.keys(this.job.promotion);
            if (keys.indexOf('Status') >= 0) {
                this.current_status = this.job.promotion.Status;
            }
            //this.current_status = this.job.promotion.Status;
        }
    },
    computed: {
        insufficientBalance(){
            if(this.change_budget.amount === ""){
                return false;
            }
            return this.insights.budget.ajiriwa_balance < Number(this.change_budget.amount);
        },
        reduceAmountOverflowed() {
            if (this.change_budget.type == 'decrease') {
                if (Number(this.change_budget.amount) > Number(this.insights.budget.bal) /* Number(this.insights.budget.balance) */) {
                    return true
                }
            }
            return false;
        },
        dissallowDecrease() {
            return this.current_status == 'Active' && this.change_budget.type == 'decrease';
        },
        statusColor() {
            return status => {
                return this.status_colors[status]
            }
        },
        boostedViews() {
            if (this.budget >= this.job.promotion_details.cost_per_impression) {
                return Math.round(this.budget / (this.job.promotion_details.cost_per_impression + this.job.promotion_details.cost_per_click))
            }
            return 0;
        }
    },
    data() {
        return {
            current_status: 'Active',
            status: ['Active', 'Paused'],
            status_colors: { Active: 'green-400', Paused: 'blue-600', Finished: 'red-400' },
            alter_budget: false,
            changing_budget: false,
            change_budget: {
                type: 'increase',
                amount: '',
            },
            insights: {
                impressions: 0,
                views: 0,
                applications: 0,
                used_percent: 0,
                budget: {
                    budget: 0,
                    balance: 0,
                    used: 0,
                    used_percent: 0,
                    bal: 0,
                    ajiriwa_balance: 0,
                }
            },
            loading: false,
            updating_status: false,
            show_insights: false,
            promote_modal: false,
            budget: '',
            gender: '',
            location: '',
            professional_title: '',
            chartData: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [
                    {
                        label: 'Impressions',
                        backgroundColor: '#4ade80',
                        borderColor: '#4ade80',
                        data: [40, 39, 10, 40, 39, 80, 40]
                    },
                    {
                        label: 'Views',
                        backgroundColor: '#f43f5e',
                        borderColor: '#f43f5e',
                        data: [20, 30, 5, 42, 20, 30, 21]
                    },
                    {
                        label: 'Applications',
                        backgroundColor: '#020617',
                        borderColor: '#020617',
                        data: [10, 5, 10, 4, 12, 15, 7],
                    }
                ]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,

            }
        }
    },
    methods: {
        confirmChangeBudget() {
            this.changing_budget = true;
            /* return console.log({
                promotion_id: this.job.promotion.PromotionID,
                type: this.change_budget.type,
                amount: this.change_budget.amount,
            }); */
            axios.post(route('promotion.change.budget'),{
                promotion_id: this.job.promotion.PromotionID,
                type: this.change_budget.type,
                amount: this.change_budget.amount,
            }).then((response) => {
                if (response.data) {
                    // emit a message that the action was succesul
                    iziToast.success({title: 'Done', message: 'The change was successfull'});
                    this.changing_budget = false; // to switch back to insights view
                    this.alter_budget = false; // to stop displaying loader in the confirm change button
                    // check it the status is paused and there is still balance and ask if the user wants to resume
                    if (this.current_status != 'Active') {
                        Swal.fire({
                            title: 'Do you want resume this promotion?',
                            showDenyButton: true,
                            confirmButtonText: 'Yes',
                            confirmButtonColor: '#059669',
                            denyButtonColor: '#475569',
                            denyButtonText: `No`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.$emit('activated', this.job.id);
                                this.getPromotionInsights();
                                /* let element = document.getElementById('stat_activate_'+this.job.promotion.PromotionID);
                                console.log(element); */
                                //this.changeStatus('Active');
                            }
                        })
                    }else{
                        this.getPromotionInsights();
                    }
                }
            }).catch((error) => {
                iziToast.error({title: 'Failed', message: 'The change was not successfull'});
                console.log(error.response.data);
                this.alter_budget = false;
            })
        },
        changeStatus(status) {
            this.updating_status = true;
            axios.post(route('promotion.change.status'), {
                promotion_id: this.job.promotion.PromotionID,
                status: status
            }).then((response) => {
                if (response.data) {
                    this.current_status = status;
                    iziToast.success({title: 'Done', message: 'Promotion is now '+status});
                    this.getPromotionInsights();
                }
                this.updating_status = false;
            }).catch((error) => {
                iziToast.error({ title: "Failed", message: "Status could not be changed" });
                console.log(error.response.data);
                this.updating_status = false;
            })
        },
        getPromotionInsights() {
            if (this.job.promotion) {
                this.loading = true;
                //("fetching promotion details")
                axios.post(route('promotion.insights'), {
                    promotion_id: this.job.promotion.PromotionID
                }).then(response => {
                    if (response.data) {
                        this.insights = response.data;
                        this.chartData = response.data.statistics;
                        console.log(response.data)
                    }
                    this.show_insights = true;
                    this.loading = false;
                }).catch(error => {
                    console.log(error.response.data);
                })
            }
        },
        clickSubmit() {
            document.getElementById('submit-prom-' + this.job.id).click()
        },
        submitPromotion() {
            //alert('you are about to submit the promotion man')
            axios.post(route('promotion.submit'), {
                budget: this.budget,
                gender: this.gender,
                location: this.location,
                professional_title: this.professional_title,
                jobid: this.job.id
            }).then(response => {
                console.log('the response is below');
                console.log(response.data)
                if (response.data) {
                    // show success message that promotion is  active
                    iziToast.success({ message: "Promotion started successfully", title: "Done" });
                    // add the promotion to the job prop
                    this.job.promotion = response.data;
                    // return to the promotion insight
                    this.getPromotionInsights();
                } else if (response.data == 0) {
                    // show error message that promotion could not be started
                } else {
                    // show error message that there is insufficient balance
                    iziToast.error({ message: "Promotion could not be started due to insufficient balance", title: "failed" })
                }
            }).catch(error => {

            })
        }
    }
}
</script>