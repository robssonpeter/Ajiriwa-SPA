import { Navigation, Pagination, Scrollbar, A11y } from 'swiper';

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
}).mount('#swiper');

