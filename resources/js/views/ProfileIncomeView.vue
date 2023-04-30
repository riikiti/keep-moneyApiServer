<template>

    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header">
            <h1 class="title title--2">Доходы</h1>
        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__content">
            <div class="profile__content-item__two-case">
                <h2 class="title title--3">Доходы</h2>
                <bar-income></bar-income>
            </div>
            <div class="profile__content-item"><h2 class="title title--3">Доходы по конкретной категории</h2>
                <charts-income></charts-income>
            </div>
            <div class="profile__content-item"><h2 class="title title--3">Доходы по всем категориям</h2>
                <charts-income></charts-income>
            </div>
        </div>
        <live-tape></live-tape>
    </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapeIncome.vue";
import ChartsIncome from "../components/ChartIncome.vue";
import BarIncome from "../components/BarIncome.vue";
import {ref} from "vue";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}
</script>

