<template>
    <h1 class="title title--2">Наши преимущества</h1>
    <div class="home-swiper">
        <div class="home-swiper__laptop">
            <img src="../../assets/img/homeImages/laptop1.png" alt="laptop">
        </div>
        <div class="home-swiper__swipe">
            <swiper :slides-per-view="1" :modules="modules" :pagination="{ clickable: true }" :autoplay="{delay: 3000}"
                    :grab-cursor="true"
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
                <p>все транзакции находятся в одном приложение</p>
            </div>

            <div class="home-swiper__swipe__pagination-text"><h3 class="title title--3">Планирование</h3>
                <p>Ставь цели и добивайся их!</p></div>
            <div class="home-swiper__swipe__pagination-text"><h3 class="title title--3">Интерфейс</h3>
                <p>интуитивно понятный и удобный интерфейс </p></div>
            <div class="home-swiper__swipe__pagination-text"><h3 class="title title--3">Функционал</h3>
                <p>поможет сделать все нужные операции</p>
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


