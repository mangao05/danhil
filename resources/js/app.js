/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router'
import { Form, HasError, AlertError } from 'vform'
import toastr from 'vue-toastr'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import VueHtmlToPaper from 'vue-html-to-paper';
import VueApexCharts from 'vue-apexcharts'
import Datepicker from 'vuejs-datepicker';
import moment from 'moment';
import converter from 'number-to-words';
import VueAutosuggest from "vue-autosuggest";
import vSelect from 'vue-select'


//pages
const routes = [
    { path: '/product', component: require('./components/product/index.vue').default },
    { path: '/create', component: require('./components/product/create.vue').default },
    { path: '/customer', component: require('./components/order/ListOfClientComponent.vue').default },
    { path: '/user', component: require('./components/user/indexComponent.vue').default },
    { path: '/home', component: require('./components/dashboard/DashboardComponent.vue').default },
    { path: '/orders', component: require('./components/order/OrdersComponent.vue').default },
    { path: '/listOfOrder', component: require('./components/order/OrderComponent.vue').default },
    { path: '/position', component: require('./components/position/PositionComponent.vue').default },
    { path: '/newOrder', component: require('./components/order/NewOrderComponent.vue').default },
    { path: '/preview/:id', name:'preview', component: require('./components/product/productPreview.vue').default },
    { path: '/edit/:id', name:'product', component: require('./components/product/create.vue').default },
    { path: '/viewPrint/:id', name:'viewPrint', component: require('./components/order/ViewOrderPrintComponent').default },
    { path: '/collections', component: require('./components/collections/CollectionComponent').default },
    { path: '/package', component: require('./components/product/PackageComponent').default },
    { path: '/addPackage', component: require('./components/product/AddPackageComponent').default },
    

]

const options = {
    name: '_blank',
    specs: [
      'fullscreen=yes',
      'titlebar=yes',
      'scrollbars=yes'
    ],
    styles: [
      'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
      // 'https://unpkg.com/kidlat-css/css/kidlat.css',
      'https://fonts.googleapis.com/css?family=Archivo+Black&display=swap',
      'http://localhost:3000/css/custom.css'
    ],
  }

const router = new VueRouter({
    mode:'history',
    routes // short for `routes: routes`
})

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('datepicker', Datepicker);
Vue.use(VueRouter)
Vue.use(toastr)
Vue.use(BootstrapVue)
Vue.component('apexchart', VueApexCharts)
Vue.use(VueSweetalert2);
Vue.use(VueHtmlToPaper, options);
Vue.use(VueAutosuggest);
Vue.component('v-select', vSelect);




window.Fire = new Vue();
Vue.use(require('vue-moment'));




Vue.component('example-component', require('./components/ExampleComponent.vue').default);


//components
Vue.component('customer-details', require('./components/customer/CustomerDetailsComponent.vue').default);
Vue.component('add-customer', require('./components/customer/AddCustomerComponent.vue').default);
Vue.component('view-product', require('./components/product/ProductComponent.vue').default);
Vue.component('preview-product', require('./components/modal/ProductPreviewComponent.vue').default);
Vue.component('preview-cart', require('./components/modal/CartPreviewComponent.vue').default);
Vue.component('add-user', require('./components/user/AddUserComponent').default);
Vue.component('add-position', require('./components/position/AddPositionComponent').default);
Vue.component('list-order', require('./components/order/ListOfOrderComponent').default);
Vue.component('modal-deliver', require('./components/modal/DeliveryModalComponent').default);
Vue.component('modal-re-stock', require('./components/modal/ReStockComponent').default);
Vue.component('modal-edit-package', require('./components/modal/EditPackageComponent').default);
Vue.component('pagination', require('laravel-vue-pagination'));

window.Form = Form;
Vue.filter('moment', function(date){
  if (!date) return '';
  return moment(date).format('MMMM D, YYYY');
})

Vue.filter('toWords', function (value) {
  if (!value) return '';
  return converter.toWords(value);
})

Vue.filter('toCurrency', function (value) {
  if (typeof value !== "number") {
      return value;
  }
  var formatter = new Intl.NumberFormat('en-US', {
      style: 'decimal',
      minimumFractionDigits: 0
  });
  return formatter.format(value);
});


const app = new Vue({
    el: '#app',
    router
});
