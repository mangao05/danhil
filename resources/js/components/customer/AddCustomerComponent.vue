<template>
    <div class="card">
        <div class="card-header">Add Customer Component</div>

        <div class="card-body">
            <div>
                <input type="text" v-model="form.customer" class="form-control" placeholder="Customer Name/Company Name" :class="{ 'is-invalid': form.errors.has('customer') }">
                <has-error :form="form" field="customer"></has-error>
            </div>
            <div class="mt-3">
                <input type="text" v-model="form.address" class="form-control" placeholder="Complete Address"
                 :class="{ 'is-invalid': form.errors.has('address') }">
                <has-error :form="form" field="address"></has-error>

            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <input type="number" v-model="form.contact" class="form-control" placeholder="Contact #"
                    :class="{ 'is-invalid': form.errors.has('contact') }">
                     <has-error :form="form" field="contact"></has-error>
                </div>
                <div class="col-md-4">
                    <input type="email" v-model="form.email" class="form-control" placeholder="Email Address"
                    :class="{ 'is-invalid': form.errors.has('email') }">
                     <has-error :form="form" field="email"></has-error>
                </div>
                <div class="col-md-4">
                    <input type="number" v-model="form.credit" class="form-control" placeholder="Credit Limit"
                    :class="{ 'is-invalid': form.errors.has('credit') }">
                     <has-error :form="form" field="credit"></has-error>
                </div>
            </div>
            <div class="mt-3">
                <button v-show="!editMode" @click="createCustomer" class="btn btn-success float-right">Create Customer</button>
                <button v-show="editMode" class="btn btn-success float-right" @click="updateDetails">Update Details</button>                
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                editMode: false,
                customer_id:0,
                form: new Form({
                    customer:'',
                    address:'',
                    contact:'',
                    email:'',
                    credit:''
                })
            }
        },
        methods:{
            createCustomer(){
                this.form.post('api/customer')
                .then(({data}) => {
                    this.$toastr.s('New customer has been successfully added','Success')
                    this.form.reset()
                    this.form.clear()
                    this.$emit('createdSuccess');
                    console.log(data);
                    
                })
                .catch(() => {

                });
            },

            updateDetails(){
                this.form.put('api/customer/'+this.customer_id)
                .then(({data}) => {
                    this.$toastr.s("Customer Details Successfully Updated","Success");
                    Fire.$emit('displayCustomer');
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
