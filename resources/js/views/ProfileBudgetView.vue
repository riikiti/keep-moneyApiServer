<template>

    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header">
            <h1 class="title title--2">Бюджет</h1>
        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__content">
            <div class="profile__content-item__two-case">
                <h2 class="title title--3">Бюджет</h2>
                <swiper @addBudget="addPlan()"></swiper>
            </div>
            <template v-if="refresh">
            <div class="profile__content-item">
                <charts-budget>
                    <template v-slot:title>
                        Количество денег на всех картах
                    </template>
                </charts-budget>
            </div>
            <div class="profile__content-item"><bar-plan>
                <template v-slot:title>
                    Планы по бюджету
                </template>
            </bar-plan></div>
            </template>
            <div v-else>
                <preloader></preloader>
            </div>
        </div>

        <live-tape @addPlan="addPlan()"></live-tape>
    </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapePlanBudget.vue";
import ChartsBudget from "../components/ChartBudget.vue";
import BarPlan from "../components/BarPlan.vue";
import Preloader from "../components/Preloader.vue";
import Swiper from "../components/SwiperCards.vue";
import {ref} from "vue";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const refresh = ref(true);
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}

const addPlan = () => {
    refresh.value = false
    setTimeout(() => {
        refresh.value = true;
    }, 400);
}
</script>
