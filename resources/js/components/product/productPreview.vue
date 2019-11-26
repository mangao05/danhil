<template>
        <div class="row justify-content-center">
            <div class="w-100 p-3">
                <div class="card">
                    <div class="card-header">Product preview</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center p-3" style="box-shadow:0px 0px 5px gray;">
                                <img class="img-fluid" :src="photo" alt="">
                            </div>
                            <div class="col-md-9 p-3">
                                <table>
                                    <tr>
                                        <td class="viewProductLabel" >Product:</td><td><span>{{productName}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="viewProductLabel" >Supplier Price:</td><td><span>₱{{supplier | toCurrency}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="viewProductLabel">Price:</td><td><span>₱{{productprice | toCurrency}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="viewProductLabel">Quantity</td><td><span>{{productQuantity}} pcs</span></td>
                                    </tr>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        data(){
            return {
                productID: this.$route.params.id,
                productName: '',
                productprice:'',
                productQuantity:'',
                photo: '',
                supplier: '',
            }
        },
        methods:{
            fetchData(){
                axios.get('/api/product/'+this.productID)
                .then(({data}) => {
                    this.productName = data.item;
                    this.productprice = data.price;
                    this.productQuantity = data.quantity;
                    this.supplier = data.supplier;
                    if(data.photo == "picture.png"){
                        this.photo = "/img/"+data.photo;
                    }else{
                        this.photo = "/img/product/"+data.photo;
                    }
                    console.log(data.photo);
                })
            }
        },
        mounted() {
            this.fetchData();
            console.log('Component mounted.')
        }
    }
</script>
