<template>
<dialog-modal :show="show_modal" :closeable="true" :max-width="'2xl'">
    <template v-slot:title>
        <div class="flex flex-row">
            <span class="flex-grow text-gray-500 font-bold">Ajiriwa Balance</span>
            <button @click="show_modal = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>

    <template v-slot:content>
        <div class="text-gray-500">
            <section v-if="state == 'insert'">
                <span>Use your balance to get extra features</span>

                <div class="flex flex-col items-center p-4 shadow-md bg-white">
                    <h3 class="text-md text-gray-800 mt-2 font-semibold">Current Balance</h3>
                    <p class="mt-2 text-gray-700 text-sm">
                        <loader id="balance-loading" class="self-center" color="green" v-if="current_balance == '*'"></loader>
                        <span v-else>TZS {{ current_balance.toLocaleString() }}</span>
                    </p>
                </div>
                <div class="py-2">
                    <span>Recharge?</span>
                    <section class="flex">
                        <input type="number" v-model="amount" placeholder="Enter Amount in TZS" class="flex-grow border border-gray-400">
                        
                        <button :disabled="working" @click="initiatePayment" class="bg-green-400 text-white rounded-r-md p-1">
                            <loader v-if="working" :color="'white'"></loader>
                            <span v-else>Recharge</span>
                        </button>
                    </section>
                </div>

            </section>
            <section class="flex">
                <span class="flex-grow"></span>
                <loader id="gateway-loading" class="self-center" color="green" v-if="gateway_loading"></loader>
                <span class="flex-grow"></span>
            </section>
            <div ref="payment">
                
            </div>
        </div>
        <!-- <form @submit.prevent="apply">
            <apply @applied="doneApplying" @applying="applying"  :selected_certs="selected_certs" :assessments="current_assessments" :job="current_job" :ref="'apply'"></apply>
            <section class="flex flex-col py-2">
                <span class="font-bold">Attachments</span>
                <v-select :options="certificates" v-model="selected_certs" multiple></v-select>
            </section>
            <div v-if="current_assessments.length">
                <assessment-render @changed="questionAnswered" v-for="question in current_assessments" :question="question"></assessment-render>
            </div>
            <button type="submit" class="hidden" ref="submit-application">send</button>
        </form> -->
        <!--<text-editor></text-editor>-->
    </template>
    <template v-slot:footer>
        <div class="flex flex-row">
            <span class="flex-grow"></span>
            <!-- <button @click="$refs['submit-application'].click()" :disabled="currently_applying" class="bg-green-500 hover:shadow-lg text-white p-2 flex flex-row">
                <span class="flex-grow"></span>
                <loader v-if="currently_applying" :color="'white'"></loader>
                <span v-else>Apply</span>
                <span class="flex-grow"></span>
            </button> -->
        </div>
    </template>
</dialog-modal>
</template>
<script>
    import DialogModal from "@/Jetstream/DialogModal";
    import Loader from "@/Custom/Loader";
    import Swal from "sweetalert2";
import iziToast from "izitoast";
    export default {
        name: "TextEditor",
        components: {
            DialogModal, Loader
        },
        mounted(){
            //alert(window.location);
            if(this.recharge_amount){
                this.amount = this.recharge_amount;
            }
            this.checkBalance();
            this.$nextTick(function () {
            window.setInterval(() => {
                this.paymentStatus();
            },10000);
        })
        }, 
        props: {
           show_modal: {
                type: Boolean,
           },
           recharge_amount: {
                type: Number,
                required: false
           }
        },
        data() {
          return {
              amount: '',
              working: false,
              state: 'insert', // insert or pay,
              gateway_loading: false,
              current_balance: '*',
              payment_tracking_id: '',
              payment_complete: null,
              payment_status: null,
              payment_status_checking: false,
          }
        },
        methods: {
            changing(){
                /*let converter = new QuillDeltaToHtmlConverter(this.content.ops, {});
                let html = converter.convert();*/
                this.$emit('change', this.content);
            },
            checkBalance(){
                axios.post(route('current.balance')).then(response => {
                    this.current_balance = response.data;
                }); 
            },
            initiatePayment(){
                if(Number(this.amount) >= 1000){
                    this.working = true;
                    //return alert("initiating payment of "+this.amount);
                    axios.post(route('payment.init'), {
                        amount: this.amount,
                        from_url: window.location.href,
                    }).then((response) => {
                        console.log(response.data);
                        this.state = "pay";
                        this.$refs['payment'].innerHTML = response.data.iframe;
                        this.payment_tracking_id = response.data.order_tracking_id;
                        this.gateway_loading = true;
                    }).catch((error) => {
                        console.log(error.response.data);
                    });
                }else{
                    Swal.fire({title: "Error", text: "Recharge amount should be at least 1000", icon: "error"});
                }
                
            },
            paymentStatus(){
                if(this.payment_tracking_id && !this.payment_complete && !this.payment_status_checking && this.working){
                    this.payment_status_checking = true;
                    axios.post(route('payment.status'), {
                        tracking_id: this.payment_tracking_id
                    }).then((response) => {
                        // Emit the message that payment is complete
                        let status = response.data.payment_status_description;
                        if(status.toLowerCase() == 'completed'){
                            iziToast.success({title:'Paid', message: "Payment is successful"});
                            this.payment_complete = true;
                            this.$refs['payment'].innerHTML = '';
                            this.gateway_loading = false;
                            this.state = 'insert';
                            this.working = false;
                            this.checkBalance();
                        }else if(status.toLowerCase() === 'invalid'){
                            iziToast.error({title: 'Cancelled', message: 'Payment has been cancelled'});
                            this.$refs['payment'].innerHTML = '';
                            this.gateway_loading = false;
                            this.state = 'insert';
                            this.working = false;
                        }
                        console.log(response.data);
                        this.payment_status_checking = false;
                    }).error((error) => {
                        console.log(error.response.data);
                        this.payment_status_checking = false;
                        this.working = false;
                    });
                }
            }
        }
    }
</script>