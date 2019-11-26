<template>
        <div class="row justify-content-center p-3">
            <div class="w-100">
                <div class="card">
                    <div class="card-header">Create Item</div>
                <form @submit.prevent="createMode? storedata() :updateProduct()">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="mb-3">
                                    <label v-show="!createMode" class="label" >Please enter item name:</label>
                                        <input type="text" v-model="form.item" class="form-control" placeholder="Please enter item name" :class="{ 'is-invalid': form.errors.has('item') }">
                                        <has-error :form="form" field="item"></has-error>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <label v-show="!createMode" class="label" >Quantity:</label>
                                        <input type="number" v-model="form.quantity" class="form-control" placeholder="Quantity" :class="{ 'is-invalid': form.errors.has('quantity') }">
                                        <has-error :form="form" field="quantity"></has-error>
                                    </div> 
                                    <div class="col-md-4">
                                        <label v-show="!createMode" class="label" >Supplier Price:</label>
                                        <input type="number" v-model="form.supplier" class="form-control" placeholder="Supplier Price" :class="{ 'is-invalid': form.errors.has('supplier') }">
                                        <has-error :form="form" field="supplier"></has-error>
                                    </div> 
                                    <div class="col-md-4">
                                        <label v-show="!createMode" class="label" >Price:</label>
                                        <input type="number" v-model="form.price" class="form-control" placeholder="Price" :class="{ 'is-invalid': form.errors.has('price') }">
                                        <has-error :form="form" field="price"></has-error>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="w-100 choose_file">
                                        <button type="button" class="btn btn-info form-control">Choose Image</button>
                                        <input type="file" name="img" accept="image/*" v.form="photo" @change="uploadImage">    
                                    </div>
                                </div>

                                <div class="row p-3">
                                    <div class="w-100">
                                        <button class="btn btn-success form-control" >{{ (!createMode)? "Update":"Create"}}  Item</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 text-center ">
                                <img class="w-75 mt-3" :src="url == null ? '/img/picture.png' : url" alt="" srcset="">   
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
   
</template>

<script>
    export default {
        data(){
            return{
                url:null,
                createMode: true,
                productId: this.$route.params.id,
                form: new Form({
                    item:'',
                    supplier:'',
                    price:'',
                    quantity:'',
                    photo:"",
                    box:"",
                    type:1
                })
            }
        },
        methods:{
            uploadImage(e){
                let file = e.target.files[0];
                this.url = URL.createObjectURL(file);
                let reader = new FileReader();
                reader.onloadend = (file) => {
                    this.form.photo = reader.result;
                }
                reader.readAsDataURL(file);
            },
            storedata(){
                
                this.form.post('api/product')
                .then(({data})=>{
                    this.$toastr.s(`${this.form.item} has been added`, "Success");
                    this.$router.push("product");
                })
                .catch(() => {

                });
            },

            fetchProductById(){
                
                axios.get('/api/product/'+this.productId)
                .then(({data}) => {
                    this.form.fill(data)
                    if(data.photo == "picture.png"){
                        this.url = '/img/'+data.photo;
                    }else{
                        this.url = '/img/product/'+data.photo;
                    }
                    
                });
            },

            updateProduct(){
                this.form.put('/api/product/'+this.productId)
                .then(({data}) => {
                    this.$toastr.s('Successfully Updated','Success');
                    this.$router.push('/product');
                })
               
            }
        },
        mounted() {
            
            if(this.$route.params.id){
                this.createMode = false;
                this.fetchProductById();
            }else{
                this.createMode = true;
            }
        }
    }
</script>
