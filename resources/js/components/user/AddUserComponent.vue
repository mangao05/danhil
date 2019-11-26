<template>
    <div class="card">
        <div v-show="!editMode" class="card-header">Add User</div>
        <div v-show="editMode" class="card-header">Edit User</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label v-show="editMode" class="label">Last Name:</label>
                    <input type="text" v-model="form.lastname" class="form-control" placeholder="Last Name"
                    :class="{'is-invalid': form.errors.has('lastname')}">
                    <has-error :form="form" field="lastname"></has-error>
                </div>
                <div class="col-md-6">
                    <label v-show="editMode" class="label">First Name:</label>
                    <input type="text" v-model="form.firstname" class="form-control" placeholder="First Name"
                    :class="{'is-invalid': form.errors.has('firstname')}">
                    <has-error :form="form" field="firstname"></has-error>
                </div>
            </div>
            <div class="mt-2">
                <label v-show="editMode" class="label">Address:</label>
                <input type="text" v-model="form.address" class="form-control" placeholder="Address"
                :class="{'is-invalid': form.errors.has('address')}">
                <has-error :form="form" field="address"></has-error>
            </div>
            <div class="mt-2 row">
                <div class="col-md-6">
                    <label v-show="editMode" class="label">Email:</label>
                    <input type="email" v-model="form.email" class="form-control" placeholder="Email"
                    :class="{'is-invalid': form.errors.has('email')}">
                    <has-error :form="form" field="email"></has-error>
                </div>
                <div class="col-md-6">
                    <label v-show="editMode" class="label">Contact #:</label>
                     <input type="text" v-model="form.contact" class="form-control" placeholder="Contact #"
                    :class="{'is-invalid': form.errors.has('contact')}">
                    <has-error :form="form" field="contact"></has-error>
                </div>
                
            </div>
            <div class="mt-2 h4">
                Role Management
            </div>
            <div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Check</th>
                            <th>Role Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="roles in role" :key="roles.id">
                            <td><input type="checkbox" :value="roles.id" v-model="form.userRole"></td>
                            <td>{{roles.role}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <button v-show="!editMode" class="btn btn-success form-control" @click="createUser">Create User</button>
                <button v-show="editMode" class="btn btn-success form-control" @click="updateUser">Update User</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                role:{},
                
                user_id:0,
                editMode:false,
                form: new Form({
                    lastname: "",
                    firstname: "",
                    address: "",
                    email: "",
                    contact: "",
                    userRole:[],
                })
            }
        },

        methods: {
             loadrole(){
                axios.get('api/role')
                .then(({data}) => {
                   this.role = data;
                });
            },
            
            createUser(){
                this.form.post('api/user')
                .then(({data}) => {
                    this.form.clear();
                    this.form.reset();
                    this.$toastr.s("New User Successfully Added","Success");
                    Fire.$emit('AfterCreateUser');
                });
            },

            updateUser(){
                this.form.put('api/user/'+this.user_id)
                .then(({data}) => {
                    this.$toastr.s("Updated Successfully","Success");
                    this.$router.go();
                    Fire.$emit('AfterCreateUser');
                });
            }
        },
        mounted() {
            this.loadrole();
            console.log('Component mounted.')
        }
    }
</script>
