
window.Vue=require('vue');

var moment = require('moment'); // require
Vue.filter('timeformat',function(arg){
   return moment(arg).format('LLLL'); 
})