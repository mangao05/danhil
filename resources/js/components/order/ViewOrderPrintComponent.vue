<template>
<div>
    <div class="text-right">
        <button class="btn btn-success" @click="print"><i class="fa fa-print" aria-hidden="true"></i> Print Receipt</button>
    </div>
    <div class="w-100 p-0" id="receipt" style="color:black !important;">
            <table class="m-auto" border="0">
                <tr>
                    <td style="width:120px;"></td>
                    <td rowspan="2">
                        <img src="/img/sewer.png" style="width:50px;" alt="">
                    </td>
                    <td class="h2 font-weight-bold text-center">
                        <u>DANHIL ENTERPRISES</u>
                    </td>
                    <td style="width:120px;"></td>
                </tr>
                
                <tr>
                    <td></td>
                    <td class="headerPrintText text-center" style="font-size:13px;">
                        SMART 0920-959-8858 &nbsp;&nbsp;&nbsp; SUN 0925-888-8808
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="headerPrintText text-center" style="font-size:16px;">
                        TEL NOS. 332-81-88
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="headerPrintText text-center" style="font-size:15px;">
                        EMAIL ID danhil_enterprises55@yahoo.com
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="headerPrintText text-center" style="font-size:16px;">
                        ORDER RECEIPT
                    </td>
                    <td class="headerPrintText">
                        NO {{orNumber}}
                    </td>
                </tr>
            </table>
        <div class="mt-4">
            <table class="m-auto font-weight-bold" border="0">
                <tr>
                    <td class="font-weight-bold" style="width:100px;">Delivered</td>
                    <td>:</td>
                    <td class="text-capitalize" style="width:320px;border-bottom:1px solid black">{{customer.customer}}</td>
                    <td class="font-weight-bold" style="width:100px;">DATE</td>
                    <td>:</td>
                    <td style="width:320px;border-bottom:1px solid black">{{new Date().toLocaleString() | moment("MMMM D, YYYY")}}</td>
                </tr>
                <tr>
                    <td class="font-weight-bold">ADDRESS</td>
                    <td>:</td>
                    <td class="text-capitalize" style="border-bottom:1px solid black">{{customer.address}}</td>
                    <td ></td>
                    <td ></td>
                    <td style="border-bottom:1px solid black"></td>
                </tr>
                <tr>
                    <td class="font-weight-bold">TIN</td>
                    <td>:</td>
                    <td style="border-bottom:1px solid black"></td>
                    <td></td>
                    <td></td>
                    <td style="border-bottom:1px solid black"></td>
                </tr>
                <tr>
                    <td class="font-weight-bold">ORDER BY</td>
                    <td>:</td>
                    <td class="text-capitalize" style="border-bottom:1px solid black">{{user.firstname+" "+user.lastname}}</td>
                    <td class="font-weight-bold">SERIAL NO.</td>
                    <td>:</td>
                    <td style="border-bottom:1px solid black">AB</td>
                </tr>
            </table>
        </div> 
        <div class="mt-2">
            <table border="1" class="m-auto">
                <thead>
                    <tr class="text-center">
                        <th style="width:100px;">Quantity</th>
                        <th style="width:100px;">Unit</th>
                        <th style="width:340px;">Articles</th>
                        <th style="width:100px;">Unit Price</th>
                        <th style="width:216px;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" style="font-size:12px" v-for="order in orders" :key="order.id">
                        <!-- {{order.product.package_details}} -->
                        <td>{{order.quantity}}</td>
                        <td></td>
                        <td style="width:340px;">
                            <span class="font-weight-bold text-uppercase" v-if="order.product.package_details.length == 0">
                                    {{order.product.item}} ( {{order.total_box}} {{ (order.total_box > 1) ? 'boxes' : 'box' }} )
                            </span>
                            <span v-else>
                                <span class="font-weight-bold text-uppercase">
                                    {{order.product.item }} ( {{order.total_box}} {{ (order.total_box > 1) ? 'boxes' : 'box' }} )
                                </span>
                                <br>
                                (
                                    <span v-for="details in order.product.package_details" :key="details.id">
                                        {{details.products.item}} / {{details.quantity}},
                                    </span>
                                )
                
                            </span>
                        </td>
                        <td>{{order.product.price}}</td>
                        <td>{{order.product.price * order.quantity}}</td>
                
                    </tr>
                    <tr v-show="count < 15" v-for="item in count" :key="item.id">
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><span class="float-right mr-5">-</span></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <span class="h5 font-weight-bold">DELIVER TO:</span>
                            <span class="h5 ml-2 text-capitalize">{{customer.customer}}</span>
                            <br>
                            <span class="h5 float-right">₱</span>  
                            <span class="h5 float-right mr-5">TOTAL</span>  
                        </td>
                        <td>
                            <br>
                            <span class="h5 float-right mr-5">{{order_details.price}}</span>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row mt-3">
                        <div class="col-6 h5 font-weight-bold text-center">
                            KARTONS[{{karton}}]
                        </div>
                        <div class="col-6  text-center" style="font-size:12px;">
                            Received the above merchandise in good order and condition
                        </div>
                        <div class="col-6 h5 font-weight-bold text-center">
                            
                        </div>
                        <div class="col-6">
                            <div class="" style="border-bottom:1px dotted black;width:415px;">
                                By:
                            </div>
                            <div class="text-center font-weight-bold">
                                <p>
                                    Authorized Signature
                                </p>
                                <p style="line-height:1px;">
                                    Print Name
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
    

</template>

<script>
import { log } from 'util';
    export default {
        data(){
            return {
               order_id: this.$route.params.id,
               user:{},
               customer:{},
               orders:{},
               count:0,
               order_details:{},
               karton:0,
               orNumber:123,  
              
            }
        },
        methods:{
            loadOrderDetails(){
                var count = 15;

                axios.post('/api/orderPreview/print',{order_id:this.order_id})
                .then(({data}) => {
                    this.karton = data.orders.total_box;
                    this.order_details = data.orders
                    this.user = data.orders.user
                    this.customer = data.orders.customer
                    this.orders = data.orders.order_details
                    this.count = count - data.orders.order_details.length
                    this.orNumber = data.OR
                    
                });
            },
         
            print(){
                this.$htmlToPaper('receipt');
            },

           

        },
        mounted() {            
            this.loadOrderDetails();
            console.log('Component mounted.')
        }
    }
</script>
