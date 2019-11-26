
<template>
<div>
    <div class="text-right">
        <button class="btn btn-success" @click="print"><i class="fa fa-print" aria-hidden="true"></i> Print Receipt</button>
    </div>
    <div class="w-100 p-0 mt-3" id="receipt">
        <div class="test">
            <table class="m-auto" border="0">
                <tr>
                    <td style="width:120px;"></td>
                    <td rowspan="">
                        <img src="/img/sewer.png" style="width:80px;position:relative" alt="">
                    </td>
                    <td class="font-weight-bold text-center receipt" style="font-size:40px;font-family: 'Archivo Black', sans-serif !important;">
                        <u>DANHIL ENTERPRISES</u>
                    </td>
                    <td style="width:120px;"></td>
                </tr>
                
                <tr>
                    <td></td>
                    <td colspan="2" class="headerPrintText text-center" style="font-size:13px;">
                        SMART 0920-959-8858 &nbsp;&nbsp;&nbsp; SUN 0925-888-8808
                    </td>
                   <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" class="headerPrintText text-center" style="font-size:16px;">
                        TEL NOS. 8-709-1272
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" class="headerPrintText text-center" style="font-size:15px;">
                        EMAIL ID danhil_enterprises55@yahoo.com
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" class="headerPrintText text-center" style="font-size:16px;">
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
                    <td class="text-capitalize" style="border-bottom:1px solid black"></td>
                    <td >TERMS</td>
                    <td >:</td>
                    <td style="border-bottom:1px solid black">
                        {{order_details.term}}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">TIN</td>
                    <td>:</td>
                    <td style="border-bottom:1px solid black">
                        {{customer.tin}}
                    </td>
                    <td>SALESMAN</td>
                    <td>:</td>
                    <td style="border-bottom:1px solid black">
                        {{order_details.sales_man}}
                    </td>
                </tr>
                <tr>
                    <td class="font-weight-bold">ORDER BY</td>
                    <td>:</td>
                    <td class="text-capitalize" style="border-bottom:1px solid black">
                        {{customer.customer}}
                    </td>
                    <td class="font-weight-bold">EMAIL.</td>
                    <td>:</td>
                    <td style="border-bottom:1px solid black">{{customer.email}}</td>
                </tr>
            </table>
        </div> 
        <div class="mt-2">
            <table border="3px black" class="m-auto">
                <thead>
                    <tr class="text-center" style="border:2px solid black">
                        <th style="width:100px;">Quantity</th>
                        <th style="width:100px;">Unit</th>
                        <th style="width:340px;">Articles</th>
                        <th style="width:100px;">Unit Price</th>
                        <th style="width:216px;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" style="font-size:12px;border:2px solid black" v-for="order in orders" :key="order.id">
                        <!-- {{order.product.package_details}} -->
                        <td>{{order.quantity}}</td>
                        <td>{{order_details.unit}}</td>
                        <td style="width:340px;">
                            <span class="font-weight-bold">
                                {{order.product.item}}
                            </span>
                            
                            
                                <div style="border-bottom:1px solid" v-for="item in order.product.order_package_details" :key="item.id">
                                    {{item.products.item}}/{{item.quantity}} pcs
                                </div>
                            
                        </td>
                        <td>₱{{order.price | toCurrency}}</td>
                        <td>₱{{order.price * order.quantity | toCurrency}}</td>
                    </tr>
                    <tr v-show="count < 18" v-for="item in count" :key="item.id" style="border:2px solid black">
                        <td>&nbsp;</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><span class="float-right mr-5">-</span></td>
                    </tr>
                    <tr>
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr style="border:2px solid black">
                        <td colspan="4">
                            <span class="h5 font-weight-bold">DELIVER TO:</span>
                            <span class="h5 ml-2 text-capitalize">{{customer.customer}}</span>
                            <br>
                            <span class="h5 float-right">₱</span>  
                            <span class="h5 float-right mr-5">TOTAL</span>  
                        </td>
                        <td>
                            <br>
                            <span class="h5 float-right mr-5">{{order_details.price | toCurrency}}</span>
                        </td>
                        
                    </tr>
                </tbody>
            </table>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row mt-3">
                        <div class="col-6 h5 font-weight-bold text-center">
                            {{order_details.pack}}
                            <span v-show="order_details.kart_quantity != null">[{{order_details.kart_quantity}}]</span>
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
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-8">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6 p-1">
                                    <div class=" w-100 pt-2 text-center font-weight-bold" style="height:40px;border:1px solid">
                                        {{user.firstname}} {{user.lastname}}
                                    </div>
                                    <div class="w-100 text-center h5 font-weight-bold">
                                        PREPARED BY
                                    </div>
                                </div>
                                <div class="col-6 p-1">
                                    <div class="w-100" style="height:40px;border:1px solid">
                                        
                                    </div>
                                    <div class="w-100 text-center h5 font-weight-bold">
                                        CHECKED BY
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-8">
                    <div class="font-weight-bold text-center">
                        <p style="font-size:14px;"><u>COMPANY WILL NOT HONOR CASH ADVANCES OR BORROWING OF STOCKS OF OUR SALES REPRESENTATIVE</u></p>
                        <p style="line-height:5px;font-size:20px;"><u>PLEASE MAKE ALL CHECKS PAYABLE TO DANHIL ENTERPRISES</u></p>
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
               item:{},
               packageCount:0,
            }
        },
        methods:{
            loadOrderDetails(){
                var count = 18;

                axios.post('/api/orderPreview/print',{order_id:this.order_id})
                .then(({data}) => {
                    this.order_details = data.orders
                    this.orNumber = data.OR
                    this.user = data.orders.user
                    this.customer = data.orders.customer
                    this.orders = data.orders.order_details
                    this.count = count - data.orders.order_details.length
                    this.orders.forEach(element => {
                        this.packageCount = element.product.order_package_details.length;
                    });
                    this.count = this.count - this.packageCount;
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

