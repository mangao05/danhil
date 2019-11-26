<template>
    <div class="card">
        <div class="card-header">Customer Details</div>
        <div class="card-body">
            <div class="row">
               <div class="col-md-6">
                   <div class="row">
                       <div class="col-md-4 font-weight-bold">
                           Customer:
                       </div>
                       <div class="col-md-8">
                           {{customer.customer}}
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-4 font-weight-bold">
                           Address:
                       </div>
                       <div class="col-md-8">
                           {{customer.address}}
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-4 font-weight-bold">
                           Tin #:
                       </div>
                       <div class="col-md-8">
                           {{customer.tin}}
                       </div>
                   </div>
               </div>

               <div class="col-md-6">
                   <div class="row">
                       <div class="col-md-4 font-weight-bold">
                           Contact #:
                       </div>
                       <div class="col-md-8">
                           {{customer.contact}}
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-4 font-weight-bold">
                           Email:
                       </div>
                       <div class="col-md-8">
                           {{customer.email}}
                       </div>
                   </div>
                   <div class="row">
                       <div class="col-md-4 font-weight-bold">
                           Credit Limit:
                       </div>
                       <div class="col-md-8">
                           ₱{{customer.credit | toCurrency}}
                       </div>
                   </div>
               </div>
                <div class="mt-2 w-100">
                    <button class="btn btn-success float-right" @click="editCustomerDetails()">Edit Customer Details</button>
                </div>
            </div>
            
            <hr>
            <div class="row">
                <div class="p-3 h3 w-100">
                    Recent Order
                </div>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <!-- <th><input type="checkbox" v-model="selectAll"></th> -->
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="Object.keys(products).length<1">
                        <td colspan="4" class="text-center">No Recent Order</td>
                    </tr>
                    <tr v-else v-for="product in products" :key="product.id">
                        <!-- <td><input type="checkbox" v-model="selected" :value="product.id" number></td> -->
                        <td>{{product.product.item}}</td>
                        <td>{{product.quantity}}</td>
                        <td>{{product.price}}</td>
                    </tr>
                    <tr class="bg-info font-weight-bold">
                        <td>Total:</td><td></td><td>{{total}}</td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <div class="w-100">
                <button class="btn btn-success" @click="reorder">Reorder</button>
                <button class="btn btn-primary float-right">New Order</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['customerID'],
        data(){
            return {
                customer:{},
                products: {},
                orderid:0,
                // selected:[],
                total:0
            }
        },
        methods:{
            loadCustomerDetails(id){
                axios.get('api/customer/'+id)
                .then(({data}) => {
                    // console.log(data);
                   this.customer = data;
                });
            },

            loadRecentOrder(id){
                    axios.get('api/checkout/'+id)
                    .then(({data}) => {
                        if(data.order_details){
                            this.products = data.order_details;
                            this.orderid = data.id;
                            this.total = data.price
                        }else{
                            this.products = {};
                        }
                    }); 
            },

            reorder(){
        
                axios.post('api/reorder',{
                   order_id:this.orderid
                })
                .then(({data}) => {
                    console.log(data);
                });




                // axios.post('api/checkout',{
                //     cartID:this.selected,
                //     total:this.total
                // })
                // .then(({data}) => {
                //     console.log(data);
                // })
                // console.log(this.selected);
            },
            editCustomerDetails(event){
                this.$emit('editCustomerDetails',this.customer.id);
            }
        },
       
        // computed: {
        //     selectAll: {
        //         get: function(){
        //             return this.products ? this.selected.length == this.products.length : false;
        //         },
        //         set: function(value){
        //             var selected = [];

        //             if(value) {
        //                 this.products.forEach( function(product){
        //                     selected.push(product.id);
        //                 })
        //             }

        //             this.selected = selected;
        //         }
        //     }
        // },
        created() {
            Fire.$on('DetailsView',(data)=>{
                this.loadCustomerDetails(data);
                this.loadRecentOrder(data);
            })
            console.log('Component mounted.')
        }
    }
</script>
