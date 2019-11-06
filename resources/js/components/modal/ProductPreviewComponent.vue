<template>
   <b-modal hide-footer size="lg" centered  hide-header v-model="modalProductPreview">
       <h1 class="text-uppercase">{{this.form.type}}</h1>
       <div class="row justify-content-center">
           
           <div class="col-md-6">
               <img class="img-fluid" :src="(this.form.type == 'product') ? 'img/product/'+productDetails.photo : (productDetails.image == null) ? '/img/picture.png' : 'storage/package-images/'+productDetails.image" alt="">
           </div>
           <div class="col-md-6">
               <div style="min-height:70px;" class="font-weight-bold">
                    {{  productDetails.item }}  
               </div>
                <div class="h5 text-success">
                    ₱{{  productDetails.price }}
                </div>           
                <div class="font-weight-bold mt-4">
                    <button class="btnQuantity" @click="minusQuantity">
                        <i class="fa fa-minus p-2 "  aria-hidden="true"></i>
                    </button>
                   <span class="ml-4 mr-4 h5">{{form.quantity}}</span>
                    <button class="btnQuantity" @click="addQuantity">
                        <i class="fa fa-plus p-2 "  aria-hidden="true"></i>
                    </button>
                </div> 
                <div v-show="checkStock" class="h5 font-italic text-info mt-4">
                    No Stock
                </div>
           </div>
       </div>
       <div class="w-100 mt-2">
            <button class="btn btn-success float-right" @click="addToCart">Add to Cart</button>
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
                })
            }
        },
        methods:{
            openModal(id,customerID, type){
                this.form.customer_id = customerID;
                this.form.quantity = 1;
                this.form.product_id = id;
                this.form.type = type;
                axios.get('api/product/'+id)
                .then(({data}) => {
                        this.modalProductPreview = true;
                        this.form.price = data.total_price;
                        this.productDetails = data;
                        this.maxQuantity = data.quantity;
    
                    if(data.quantity == 0){
                        this.checkStock = true;
                        this.form.quantity = 0;
                    }else{
                        this.checkStock = false;
                    }
                });
            },

            addQuantity(){
                if(this.form.quantity != this.maxQuantity){
                    this.form.quantity++;
                }
            },

            minusQuantity(){
                if(this.form.quantity != 1 && this.form.quantity !=0){
                    this.form.quantity--;
                }
            },

            addToCart(){
                
                if(this.form.customer_id == 0){
                    this.$toastr.e("Please select Customer","Invalid Customer");
                }else{
                    if(this.maxQuantity == 0){
                        this.$toastr.e('No Stock for this Item','Error');
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
