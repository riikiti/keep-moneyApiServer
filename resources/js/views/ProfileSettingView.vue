<template>

    <div class="profile" :class="{ 'profile-active': menu}">
    <div class="profile__header">
        <button class="profile__mobile-btn" @click="openMenu()">открыть</button>
      <h1 class="title title--2">Настройки</h1>
    </div>
      <ProfileAside @openMenu="openMenu()"></ProfileAside>
    <div class="profile__content">
      <div class="profile__content-charts"></div>
    </div>
    <live-tape></live-tape>
  </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapeIncome.vue";
import {ref} from "vue";
const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}
</script>
