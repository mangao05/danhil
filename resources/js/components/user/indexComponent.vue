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
                      
                      <th>Status</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in users" :key="user.id">
                      <td>{{index+1}}</td>
                      <td>{{user.firstname}} {{user.lastname}}</td>
                    
                      <td :class="(user.status == 'deactivated') ? 'text-danger' : 'text-success'">{{user.status }}</td>
                      <td>
                        <span @click="userDetails(user.id)" style="cursor:pointer" class="badge badge-info p-2"><i class="fa fa-eye" aria-hidden="true"></i></span>

                        <span @click="deleteUser(user.id)" style="cursor:pointer" class="badge badge-danger p-2"><i class="fa fa-trash" aria-hidden="true"></i></span>
                         <span @click="userStatus(user.id,user.firstname,(user.status == 'activated') ? 'deactivated' : 'activated')" style="cursor:pointer" :class="(user.status == 'deactivated') ? 'badge-success' : 'badge-danger'" class=" p-2 badge">{{(user.status == 'activated') ? 'deactivate':'activate' }}</span>
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
                console.log(data);
                this.$refs.userDetails.user_id = id;
                this.$refs.userDetails.form.fill(data);  
                this.$refs.userDetails.form.address = data.user_details.address;
                this.$refs.userDetails.form.contact = data.user_details.contact;
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
            },
            userStatus(id,name,status){
              axios.get('api/userstatus/'+id+'/'+status).then(({data})=>{
                   Fire.$emit('AfterCreateUser');
                  this.$swal({
                  position: 'top-end',
                  type: 'success',
                  title: name +' '+ 'sucessfully' +' '+ status,
                  showConfirmButton: false,
                  timer: 1500
                })
              });
                  
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
