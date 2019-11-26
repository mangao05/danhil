<template>
    <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">List of Item</h3>
                <router-link to="/create" class="btn btn-success">Create Item</router-link>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" v-model="searchFilter" name="table_search" @keyup="filter" class="form-control float-right" placeholder="Search">
                    <div class="input-group-append" style="position:relative;">
                        <i class="fas fa-bell fa-2x ml-3"></i>
                        <span class="badge badge-danger pt-2" v-show="lowStock != 0" style="position:absolute;top:15px;left:10px;">{{lowStock}}</span>
                    </div>
                  </div>
                </div>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                     
                      <th>Item</th>
                      <th>Price</th>
                      <th>Stocks</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="Object.keys(listOfProduct).length == 0">
                      <td colspan="6" class="text-center">No Record...</td>
                    </tr>
                    <tr v-else v-for="product in listOfProduct.data" :key="product.id">
                     
                      <td>{{product.item}}</td>
                      <td>₱{{product.price | toCurrency}}</td>
                      <td>{{product.quantity}}</td>
                      <td v-if="product.quantity <= 5" class="text-danger">Low Stock</td>
                      <td v-else class="text-success">Normal</td>
                      <td>
                          <router-link :to="{name:'preview',params:{id:product.id}}">
                              <span class="badge badge-warning p-2" style="font-size:13px;">view</span>
                          </router-link>
                          <router-link :to="{name:'product',params:{id:product.id}}">
                              <span class="badge badge-primary p-2" style="font-size:13px;">edit</span>
                          </router-link>
                          <span class="badge badge-info p-2" @click="reStock(product.id)" style="font-size:13px;cursor:pointer">re-stock</span>
                          <span class="badge badge-danger p-2" @click="btnDeleteProduct(product.id)" style="font-size:13px;cursor:pointer">delete</span>
                      </td>
                    </tr>
                  </tbody>
                      
                </table>
                      <pagination class="mt-2 mr-4" :data="listOfProduct" @pagination-change-page="fetchProduct" size="small" align="right" :limit="2">
                              <span slot="prev-nav">&lt; Previous</span>
                              <span slot="next-nav">Next &gt;</span>
                      </pagination>
                <div class="p-4 h4 font-weight-bold">
                  Recent Supplier Order
                </div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Item</th>
                      <th>Supplier Price/Item</th>
                      <th>Quantity</th>
                      <th>Total Price</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                    <tr v-if="recentOrdersLength < 1">
                      <td colspan="5" class="text-center">No Recent Order</td>
                    </tr>
                    <tr v-else v-for="(recentOrder, index) in recentOrders.data" :key="recentOrder.id">
                      <td>{{index+1}}</td> 
                      <td>{{recentOrder.item}}</td>
                      <td>₱{{recentOrder.supplier | toCurrency}}</td>
                      <td>{{recentOrder.quantity}}</td>
                      <td>₱{{recentOrder.supplier * recentOrder.quantity | toCurrency}}</td>
                      <td>{{recentOrder.created_at | moment}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <modal-re-stock ref="re_stock" @successUpdate="loadData"></modal-re-stock>
    </div>
    
</template>

<script>
    export default {
        data(){
            return {
                listOfProduct:{},
                recentOrders:{},
                recentOrdersLength:0,
                searchFilter:"",
                lowStock:0,
            }
        },
        methods:{
            fetchProduct(page = 1){
              axios.get('api/product?page='+page+'&filter='+this.searchFilter)
              .then(({data}) => {
                this.listOfProduct = data
              })
            },

            displayLowStock(){
                axios.get('api/lowstock')
                .then(({data}) => {
                    this.lowStock = data
                })
            },

            btnDeleteProduct(id){
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
                        product_id:id
                    })
                      .then(({data}) => {
                          Fire.$emit('AfterCreateProduct');
                          Fire.$emit('AfterDelete');
                          this.$swal(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                          )
                      });
                    }
                })
            },

            loadRecent(){
              axios.get('api/recent')
              .then(({data}) => {
                this.recentOrders = data;
                this.recentOrdersLength = data.data.length
              });
              
            },

            filter(){
              axios.post('api/filter',{
                  keyword:this.searchFilter
              })
              .then(({data}) => {
                this.listOfProduct = data;
              })
            },

            reStock(id){
                this.$refs.re_stock.re_stock = true;
                this.$refs.re_stock.loadItemDetails(id);   
            },

            loadData(){
              this.fetchProduct();
              this.displayLowStock();
            }
        },
        mounted() {
            this.loadRecent();
            this.fetchProduct();
            Fire.$on('AfterCreateProduct',()=>{
              this.fetchProduct();
            })

            Fire.$on('AfterDelete',()=>{
              this.loadRecent();
            })
            this.displayLowStock();
            
            console.log('Component mounted.')
        }
    }
    
</script>

