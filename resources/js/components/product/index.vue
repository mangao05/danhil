<template>
    <div class="card">
              <div class="card-header">
                <h3 class="card-title font-weight-bold">List of Item</h3>
                <router-link to="/create" class="btn btn-success">Create Item</router-link>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
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
                    <tr v-else v-for="(product, index) in listOfProduct" :key="product.id">
                      <td>{{index+1}}</td>
                      <td>{{product.item}}</td>
                      <td>{{product.price}}</td>
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
                          
                          <span class="badge badge-danger p-2" @click="btnDeleteProduct(product.id)" style="font-size:13px;cursor:pointer">delete</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <div class="p-4 h4 font-weight-bold">
                  Recent Order
                </div>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Item</th>
                      <th>Price/Item</th>
                      <th>Total Price</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(recentOrder, index) in recentOrders" :key="recentOrder.id">
                      <td>{{index+1}}</td>
                      <td>{{recentOrder.item}}</td>
                      <td>{{recentOrder.supplier}}</td>
                      <td>{{recentOrder.supplier * recentOrder.quantity}}</td>
                      <td>{{recentOrder.created_at}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
    </div>
    
</template>

<script>
    export default {
        data(){
            return {
                listOfProduct:{},
                recentOrders:{}
            }
        },
        methods:{
            fetchProduct(){
              axios.get('api/product')
              .then(({data}) => {
                this.listOfProduct = data.data
              })
              .catch(() => {

              });
            },

            displayLowStock(){
                axios.get('api/lowstock')
                .then(({data}) => {
                    if(data.length > 0){
                      data.forEach(element => {
                          this.$toastr.e(`${element.item} is low on stock`)
                      });
                    }
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
                this.recentOrders = data.data;
              });
              
            }
        },
        mounted() {
            this.loadRecent();
            this.fetchProduct();
            Fire.$on('AfterCreateProduct',()=>{
              this.fetchProduct();
            })
            this.displayLowStock();
            console.log('Component mounted.')
        }
    }
</script>
