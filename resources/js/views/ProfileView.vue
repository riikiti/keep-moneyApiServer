<template>
  <div class="profile">
    <div class="profile__header">
      <h1 class="title title--2">Главная</h1>
    </div>
    <ProfileAside></ProfileAside>
    <div class="profile__content">
      <div class="profile__content-item">
        <h2 class="title title--3">График расходов</h2>
        <charts-expenses></charts-expenses>
      </div>
      <div class="profile__content-item">
        <h2 class="title title--3">График Доходов</h2>
        <charts-income ></charts-income>
      </div>
      <div class="profile__content-item__two-case">
        <h2 class="title title--3">Ваши карты:</h2>
        <swiper></swiper>
      </div>
    </div>
    <live-tape></live-tape>
  </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTape.vue";
import ChartsExpenses from "../components/ChartExpenses.vue";
import ChartsIncome from "../components/ChartIncome.vue";
import Swiper from "../components/SwiperCards.vue";





</script>
