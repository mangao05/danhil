<template>
<div> 
    <div class="w-100 my-4" v-for="category in categories" :key="category.id">
            <h4>{{ category.name }}</h4>
        <div class="row mt-3">
            <div @click="openModalProductPreview(product.id)" v-for="product in category.product" :key="product.id" class="col-md-2 product-div p-1">
                    <div>
                        <img class="img-fluid" :src="(product.category_id == 1) ? 'img/product/'+product.photo : (product.photo == null) ? 'img/picture.png' : 'storage/package-images/'+product.photo" alt="">
                    </div>
                    <div v-if="product.item.length < 20" style="font-size:13px;font-weight:bold;height:45px;">
                        {{product.item}}
                    </div>
                    <div v-else style="font-size:13px;font-weight:bold;height:45px;">
                        {{product.item.substring(0,40)+"..."}}
                    </div>
                    <div>
                        ₱{{product.price}}
                        <span class="float-right badge badge-success p-2" style="cursor:pointer;" @click="openModalProductPreview(product.id)">Add to Cart</span>
                    </div>
                </div>
        </div>
    </div>
    <preview-product @successCart="emitSuccessCart()" :customerID="form.customerid" ref="productPreviewModal"></preview-product>
</div>

</template>

<script>
    export default {
        data(){
            return {
                categories:{},
                form: new Form({
                    customerid:0,
                    productid:0
                })
            }
        },

        methods: {
            loadProduct(){
                axios.get('api/product?listProduct=product')
                .then(({data}) => {
                    this.categories = data;
                    console.log(data)
                });
            },

            openModalProductPreview(id, type){
                if(this.form.customerid == 0){
                    this.$toastr.e("Please Select Customer First","Error");
                }else{
                    this.$refs.productPreviewModal.openModal(id,this.form.customerid)
                }
               
            },
            emitSuccessCart(){
                this.$emit('addToCartSuccess');
            }
        },

        mounted() {
            this.loadProduct();
            Fire.$on('customerID',(customerID)=>{
                this.form.customerid = customerID;
            });
            console.log('Component mounted.')
        }
    }
</script>
