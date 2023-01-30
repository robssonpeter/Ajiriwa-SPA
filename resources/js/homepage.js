/* import { Navigation, Pagination, Scrollbar, A11y } from 'swiper';

import { Swiper, SwiperSlide } from "swiper/vue";
// Import Swiper styles
import "swiper/swiper.min.css";
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import {createApp} from "vue";

createApp({
    components: {
        Swiper, SwiperSlide
    },
    data(){
        return {
            modules: [Navigation, Pagination, Scrollbar, A11y],
        }
    },
    mounted() {
        //alert('vue is initiated');
    },
    methods: {
        onSwiper(){
            //alert('things have changed here')
        },
        onSlideChange(){
            //alert('slide is changing here man')
        }
    }
}).mount('#swiper'); */
/* var $ = require( "jquery" ); */
//import jQuery from 'jquery';
//import flexslider from 'flexslider';

//import $ from '../js/flexslider/node_modules/jquery';
var jQuery = require('detached-jquery-1.6.4');
var $ = jQuery.getJQuery();
//var jQuery = ;



/* import jQuery from 'jquery'; */
//window.$ = window.jQuery = $;
$(window).on('load', function(){
    alert('hello there');
})



/* $(window).load(function(){
    $('.flexslider').flexslider(
    {
        animation:"slide",
        animationLoop:true,
        itemWidth:210,
        itemMargin:5
    });
}); */


