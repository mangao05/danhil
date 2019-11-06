<template>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User</h3>
                <button class="btn btn-success" @click="addUser"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Create User</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Role</th>
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in users" :key="user.id">
                      <td>{{index+1}}</td>
                      <td>{{user.firstname}} {{user.lastname}}</td>
                      <td>{{user.user_details.position.position}}</td>
                      <td>Active</td>
                      <td>
                        <span @click="userDetails(user.id)" style="cursor:pointer" class="badge badge-info p-2"><i class="fa fa-eye" aria-hidden="true"></i></span>

                        <span @click="deleteUser(user.id)" style="cursor:pointer" class="badge badge-danger p-2">Deactivate</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-5">
            <add-user  ref="userDetails"></add-user>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                users:{}
            }
        },

        methods:{
            loadUser(){
                axios.get('api/user')
                .then(({data}) => {
                    this.users = data.data;
                });
            },

            userDetails(id){
              var role = [];
              axios.get('api/user/'+id)
              .then(({data}) => {
                // console.log(data.user_role);
                this.$refs.userDetails.user_id = id;
                this.$refs.userDetails.form.fill(data);  
                this.$refs.userDetails.form.address = data.user_details.address;
                this.$refs.userDetails.form.position_id = data.user_details.position_id;
                this.$refs.userDetails.editMode = true;
                data.user_role.forEach(element => {
                    role.push(element.role_id);                    
                });
                    this.$refs.userDetails.form.userRole = role;
              });
            },

            deleteUser(id){
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
                    
                    this.$swal(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    )
                }
              })
            },

            addUser(){
              this.$refs.userDetails.form.clear();
              this.$refs.userDetails.form.reset();
              this.$refs.userDetails.editMode = false;
            }
        },
        mounted() {
            this.loadUser();
            Fire.$on('AfterCreateUser',() =>{
                this.loadUser();
            })
            console.log('Component mounted.')
        }
    }
</script>
