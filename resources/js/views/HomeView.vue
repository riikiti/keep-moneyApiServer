<template>
    <div class="home">
        <HeaderHome></HeaderHome>
        <sub-header></sub-header>
        <advantages></advantages>
        <reviews></reviews>
        <home-swiper></home-swiper>
        <home-mobile></home-mobile>
        <home-footer></home-footer>
    </div>
</template>

<script setup>

import HeaderHome from "../components/HeaderHome.vue";
import Advantages from "../components/Home/Advantages.vue";
import HomeSwiper from "../components/Home/Swiper.vue";
import SubHeader from "../components/Home/SubHeader.vue";
import Reviews from "../components/Home/Reviews.vue";
import HomeMobile from "../components/Home/Mobile.vue";
import HomeFooter from "../components/Home/footer.vue";

</script>


