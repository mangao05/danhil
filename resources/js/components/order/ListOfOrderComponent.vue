<template>
    <div>
         <b-nav pills>
            <b-nav-item :active="active.all" @click="getOrders('all')">All</b-nav-item>
            <b-nav-item :active="active.delivery" @click="getOrders('delivery')">Delivery</b-nav-item>
            <b-nav-item :active="active.delivered" @click="getOrders('delivered')">Delivered</b-nav-item>
        </b-nav>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>OR #</th>
                    <th>Customer</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="Object.keys(orders).length == 0">
                    <td colspan="6" class="text-center">No Record...</td>
                </tr>
                <tr v-else v-for="order in orders" :key="order.id">
                    <td>{{order.id}}</td>
                    <td>{{order.customer.customer}}</td>
                    <td>{{order.price}}</td>
                    <td>
                        <router-link :to="{name:'viewPrint',params:{id:order.id}}">
                            <span class="badge badge-primary p-2"><i class="fa fa-eye" aria-hidden="true"></i>View</span>
                        </router-link>

                        <span v-show ="order.status == 'delivery'" style="cursor:pointer" @click="btnDelivered(order.id)" class="badge badge-info p-2"><i class="fas fa-truck"></i> Payment</span>
                        <span v-show ="order.status == 'delivered'" class="badge badge-success p-2"><i class="fas fa-check"></i> Delivered</span>
                    </td>
                </tr>
            </tbody>
        </table>      
        <modal-deliver ref="refDelivery" @loadOrders="loadOrders"></modal-deliver>
    </div>              
</template>

<script>
    export default {
        data(){
            Vue.prototype.$userId = document.querySelector("meta[name='user-id']").getAttribute('content');
            return {
                orders:{}, 
                total:0,
                active: {
                    all : true,
                    delivery: false,
                    delivered : false
                }
            }
        },
        methods: {
            loadOrders(status = 'all'){
                axios.post('api/orderList',{
                    user_id:this.$userId,
                    status: status
                })
                .then(({data}) => {
                    this.orders = data
                });
            },

            btnDelivered(id){
                this.$refs.refDelivery.modalShow = true;
                this.$refs.refDelivery.$data.order_id = id;
            },
            getOrders(status){
                this.loadOrders(status);
                if(status == 'all'){
                    this.active.all = true;
                    this.active.delivery = false;
                    this.active.delivered = false;
                }else if(status == 'delivery'){
                    this.active.all = false;
                    this.active.delivery = true;
                    this.active.delivered = false;
                }else{
                    this.active.all = false;
                    this.active.delivery = false;
                    this.active.delivered = true;
                }
            }

          
        },
        mounted() {
            this.loadOrders();
            
            console.log('Component mounted.')
        }
    }
</script>
