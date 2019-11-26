<template>
   <b-modal hide-footer size="lg" centered  hide-header v-model="modalProductPreview">
       <h1 class="text-uppercase">{{this.form.type}}</h1>
       <div class="row justify-content-center">
           
           <div class="col-md-6">
               <img class="img-fluid" :src="(productDetails.type == 'item')?'img/product/'+productDetails.photo:'storage/package-images/'+productDetails.photo" alt="" srcset="">
           </div>
           <div class="col-md-6">
               <div style="min-height:70px;" class="font-weight-bold">
                    {{  productDetails.item }}  
               </div>
                <div class="h5 text-success">
                    Price:<span class="font-weight-bold" style="font-size:25px;">₱{{  productDetails.price | toCurrency}}</span>
                </div>   
                <div v-show="productDetails.type == 'package'">
                    <h5>Item List</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Item</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="product in productDetails.package_details" :key="product.id">
                                <td><img class="img-fluid" :src="'img/product/'+product.products.photo" alt=""></td>
                                <td>{{product.products.item}}</td>
                                <td>
                                    <span class="text-danger font-weight-bold" v-if="product.products.quantity == 0">No Stock</span>
                                    <span v-else>{{product.quantity}}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="font-weight-bold mt-4">
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <button class="btnQuantity " @click="minusQuantity">
                                <i class="fa fa-minus p-2 "  aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="col-md-3">
                             <input type="text" v-model="form.quantity" class="form-control text-center font-weight-bold">
                        </div>
                        <div class="col-md-2">
                            <button class="btnQuantity float-right " @click="addQuantity">
                                <i class="fa fa-plus p-2 "  aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="col-md-4">
                            {{notes}}
                        </div>
                    </div>
                </div> 
                
                <div v-show="checkStock" class="h5 font-italic text-info mt-4">
                    No Stock
                </div>
           </div>
       </div>
       <div class="w-100 mt-2">
            <button class="btn btn-success float-right" @click="addToCart">Add to Cart</button>
            <button class="btn btn-primary float-right mr-2" @click="modalProductPreview = false">Cancel</button>
        </div>
   </b-modal>
</template>

<script>
    export default {
        data(){
            return {
                modalProductPreview: false,
                checkStock:false,
                productDetails:{},
                maxQuantity:0,
                form:new Form({
                    customer_id:0,
                    product_id:0,
                    quantity:1,
                    price:0,
                }),
                packageItemQuantity:[],
                notes:"",
            }
        },
        methods:{
            openModal(id,customerID, type){
                this.notes = "";
                this.form.customer_id = customerID;
                this.form.quantity = 1;
                this.form.product_id = id;
                this.form.type = type;
                axios.get('api/product/'+id)
                .then(({data}) => {
                
                        this.modalProductPreview = true;
                        this.form.price = data.total_price;
                        this.productDetails = data;
                    
                   
                    if(data.quantity == 0){
                        this.checkStock = true;
                        this.form.quantity = 0;
                    }else{
                        this.checkStock = false;
                    }

                    if(data.type == "item"){
                        this.maxQuantity = data.quantity;
                    }else{
                        data.package_details.forEach(element => {
                            this.packageItemQuantity.push(
                                element.products.quantity,
                            );
                        });
                        this.maxQuantity = Math.min.apply(Math, this.packageItemQuantity);
                        if(this.maxQuantity == 0){
                            this.form.quantity = 0;
                        }
                    }
                });
            },

            addQuantity(){
                if(this.form.quantity != this.maxQuantity){
                     
                    this.form.quantity++;
                    if(this.form.quantity == this.maxQuantity){
                        this.notes = "Only left Stock";
                    }else{
                        this.notes = "";
                    }
                   
                }
            },

            minusQuantity(){
                if(this.form.quantity != 1 && this.form.quantity !=0){
                    this.form.quantity--;
                    this.notes = "";
                }
            },

            addToCart(){
                this.notes = "";
                if(this.form.customer_id == 0){
                    this.$toastr.e("Please select Customer","Invalid Customer");
                }else{
                    if(this.maxQuantity == 0){
                        this.$toastr.e('No Stock for this Item','Error');
                    }else if(this.form.quantity > this.maxQuantity){
                        this.$toastr.e("Only "+this.maxQuantity+" item left");
                    }else{
                        this.form.post('api/addtocart')
                        .then(({data}) => {
                            console.log(data)
                            this.$emit('successCart');
                            this.modalProductPreview = false;
                            this.$toastr.s("Add to Cart Successfully","Success");
                        })
                    }
                }
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
