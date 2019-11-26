<template>
<div class="card">
    <div class="card-header">
            <h3 class="card-title">Collections Table</h3>

              <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
              </div>
      </div>
                    <div>
                      <b-nav pills>
                        <b-nav-item :active="active.all" @click="allCollection">All Collection</b-nav-item>
                        <b-nav-item :active="active.dated" @click="datedCheck(2)">Dated Check</b-nav-item>
                        <b-nav-item :active="active.postdated" @click="postDated(1)">Post Dated Check</b-nav-item>
                        <b-nav-item :active="active.cash" @click="cash(3)">Cash</b-nav-item>
                      </b-nav>
                    </div>
              <div class="card-body table-responsive p-0">
          <table class="table table-hover">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-if="emptyData">
                      <td class="text-center" colspan="5 ">No Record...</td>
                    </tr>
                   
                    <tr v-for="(collection, index) in collections.data" :key="collection.id"> 
                      <td>{{ index + 1 }}</td>
                      <td>{{ collection.order.customer.customer }} </td>
                      <td>{{ collection.payment_type }}</td>
                      <td>
                        {{(collection.payment_type == "Cash")?collection.created_at:collection.check_date | moment }}
                      </td>
                      <td>
                          <b-badge variant="success" style="cursor:pointer;" v-b-popover.hover.top="'Show '+ collection.order.customer.customer+'\'s payment details.'" title="VIEW"><i class="fas fa-eye"></i> </b-badge>
                      </td>
                    </tr>    
                  </tbody>
          </table>
    </div>
</div>
       
</template>
<script>
export default {
    data(){
        return {
            collections : {},
            emptyData:false,
            form : {
                email : ''
            },
            active:{
              all:true,
              dated:false,
              postdated:false,
              cash:false
            }
        }
    },
    methods: {
        loadCollections(){
          axios.get('/api/collection').then(({data})=> {
            this.collections = data
            })
        },
        allCollection(){
          this.loadCollections();
          this.active.dated = false;
          this.active.all = true;
          this.active.postdated = false;
          this.active.cash = false;
          this.emptyData = false;
        },
        datedCheck(id){
          axios.post('api/collectionFilter',{check_type:id})
          .then(({data}) => {
            if(data.data.length == 0){
              this.emptyData = true;
            }else{
              this.emptyData = false;
            }
            this.collections = data
          })
          this.active.dated = true;
          this.active.all = false;
          this.active.postdated = false;
          this.active.cash = false;
        },

        postDated(id){
          axios.post('api/collectionFilter',{check_type:id})
          .then(({data}) => {
            if(data.data.length == 0){
              this.emptyData = true;
            }else{
              this.emptyData = false;
            }
            
            this.collections = data
          })
          this.active.dated = false;
          this.active.all = false;
          this.active.postdated = true;
          this.active.cash = false;
        },

        cash(id){
          axios.post('api/collectionFilter',{payment_type:id})
          .then(({data}) => {
            if(data.data.length == 0){
              this.emptyData = true;
            }else{
              this.emptyData = false;
            }
            
            this.collections = data
          })
          this.active.dated = false;
          this.active.all = false;
          this.active.postdated = false;
          this.active.cash = true;
        }
    },
    created(){
        this.loadCollections();
    }
}
</script>
