
<template>
   <b-modal id="cartModal" title="Customer Cart" size="xl"  hide-footer v-model="cartPreviewModal" >
       <div class="card">
                <div class="card-header font-weight-bold">
                    <table>
                        <tr>
                            <td>Credit Limit:</td><td><span class="h4 text-success">₱{{creditLimit}}</span> </td>
                        </tr>
                        <tr>
                            <td> Balance:</td><td><span class="h4 text-info">₱{{balance}}</span> </td>
                        </tr>
                    </table>
                  
                    
                </div>
              <!-- /.card-header -->
                <div class="card-body p-0" style="overflow-x:hidden">
                    <div class="row justify-content-center mt-3" style="position:">
                        <div class="" style="position:absolute;left:380px;z-index:9999">
                            <img src="img/sewer.png" style="width:40px;" alt="" srcset="">
                        </div>
                        <div class="" style="position:absolute;right:350px;top:185px;z-index:9999">
                            NO 0000-0000
                        </div>
                        <div class="col-md-4 text-center">
                            <span class="h4 font-weight-bold">
                                <u>DANHIL ENTERPRISES</u>
                            </span>
                            <div class="font-weight-bold" style="font-size:10px;">
                                SMART 0920-959-8858 SUN 0925-888-8808
                            </div>
                            <div class="font-weight-bold" style="font-size:15px;">
                                TEL NOS.  8-709-1272
                            </div>
                            <div class="font-weight-bold" style="font-size:10px;">
                                EMAIL id danhil_enterprises55@yahoo.com
                            </div>
                            <div class="font-weight-bold" style="font-size:15px;">
                                <span>ORDER RECEIPT</span>
                            </div>
                        </div>
                        <div class="col-md-9 mt-3">
                            <table>
                                <tr>
                                    <td style="width:100px;">Delivered:</td>
                                    <td class="text-capitalize" style="width:330px;border-bottom:1px solid black">{{customer.customer}}</td>
                                    <td style="width:100px;">DATE:</td>
                                    <td style="width:330px;border-bottom:1px solid black">
                                        {{new Date().toLocaleString() | moment("MMMM D, YYYY")}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>ADDRESS:</td>
                                    <td style="width:330px;border-bottom:1px solid black">{{customer.address}}</td>
                                    <td>TERMS:</td>
                                    <td style="width:330px;border-bottom:1px solid black">
                                        <select name="" v-model="term" id="" class="form-control">
                                            <option value="" disabled hidden>Select Term</option>
                                            <option v-for="termItem in termItems" :key="termItem.id" :value="termItem.name">
                                                {{termItem.name}}
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>TIN:</td>
                                    <td style="width:330px;border-bottom:1px solid black">
                                        {{customer.tin}}
                                    </td>
                                    <td>SALESMAN</td>
                                    <td style="width:330px;border-bottom:1px solid black">
                                        <input type="text" v-model="salesMan" placeholder="Input Salesman" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>ORDER BY:</td>
                                    <td style="width:330px;border-bottom:1px solid black">
                                        {{customer.customer}}
                                    </td>
                                    <td>EMAIL:</td>
                                    <td style="width:330px;border-bottom:1px solid black">
                                        {{customer.email}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>CONTACT #:</td>
                                    <td style="width:330px;border-bottom:1px solid black">
                                        {{customer.contact}}
                                    </td>
                                </tr>
                            </table>

                            <table border="1" class="mt-4">
                                <thead>
                                    <tr class="text-center">
                                        <th style="width:100px;">Quantity</th>
                                        <th style="width:100px;">Unit</th>
                                        <th style="width:400px;">Articles</th>
                                        <th style="width:80px;">Unit Price</th>
                                        <th style="width:180px;">Amount</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-show="Object.keys(cartDetails).length == 0">
                                        <td colspan="5" class="text-center">No Item Found...</td>
                                    </tr>
                                    <tr v-for="(cartDetail, index) in cartDetails" :key="cartDetail.id" class="text-center">
                                        
                                        <td @click="editQuantityisDisable(index)">
                                            <input type="number" @mouseout="disableQuantity(index)" :ref="'inputQuantity'" class="text-center" :disabled="true" style="width:50px;" :value="cartDetail.quantity">  
                                        </td>
                                        <td>
                                            <select name="" v-model="selectedUnit" id="" class="form-control">
                                                <option value="" disabled hidden>-Unit-</option>
                                                <option v-for="unit in units" :key="unit.id" :value="unit.name">{{unit.name}}</option>
                                            </select>
                                            
                                        </td>
                                        <td style="font-size:11px;">
                                            <span class="font-weight-bold text-uppercase" v-if="cartDetail.product.package_details.length == 0">
                                                {{cartDetail.product.item}} ( {{cartDetail.total_box}} {{ (cartDetail.total_box > 1) ? 'boxes' : 'box' }} )
                                            </span>
                                            <span v-else>
                                                <span class="font-weight-bold text-uppercase">
                                                    {{cartDetail.product.item }} ( {{cartDetail.total_box}} {{ (cartDetail.total_box > 1) ? 'boxes' : 'box' }} )
                                                </span>
                                                <br>
                                                <ul>
                                                    <li v-for="details in cartDetail.product.package_details" :key="details.id">
                                                        {{details.products.item}} / {{details.quantity}},
                                                    </li>
                                                </ul>
                                
                                            </span>
                                         </td>
                                        <td>₱{{cartDetail.product.price | toCurrency}}</td>
                                        <td>
                                            <span class="float-right">₱{{cartDetail.product.price * cartDetail.quantity | toCurrency}}</span>    
                                        </td>
                                        <td><span @click="deleteItem(index,cartDetail.id)" class="badge badge-danger"><i class="fa fa-times" aria-hidden="true"></i></span></td>
                                    </tr>
                                    <tr v-show="count < 15" v-for="item in count" :key="item.id">
                                        <td>&nbsp;</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr class="" style="border-bottom:none;">
                                        <td colspan="4" class="font-weight-bold">
                                            DELIVER TO: <span class="text-capitalize">{{customer.customer}}</span> 
                                        </td>
                                        <td>
                                            <span class="float-right"></span>    
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td colspan="3" style="border-right:none;" class="font-weight-bold">
                                            <span class="float-right">TOTAL</span> 
                                        </td>
                                        <td style="border-left:none;">
                                           <span class="float-right font-weight-bold">₱</span> 
                                        </td>
                                        <td>
                                            <span class="float-right">{{total | toCurrency}}</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-6 h5 p-3">
                                    <div class="row justify-content-center">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <input v-show="selectedPack == 'Karton'" v-model="noOfKarton" type="number" placeholder="No. of Karton" class="form-control">
                                                </div>
                                                <div class="col-md-7">
                                                        <select name="" v-model="selectedPack" id="" class="form-control">
                                                            <option value="" disabled hidden>-Select here-</option>
                                                            <option v-for="pack in packs" :key="pack.id" :value="pack.name">
                                                                {{pack.name}}
                                                            </option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                                <div class="col-md-6 pt-4" style="font-size:11px;">
                                    <span>
                                        Received the above merchandise in good order and conditions
                                    </span>
                                </div>
                            </div>
                            <div class="row justify-content-end p-3">
                                <div class="col-md-6" style="border-bottom:1px dotted black;">
                                    By:
                                </div>
                            </div>
                            <div class="row justify-content-end pl-3 pr-3">
                                <div class="col-md-6 text-center font-weight-bold">
                                    <p style="line-height:5px;">
                                        Authorized Signature
                                    </p>
                                    <p>
                                        Print Name
                                    </p>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6 p-2">
                                            <div style="width:100%;height:50px;border:1px solid">

                                            </div>
                                            <div class="font-weight-bold text-center h4">
                                                PREPARED BY
                                            </div>
                                        </div>
                                        <div class="col-md-6 p-2">
                                            <div style="width:100%;height:50px;border:1px solid">

                                            </div>
                                            <div class="font-weight-bold text-center h4">
                                                CHECKED BY
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    &nbsp;
                                </div>
                            </div>
                            <div class="font-weight-bold text-center">
                                <p><u>COMPANY WILL NOT HONOR CASH ADVANCES OR BORROWING OF STOCKS OF OUR SALES REPRESENTATIVE</u></p>
                                <h4><u>PLEASE MAKE ALL CHECKS PAYABLE TO DANHIL ENTERPRISES</u></h4>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
        </div>
                <div>
                    <button @click="btnCheckOut" class="btn btn-primary float-right">Check Out</button>
                    <!-- <button @click="btnPlaceOrder" class="btn btn-success float-right mr-2">Place Order</button> -->
                </div>
            
   </b-modal>
</template>

<script>
    export default {
        data (){
            Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
            return {
                cartPreviewModal: false,
                count:0,
                cartDetails:{},
                creditLimit:0,
                customer:{},
                balance:0,
                paymentMethod:"",
                customer_id:0,
                total:0,
                currentUser:{},
                term:"",
                termItems:[
                    {
                        name:"CWO",
                    },
                    {
                        name:"COD",
                    },
                    {
                        name:"30 DAYS",
                    },
                    {
                        name:"60 DAYS",
                    },
                    {
                        name:"90 DAYS",
                    },
                    {
                        name:"120 DAYS",
                    },
                ],
                selectedUnit:"",
                units:[
                    {
                        name:"Pieces"
                    },{
                        name:"Box"
                    },
                    {
                        name:"Set"
                    }
                ],
                salesMan:"",
                selectedPack:"",
                packs:[
                    {
                        name:"Karton"
                    },
                    {
                        name:"Mixer"
                    },
                    {
                        name:"Engines"
                    },
                    {
                        name:"Set Tank"
                    },
                ],
                noOfKarton:"",
            }
        },

        methods :{
        
           fetchCartDetails(id){
               var count = 15;
               if(id != 0){
                    $('.sidebar-mini').addClass('sidebar-collapse');
                    axios.get('/api/user/'+this.$userId)
                    .then(({data}) => {
                        this.currentUser = data;
                    });
                     axios.get(`/api/addtocart/${id}?cartPreview=cart`)
                    .then(({data}) => {
                        this.cartDetails = data
                        this.count = count - data.length
                    });
                    this.cartPreviewModal = true;
                    this.grandTotal();

                    
               }else{
                   this.$toastr.e("Please Select Customer","Invalid");
               }
           },

      
          

           editQuantityisDisable(id){ 
                this.$refs.inputQuantity[id].disabled = false
           },

           disableQuantity(id){
                axios.post('api/addtocart',{
                    customer_id:this.cartDetails[id].customer_id,
                    product_id:this.cartDetails[id].product_id,
                    quantity:this.$refs.inputQuantity[id].value})
                .then(({data}) => {
                    this.fetchCartDetails(this.cartDetails[id].customer_id)
                    this.$refs.inputQuantity[id].disabled = true
                    this.myKarton();
                    
                });

           },

           deleteItem(index,id){
              
               this.$delete(this.cartDetails,index)
              
               axios.post('api/deleteItem',{id:id})
               .then(({data}) => {
                   this.grandTotal();
                   this.myKarton();
               });
           },

           btnCheckOut(){
               if(this.total != 0){
                   if(this.total > this.balance){
                       this.$toastr.e("Insufficient Balance","Error");
                   }else{
                            axios.post('api/checkout',{
                                customer_id:this.customer_id,
                                user_id:this.$userId,
                                total:this.total,
                                credit:this.creditLimit,
                                term:this.term,
                                salesMan:this.salesMan,
                                selectedUnit:this.selectedUnit,
                                selectedPack:this.selectedPack,
                                noOfKarton:this.noOfKarton,
                                cartDetails:this.cartDetails
                            })
                            .then(({data}) => {
                                this.cartPreviewModal = false;
                                this.$toastr.s('Order has been Save','Success');
                                Fire.$emit('createdSuccess');
                                console.log(data);
                            });  
              
                   }
                    
               }else{
                   this.$toastr.e('Please select Item in Cart','Error');
               }
           },

            grandTotal(){
                var total = [];

                axios.post('api/grandtotal',{
                    customer_id: this.customer_id
                })
                .then(({data}) => {
                
                   data.forEach((element) => {
                       total.push(element.quantity * element.product.price);
                   });
                    this.total = total.reduce(function(sum,num){
                        return sum+num
                    },0);
                });
            },
        },
    
        mounted() {
            
            console.log('Component mounted.')
        }
    }
</script>
