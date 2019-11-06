<template>
<div class="card">
    <div class="card-header">Add Package Component</div>
<form @submit.prevent="savePackage()">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row mb-5">
                    <div class="col-md-12 pl-3 mb-3">
                        <input type="text" class="form-control" v-model="form.package_name" placeholder="Package Name"
                        :class="{ 'is-invalid': form.errors.has('package_name') }">
                        <has-error :form="form" field="package_name"></has-error>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" :readonly="(form.listItems.length == 0)?true:false" @keyup="discount" placeholder="Discount" id="" v-model="form.discount">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <input type="number" readonly class="form-control" placeholder="Price" :value="form.total_price">
                    </div>
                   
                </div>
                <div class="m-1 p-3" style="border:1px solid gray">
                    <div class="w-100 h5 font-weight-bold">
                        Add-ons
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <select name="" v-model="item" id="" class="form-control">
                                <option value="" disabled hidden>Select Item</option>
                                <option v-for="(sampleProduct, index) in sampleProducts" :key="sampleProduct.id" :value="{
                                    id : sampleProduct.id,
                                    name: sampleProduct.item,
                                    price: sampleProduct.price,
                                    box: sampleProduct.box,
                                    index : index
                                } 
                                ">
                                    {{sampleProduct.item}}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">  
                            <input type="number" v-model="itemQuantity" class="form-control" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="mt-2">
                        <button @click="addons" type="button" class="btn btn-success form-control">Add Item</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="w-50 m-auto">
                    <img class="img-fluid" :src="form.imageData" alt="">
                </div>
                 <div class="file-upload-form text-center py-3">
                    <input type="file" ref="mainImage" @change="previewImage" accept="image/*" class="form-control" hidden>

                    <button type = "button" class="btn btn-success rounded-0 btn-upload w-50" @click="uploadMain"> <i class="fas fa-cloud-upload-alt" aria-hidden="true"></i> Upload Main Image</button>

                </div>

            </div>
        </div>
        <div class=" w-100 mt-3">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item name</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="Object.keys(this.form.listItems).length == 0">
                        <td colspan="3" class="text-center">No Item...</td>
                    </tr>
                    <tr v-else v-for="(listItem, index) in this.form.listItems" :key="listItem.id">
                        <td>{{listItem.name}}</td>
                        <td>{{listItem.quantity}}</td>
                        <td>
                            <span @click="removeItem(index)" class="badge badge-danger p-2">Remove</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <button class="btn btn-primary float-right">Save Package</button>
        </div>
    </div>
</form>
</div>
</template>

<script>
    export default {
        data(){
            return {
                sampleProducts:{},
                item:"",
                itemQuantity:"",
               
                form: new Form({
                    total_price:"",
                    listItems:[],
                    package_name:"",
                    discount:"",
                    quantity:0,
                    imageData: 'img/picture.png',
                    type : 2
                }),
                percentage:0,
                discountPrice:0,
            }
        },
        methods:{
            removeItem(index){
                console.log(this.form.listItems[index]);
                 this.sampleProducts.push({
                    id: this.form.listItems[index].id,
                    item: this.form.listItems[index].name,
                    price : this.form.listItems[index].price,
                    quantity : this.form.listItems[index].quantity,
                    box : this.form.listItems[index].box
                });
                this.form.total_price = this.form.total_price - this.form.listItems[index].price * this.form.listItems[index].quantity;
                this.$delete(this.form.listItems,index);
                if(this.form.total_price <= 0){
                    this.form.total_price = "";
                }
               
                
            },
               previewImage: function(event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                     if(!input.files[0].type.match('image.*')){
                        this.$toastr.e(`${input.files[0].name} is not an image`);
                    }else{
                        var reader = new FileReader();
                        reader.onload = (e) => {
                            this.form.imageData = e.target.result;
                        }
                        reader.readAsDataURL(input.files[0]);

                    }
                }
            },
            uploadMain(){
                this.$refs.mainImage.click();
            },
            discount(){
                var total = [];
                

                this.form.listItems.forEach((element)=>{
                    total.push(element.price * element.quantity)
                    
                })

                this.form.total_price = total.reduce(function(sum,num){
                        return sum+num
                },0);

                

                if(this.form.discount != 0 || this.form.discount != ""){
                    this.percentage = this.form.discount / 100;
                    this.discountPrice = this.form.total_price * this.percentage;
                    this.form.total_price = this.form.total_price - this.discountPrice;
                }
                
            },
            loadItem(){
                axios.get('api/product?listProduct=product')
                .then(({data}) => { 
                    console.log(data)
                    this.sampleProducts = data[0].product
                });
            },
            addons(){
                 this.$delete(this.sampleProducts, this.item.index);
                if(this.item == ""){
                    this.$toastr.e("Please Select Item");
                }else if(this.itemQuantity == ""){
                    this.$toastr.e("Item Quantity is Required");
                }else{
                    var total = [];
                    var quantity = [];

                    this.form.listItems.push(
                        {
                            id:this.item.id,
                            name:this.item.name,
                            quantity:this.itemQuantity,
                            price:this.item.price,
                            box:this.item.box
                        }
                    )
                 
                    
                    this.form.listItems.forEach((element)=>{
                        total.push(element.price * element.quantity)
                        quantity.push(parseInt(element.quantity));
                    })

                    this.form.total_price = total.reduce(function(sum,num){
                            return sum+num
                    },0);

                    this.form.quantity = quantity.reduce(function(sum,num){
                            return sum+num
                    },0);
                    this.item = "";
                    this.itemQuantity = "";
                    this.$toastr.s("Item Successfully Added");
                   
                }
                
                
            },

            savePackage(){
                this.form.post('api/product')
                .then(({data}) => {
                    console.log(data);
                    
                    // this.form.package_name = "";
                    // this.form.listItems = [];
                    // this.$router.push("/package");
                    // this.$toastr.s("Package Successfully Created");
                });
               
            }
            
        },
        mounted() {
            this.loadItem();
            console.log('Component mounted.')
        }
    }
</script>
