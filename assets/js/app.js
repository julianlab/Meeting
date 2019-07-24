global.$ = global.jQuery = require('jquery');
var ui = require('jquery-ui');
/**var mm = require('moment');
 var bts = require('bootstrap');
 var events = require('./Events/selectProvincias');
 var foscomment = require('./foscomment/js/comments');
 //var datetimepicker = require('pc-bootstrap4-datetimepicker');
 //var datetimepicker = require('eonasdan-bootstrap-datetimepicker-bootstrap4beta');

 // JS is equivalent to the normal "bootstrap" package
 // no need to set this to a variable, just require it
 require('bootstrap-sass');

 // or you can include specific pieces
 // require('bootstrap-sass/javascripts/bootstrap/tooltip');
 // require('bootstrap-sass/javascripts/bootstrap/popover');

 $(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

 // require the JavaScript
 require('bootstrap-star-rating');
// require 2 CSS files needed
require('bootstrap-star-rating/css/star-rating.css');
require('bootstrap-star-rating/themes/krajee-svg/theme.css');


//Require Events zone
**/

// assets/js/app.js
import Vue from 'vue';
import LogIn from './components/LogIn'


/**
 * Create a fresh Vue Application instance
 */
new Vue({
    el: '#app',
    components: {LogIn}
});