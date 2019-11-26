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
                            <tr v-if="Object.keys(packages).length == 0">
                                <td colspan="5" class="text-center">No Package...</td>
                            </tr>
                            <tr v-else v-for="listpackage in packages" :key="listpackage.id">
                                <td>{{listpackage.item}}</td>
                                <td>{{(listpackage.discount == null)?"N/A":listpackage.discount+"%"}}</td>
                                <td>{{listpackage.quantity}}</td>
                                <td>₱{{listpackage.price | toCurrency}}</td>
                                <td>
                                    
                                    <b-dropdown id="dropdown-1" size="sm" text="More" class="m-md-2">
                                        <b-dropdown-item>
                                            <span class="badge badge-success p-2" style="width:100%" @click="viewDetails(listpackage.id, listpackage.item, listpackage.photo)">Details</span>
                                        </b-dropdown-item>
                                        <b-dropdown-item>
                                            <span class="badge badge-danger p-2" style="width:100%" @click="deletePackage(listpackage.id,listpackage.photo)">Delete</span>
                                        </b-dropdown-item>
                                        <b-dropdown-item>
                                            <span class="badge badge-primary p-2" style="width:100%" @click="editPackage(listpackage.id, listpackage.item, listpackage.photo)">Edit</span>
                                        </b-dropdown-item>
                                    </b-dropdown>
                                    <span></span>
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
                        <img class="img-thumbnail" :src="(packageItem.image == '')?'img/picture.png':'/storage/package-images/'+packageItem.image" :alt="packageItem.name">
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
            <modal-edit-package ref="editPackage"></modal-edit-package>
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
            viewDetails(id, name, image){
                this.packageItem.name = name;
                this.packageItem.image = image;
                axios.get(`api/package/${id}`).then(({data}) => this.packageDetails = data)
            },
            deletePackage(id,photo){
                this.$swal({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                      axios.post('api/deleteProduct',{
                        product_id:id,
                        photo:photo,
                    })
                      .then(({data}) => {
                        
                          Fire.$emit('loadPackage');
                          this.$swal(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                          )
                      });
                    }
                })
            },

            editPackage(id, name, image){
               this.$refs.editPackage.editModalShow = true;
               this.$refs.editPackage.packageImg = "/storage/package-images/"+image;
               this.$refs.editPackage.packageName = name;
               this.$refs.editPackage.packageArrays = [];
               this.$refs.editPackage.loadPackageDetails(id);
               this.$refs.editPackage.addAccessories = false;
               this.$refs.editPackage.loadItem(id);
               this.$refs.editPackage.sampleProducts1 = [];

            }

        },
        mounted() {
            this.loadPackage();
            Fire.$on('loadPackage',()=>{
                this.loadPackage();
            })
            console.log('Component mounted.')
        }
    }
</script>
