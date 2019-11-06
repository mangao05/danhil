<template>
        <div class="row justify-content-center">
            <div class="w-100 p-3">
                <div class="card">
                    <div class="card-header">Product preview</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 p-3">
                                <table>
                                    <tr>
                                        <td style="width: 100px;" >Product:</td><td><span>{{productName}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Price:</td><td><span>{{productprice}}</span></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td><td><span>{{productQuantity}} pcs</span></td>
                                    </tr>
                                    <tr>
                                        <td>Box</td><td><span>{{karton}} pcs</span></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-8 text-center p-3" style="border:1px solid">
                                <img class="img-fluid" :src="photo" alt="">
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
                karton: '',
            }
        },
        methods:{
            fetchData(){
                axios.get('/api/product/'+this.productID)
                .then(({data}) => {
                    this.productName = data.item;
                    this.productprice = data.price;
                    this.productQuantity = data.quantity;
                    this.karton = data.box;
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
