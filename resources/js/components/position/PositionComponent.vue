<template>
    <div class="row">
        <div class="col-md-7">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Position</h3>
                <button class="btn btn-success"><i class="fa fa-plus mr-1" aria-hidden="true"></i>Add Position</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>Position</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="positions in position" :key="positions.id">
                        <td>{{positions.id}}</td>
                        <td>{{positions.position}}</td>
                        <td>
                            <span @click="editPosition(positions.id)" class="badge badge-info p-1"><i class="fa fa-eye" aria-hidden="true"></i></span>
                        </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-5">
            <add-position ></add-position>
        </div>
    </div>
</template>

<script>
   export default {
        data() {
            return {
              position:{},
              editPosition:false,
            }
        },
        methods: {
              loadPosition(){
                axios.get('api/position')
                .then(({data}) => {
                    // console.log(data);
                   this.position = data;
                  
                });
            },
            editPosition(val){
                
            }
        },
      
        mounted() {
            this.loadPosition();
            Fire.$on('createdSuccess', ()=>{
              this.loadPosition();
            })
            console.log('Component mounted.')
        }
    }
</script>
