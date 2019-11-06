<template>
  
    <div class="card">
        <div class="card-header" style="position:relative">New Order 
           
                <span  @click="cartPreview" v-if="cartQuantity != 0" class="badge badge-primary float-right" style="position:absolute;right:35px;top:25px;cursor:pointer">{{cartQuantity}}</span>
                <i style="cursor:pointer" @click="cartPreview" class="fas fa-cart-plus fa-2x text-dark float-right"></i>
          
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <select name="" id="" class="form-control" v-model="customerID" @change="productCart">
                        <option :value="0" disabled hidden>Please select customer</option>
                        <option v-for="customer in customers" :key="customer.id"  :value="customer.id">{{customer.customer}}</option>
                    </select>
                </div>
            </div>
            <view-product @addToCartSuccess="productCart()"></view-product>
            <preview-cart ref="cartModal"></preview-cart>
        </div>
    </div>
           
</template>

<script>
    export default {
        data() {
            return {
                
                customers:{},
                cartQuantity:0,
                customerID: 0
            }
        },

        methods: {
            loadClient(){
                axios.get('api/customer?newOrder=orders')
                .then(({data}) => {
                    this.customers = data;
                })
            },

            productCart(){
                this.$refs.cartModal.$data.totalPrice= [];
                this.$refs.cartModal.customer_id = this.customerID;
                
               
                Fire.$emit('customerID',this.customerID)

                axios.get('api/addtocart/'+this.customerID)
                .then(({data}) => {
                    this.cartQuantity = data;
                });

                axios.post('api/customerDetails',{customer_id:this.customerID})
                .then(({data}) => {
                    this.$refs.cartModal.$data.creditLimit = data.credit;
                    this.$refs.cartModal.$data.customer = data;
                    this.$refs.cartModal.$data.balance = data.balance;
                
                });
            },

            cartPreview(){
                this.$refs.cartModal.fetchCartDetails(this.customerID);
                this.$refs.cartModal.myKarton(this.customerID);
                
            },

            viewNav(){
                $('.sidebar-mini').removeClass('sidebar-collapse');
                $('.sidebar-mini').addClass('sidebar-open');
            }
        },
        mounted() {
            this.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
                this.viewNav();
            })
            Fire.$on('createdSuccess', ()=>{
                this.productCart();
            })
            this.loadClient();
            // console.log('Component mounted.')
        }
    }
</script>
