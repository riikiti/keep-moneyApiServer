<template>

    <div class="profile" :class="{ 'profile-active': menu}">
    <div class="profile__header">
      <h1 class="title title--2">Расходы</h1>
    </div>
      <ProfileAside @openMenu="openMenu()"></ProfileAside>
    <div class="profile__content">
        <div class="profile__content-item__two-case">
            <h2 class="title title--3">Расхроды</h2>
            <bar-expenses></bar-expenses>
        </div>
        <div class="profile__content-item"><h2 class="title title--3">Расходы по конкретной категории</h2>
            <charts-expenses></charts-expenses>
        </div>
        <div class="profile__content-item"><h2 class="title title--3">Расходы по всем категориям</h2>
            <charts-expenses></charts-expenses>
        </div>
    </div>
    <live-tape></live-tape>
  </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapeExpenses.vue";
import ChartsExpenses from "../components/ChartExpenses.vue";
import BarExpenses from "../components/BarEpenses.vue";
import {ref} from "vue";
const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}
</script>


