<template>

    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header">
            <h1 class="title title--2">Бюджет</h1>
        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__content">
            <div class="profile__content-item__two-case">
                <h2 class="title title--3">Бюджет</h2>
                <swiper></swiper>
            </div>
            <div class="profile__content-item"><h2 class="title title--3">Количество денег на всех картах</h2>
                <charts-budget></charts-budget>
            </div>
            <div class="profile__content-item"><h2 class="title title--3">Планы</h2><bar-plan></bar-plan></div>
        </div>
        <live-tape></live-tape>
    </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapePlanBudget.vue";
import ChartsBudget from "../components/ChartBudget.vue";
import BarPlan from "../components/BarPlan.vue";
import Swiper from "../components/SwiperCards.vue";
import {ref} from "vue";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}
</script>
