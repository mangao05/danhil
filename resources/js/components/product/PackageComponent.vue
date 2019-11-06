<template>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    Example Component
                    <br>
                    <router-link to="/addPackage"><button class="btn btn-success">Create Package</button></router-link>
                </div>
                
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Package</th>
                                <th>Discount</th>
                                <th>Item Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                            <tr v-for="listpackage in packages" :key="listpackage.id">
                                <td>{{listpackage.item}}</td>
                                <td>{{(listpackage.discount == null)?"N/A":listpackage.discount}}</td>
                                <td>{{listpackage.quantity}}</td>
                                <td>{{listpackage.price}}</td>
                                <td>
                                    <span class="badge badge-primary p-2" @click="viewDetails(listpackage.id, listpackage.total_box, listpackage.item, listpackage.photo)">Details</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-info">
                <div class="card-header">
                    Package <span class="font-weight-bold text-uppercase">{{ packageItem.name }}</span>
                </div>
                <div class="card-body">
                    <h1 class="text-center">Package</h1>
                    
                    <div class="col-lg-8 offset-lg-2">
                        <img class="img-thumbnail" :src="'/storage/package-images/'+packageItem.image" :alt="packageItem.name">
                        <p class="text-center text-uppercase font-weight-bold py-2 h4">{{packageItem.name}}</p>
                    
                    </div>
                    <h3 class="text-muted">Package Details</h3>
                    <table class="table table-striped table-border table-hover table-success">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="detail in packageDetails" :key="detail.id">
                                <td><img class="img-thumbnail" style="max-width: 80px; max-height:80px;" :src="'img/product/'+detail.products.photo" :alt="detail.products.item"></td>
                                <td>{{ detail.products.item }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

          
</template>

<script>
    export default {
        data(){
            return {
                packages:{},
                packageDetails : {},
                packageItem : {
                    name: "",
                    total_box: "",
                    image :""
                }
            }
        },
        methods:{
            loadPackage(){
                axios.get('api/package')
                .then(({data}) => {
                    this.packages = data.data;
                });
            },
            viewDetails(id, total_box, name, image){
                this.packageItem.name = name;
                this.packageItem.total_box = total_box;
                this.packageItem.image = image;
                axios.get(`api/package/${id}`).then(({data}) => this.packageDetails = data)
            }
        },
        mounted() {
            this.loadPackage();
            console.log('Component mounted.')
        }
    }
</script>
