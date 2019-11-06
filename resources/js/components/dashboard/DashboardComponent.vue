<template>
<div>
                
        <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                    <div class="inner">
                        <h3>150</h3>

                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>

                        <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>44</h3>

                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>65</h3>

                        <p>Los Stock Item</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
          <!-- ./col -->
        </div>
         <div class="row justify-content-center ml-1 mr-1" style="box-shadow:0px 0px 5px gray;">
             <div class="col-md-6" >
                <apexchart width="100%" type="donut" :options="options" :series="series"></apexchart>
             </div>
        </div>
</div>   
                 

</template>

<script>
    export default {
        data(){
            return {
                series: [70, 55, 13, 33, 70, 55, 13, 33],
                options: {   
                    labels: ['Apple', 'Mango', 'Orange', 'Watermelon', 'Apple', 'Mango', 'Orange', 'Watermelon'],
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                }
                            }
                        }
                    }
                },
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
