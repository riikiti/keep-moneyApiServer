<template>
    <h1 class="title title--2">Lorem ipsum dolor sit amet</h1>
    <div class="home-swiper">
        <div class="home-swiper__laptop">
            <img src="../../assets/img/homeImages/laptop1.png" alt="laptop">
        </div>
        <div class="home-swiper__swipe">
            <swiper :slides-per-view="1" :modules="modules" :pagination="{ clickable: true }" :grab-cursor="true"
                    class="swiper">
                <swiper-slide>
                    <img src="../../assets/img/homeImages/1.png" alt="man">
                </swiper-slide>
                <swiper-slide>
                    <img src="../../assets/img/homeImages/10.png" alt="man">
                </swiper-slide>

                <swiper-slide>
                    <img src="../../assets/img/homeImages/4.png" alt="man">
                </swiper-slide>

                <swiper-slide>
                    <img src="../../assets/img/homeImages/6.png" alt="man">
                </swiper-slide>
            </swiper>
            <div class="home-swiper__swipe__pagination-text">

                <h3 class="title title--3">Систематизация</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit!</p>
            </div>

            <div class="home-swiper__swipe__pagination-text"><h3 class="title title--3">Планирование</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit!</p></div>
            <div class="home-swiper__swipe__pagination-text"><h3 class="title title--3">Удобный интерфейс</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit!</p></div>
            <div class="home-swiper__swipe__pagination-text"><h3 class="title title--3">Выбор пользоватлей </h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit!</p>
            </div>
        </div>
    </div>


</template>

<script setup>
import {ref} from "vue";
import {Swiper, SwiperSlide} from "swiper/vue";
import "swiper/css";
import 'swiper/css/pagination';
import {A11y, Navigation, Pagination, Scrollbar} from "swiper";

const modules = [Pagination, Navigation, Scrollbar, A11y];

</script>


