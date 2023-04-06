<template>
  <div class="profile">
    <div class="profile__header">
      <h1>Главная</h1>
    </div>
    <ProfileAside></ProfileAside>
    <div class="profile__content">
      <div class="profile__content-item">
        <h2 class="title title--2">График расходов:</h2>
        <charts></charts>
      </div>
      <div class="profile__content-item">
        <h2 class="title title--2">График Доходов:</h2>
        <charts></charts>
      </div>
      <div class="profile__content-item__two-case">
        <h2 class="title title--2">Ваши карты:</h2>
        <swiper></swiper>
      </div>
    </div>
    <live-tape></live-tape>
  </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTape.vue";
import Charts from "../components/Chart.vue";
import Swiper from "../components/Swiper.vue";
</script>
