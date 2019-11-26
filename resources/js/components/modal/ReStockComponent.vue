<template>
    <b-modal hide-footer v-model="re_stock" title="BootstrapVue">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- <img class="img-fluid" :src="'img/product/'+item_details.photo" alt=""> -->
                <img class="img-fluid" :src="(item_details.photo == 'picture.png')?`img/picture.png`:`img/product/`+item_details.photo" alt="">
               
            </div>
        </div>

        <div class="row justify-content-center mt-2">
            <div class="col-md-8">
                <input type="number" v-model="quantity" placeholder="Enter Quantity" class="form-control">
            </div>
        </div>
        
        <div class="row justify-content-center mt-2">
            <div class="col-md-8">
                <button @click="addQuantity" class="btn btn-success form-control">Save</button>
            </div>
        </div>
    </b-modal>
</template>

<script>
    export default {
        data(){
            return{
                re_stock:false,
                item_details:{},
                item_id: 0,
                quantity:"",
            }
        },
        methods:{
            loadItemDetails(id){
                axios.get('api/product/'+id)
                .then(({data}) => {
                    this.item_details = data;
                    this.item_id = data.id
                })
            },

            addQuantity(){
                axios.post('api/addQuantity',{
                    id:this.item_id,
                    quantity:this.quantity,
                })
                .then(({data}) => {
                    this.$emit('successUpdate');
                    this.re_stock = false;
                    this.quantity = "";
                    this.$toastr.s('Item Quantity Successfully Updated');
                })
            }
        },
        mounted() {
           
            console.log('Component mounted.')
        }
    }
</script>
