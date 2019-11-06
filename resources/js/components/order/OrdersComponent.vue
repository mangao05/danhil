<template>
    <div class="card">
        <div class="card-header">Orders Component</div>

        <div class="card-body">
            <list-order  @viewProduct="viewProduct"></list-order>
        </div>
    </div>    
</template>

<script>
import { log } from 'util';
    export default {
        data(){
            return {
                viewProduct:{}
            }
        },

        methods:{
           
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
