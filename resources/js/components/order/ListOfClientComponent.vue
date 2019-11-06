<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        Customer
                    </div>
                    <button class="btn btn-success" @click="addcustomer()"><i class="fa fa-plus" aria-hidden="true"></i> Add Customer</button>

                    <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    </div>
                </div>
                
                <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Customer Name</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(customers, index) in customer" :key="customers.id">
                        <td>{{index+1}}</td>
                        <td>{{customers.customer}}</td>
                        <td class="text-center">
                            <span @click="viewCustomer(customers.id)" class="badge badge-info p-1"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
        <div class="col-md-8 p-0">
            <customer-details @editCustomerDetails="fetchCustomerDetails" :customerID="customerID" v-show="!addCustomer"></customer-details>
            <add-customer ref="editComponent" v-show="addCustomer" @createdSuccess="loadCustomer()"></add-customer>
        </div>
    </div>
</template>

<script>
    export default {
        data (){
            return {
                editCustomerDetails:false,
                addCustomer:true,
                customer:{},
                customerID:0
            }
        },

        methods: {
            addcustomer(){
                this.addCustomer = true;
                this.$refs.editComponent.editMode = false;
                this.$refs.editComponent.form.reset();
                this.$refs.editComponent.form.clear();
            },
            viewCustomer(id){
                this.addCustomer = false;
                this.customerID = id;
                Fire.$emit('DetailsView',id);
            },
            loadCustomer(){
                axios.get('api/customer')
                .then(({data}) => {
                    this.customer = data.data
                });
            },
            fetchCustomerDetails(value){
                this.addCustomer = true;
                this.editCustomerDetails = true;
                if(this.editCustomerDetails == true){
                    axios.get('api/customer/'+value)
                    .then(({data}) => {
                        this.$refs.editComponent.form.fill(data);
                        this.$refs.editComponent.customer_id = value;
                        this.$refs.editComponent.editMode = true;
                        console.log(this.$refs.editComponent)
                    });
                    
                }
                // console.log(this.$refs.editComponent.form);
            }
        },
        mounted() {
            this.loadCustomer();
            Fire.$on('displayCustomer',() => {
                this.loadCustomer();
            })
            console.log('Component mounted.')
        }
    }
</script>
