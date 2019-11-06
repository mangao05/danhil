<template>
    <div>
        <b-modal v-model="modalShow" hide-footer>
            <form @submit.prevent="storePayment">
                <div class="form-group">
                    <select name="" id="" v-model="modePayment" @change="getpayment" class="form-control">
                        <option value="" disabled hidden>Select Payment Method</option>
                        <option v-for="modePayment in modePayments" :key="modePayment.id" :value="modePayment.name">{{modePayment.name}}</option>
                    </select>
                </div>
            
            <div v-show="modePayment == 'Cash'">
                <div class="form-group">
                    <label for="value">Value</label>
                    <input type="number" class="form-control" placeholder="Enter Value" v-model="value">
                </div>
            </div>
            <div v-show="modePayment == 'Credit'">
                <div class="form-group">
                    <select name="" v-model="modeCheck" id="" class="form-control">
                        <option value="" disabled hidden>Select Check Type</option>
                        <option v-for="modeCheck in modeChecks" :key="modeCheck.id" :value="modeCheck.id">{{modeCheck.name}}</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="date">Date:</label>
                    <datepicker input-class="form-control font-weight-bold text-center" calendar-class="w-100" placeholder="Date of Check" v-model="date" format="dd MMMM yyyy"></datepicker>
                </div>
                <div class="form-group">
                    <label for="check_no">Check #</label>
                    <input type="text" class="form-control" placeholder="Enter No." v-model="check_no">
                </div>
                <div class="form-group">
                    <label for="value">Value</label>
                    <input type="number" class="form-control" placeholder="Enter Value" v-model="value">
                </div>
            </div>
            <input type="submit" class="btn btn-success form-control" value="Submit">
            </form>
        </b-modal>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                modalShow:false,
                modePayments:[

                    {
                        id:1,
                        name:"Cash"
                    },
                    {
                        id:2,
                        name:"Credit"
                    },
                     
                ],
                modeChecks:[
                    {
                        id:1,
                        name:"Post Dated Check"
                    },
                    {
                        id:2,
                        name:"Dated Check"
                    }
                ],

                modePayment:'',
                modeCheck:'',
                check_no: '',
                date: '',
                value: '',
                order_id: 0
                
            }
        },
        methods:{
            storePayment(){
                axios.post('/api/collection', {
                    payment_type    : this.modePayment,
                    check_type      : this.modeCheck,
                    check_no        : this.check_no,
                    check_date      : this.date,
                    value           : this.value,
                    order_id        : this.order_id
                }).then(data => console.log(data))
            },
            getpayment(){
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
