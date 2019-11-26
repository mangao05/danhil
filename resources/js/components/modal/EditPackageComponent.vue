<template>
    <b-modal id="editModalShow" hide-footer size="lg" v-model="editModalShow" title="BootstrapVue">
        <div class="row">
            <div class="col-md-4">
                <img class="img-fluid" :src="packageImg" alt="">
            </div>
            <div class="col-md-8">
                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">
                        Package Name:
                    </div>
                    <div class="col-md-8">
                        <input type="text" v-model="packageName" class="form-control" >
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">
                        Discount:
                    </div>
                    <div class="col-md-8">
                        {{(PackageDetails.discount == null)?"N/A":PackageDetails.discount}}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">
                        Item Quantity:
                    </div>
                    <div class="col-md-8">
                        {{totalQuantity}}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3 font-weight-bold">
                        Package Price:
                    </div>
                    <div class="col-md-8">
                        ₱{{totalPrice | toCurrency}}
                    </div>
                </div>

            </div>
        </div>
        <div class="text-center p-2">
            <button @click="showAddAccessories" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i>Add Accessories</button>
        </div>
        <div class="row mb-2" v-show="addAccessories">
            <div class="col-md-7">
                <v-select v-model="accessories" 
                    :options="sampleProducts1"
                    label = "item"
                    item-text = "item"
                    item-value = "id"
                    aria-required=""
                    placeholder = "Select Accessories"
                    @input="sampleProduct1 = accessories.item"
                ></v-select>
                <!-- <select name="" v-model="accessories" id="" class="form-control">
                    <option value="" disabled hidden>Select Accessories</option>
                    <option v-for="(sampleProduct,index) in sampleProducts" :key="sampleProduct.id" :value="{
                                    id : sampleProduct.id,
                                    name: sampleProduct.item,
                                    price: sampleProduct.price,
                                    photo: sampleProduct.photo,
                                    index:index,
                                } 
                                ">
                                
                                {{sampleProduct.item}}
                    </option>
                </select> -->
            </div>
            <div class="col-md-4">
                <input type="number" v-model="quantity" class="form-control" placeholder="Quantity">
            </div>
            <div class="col-md-1">
                <button class="btn btn-success" @click="btnAddAccessories"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="Object.keys(this.packageArrays).length == 0">
                        <td colspan="4" class="text-center">No Accessories...</td>
                    </tr>
                    <tr v-else v-for="(packageArray,index) in packageArrays" :key="packageArray.id">
                        <td>
                            <img width="50px;" :src="`/img/product/${packageArray.photo}`" alt="">
                        </td>
                        <td>
                            {{packageArray.item}}
                        </td>
                        <td>
                            {{packageArray.quantity}}
                        </td>
                        <td>
                            <span @click="deleteAccessories(index)" class="badge badge-danger p-2"><i class="fa fa-times" aria-hidden="true"></i></span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="w-100">
                <button class="btn btn-success float-right mr-3" @click="updateData">Update</button>
                <button class="btn btn-info float-right mr-1" @click="editModalShow = false">Cancel</button>
            </div>
        </div>
    </b-modal>
</template>

<script>
    export default {
        data(){
            return {
                addAccessories:false,
                editModalShow:false,
                packageName:"",
                packageImg:"",
                packageItems:{},
                PackageDetails:{},
                packageArrays:[],
                accessories:"",
                sampleProducts:{},
                quantity:"",
                totalPrice:"",
                totalQuantity:"",
                package_id:0,
                sampleProducts1:[],
            }
        },
        methods:{
            loadPackageDetails(id){
                this.package_id = id;
                axios.get(`api/package/${id}`).then(({data}) => {
                    data.forEach(element => {
                        this.packageArrays.push({
                            photo:element.products.photo,
                            id:element.product_id,
                            item:element.products.item,
                            quantity:element.quantity,
                            price:element.products.price,
                        });
                    });    
                    this.loadPackage(id)
                })
            },
            

            loadPackage(id){
                axios.get('api/product/'+id)
                .then(({data}) => {
                    this.PackageDetails = data;
                    this.totalPrice = data.price;
                    this.totalQuantity = data.quantity;
                })
            },

            showAddAccessories(){
                this.addAccessories = true;
            },

            loadItem(id){
                axios.post('api/exiting',{
                    id:id
                })
                .then(({data}) => { 

                    data.forEach((element,index) => {
                        this.sampleProducts1.push({
                            id:element.id,
                            item:element.item,
                            price:element.price,
                            photo:element.photo,
                        });
                    });
                });
            },

            btnAddAccessories(){
                var indexArray = this.sampleProducts1.indexOf(this.accessories);
                
                this.$delete(this.sampleProducts1,indexArray);
                var total = [];
                var quantity = [];

                this.packageArrays.push({
                    id:this.accessories.id,
                    photo:this.accessories.photo,
                    item:this.accessories.item,
                    price:this.accessories.price,
                    quantity:this.quantity,
                    index:this.accessories.index,
                });

                this.packageArrays.forEach(element => {
                    total.push(element.price * element.quantity);
                    quantity.push(parseInt(element.quantity));
                });

                this.totalPrice = total.reduce(function(sum,num){
                    return sum+num;
                });

                this.totalQuantity = quantity.reduce(function(sum,num){
                    return sum+num;
                });

                this.accessories = "";
                this.quantity = "";
                
            },

            deleteAccessories(index){
                this.totalPrice = this.totalPrice - this.packageArrays[index].price * this.packageArrays[index].quantity;
                this.totalQuantity = this.totalQuantity - this.packageArrays[index].quantity;
                
                this.sampleProducts1.push({
                    id:this.packageArrays[index].id,
                    item:this.packageArrays[index].item,
                    price:this.packageArrays[index].price,
                    photo:this.packageArrays[index].photo,
                });
                this.$delete(this.packageArrays,index);  
            },

            updateData(){
                axios.post('api/updatePackage/',{
                    id:this.package_id,
                    package:this.packageArrays,
                    quantity:this.totalQuantity,
                    price:this.totalPrice,
                    item:this.packageName,
                })
                .then(({data}) => {
                    this.$toastr.s("Package Successfully updated");
                    this.editModalShow = false;
                })
            },
            
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
