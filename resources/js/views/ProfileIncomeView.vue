<template>

    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header">
            <button class="profile__mobile-btn" @click="openMenu()"><img src="../assets/img/svg/arrowBlack.svg" alt=""><img
                src="../assets/img/svg/arrowBlack.svg" alt=""></button>
            <h1 class="title title--2">Доходы</h1>
        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__content">
            <template v-if="refresh">
                <div class="profile__content-item__two-case">
                    <bar-income>
                        <template v-slot:title>
                            Доходы
                        </template>
                    </bar-income>
                </div>
                <div class="profile__content-item">
                    <charts-income-with-select>
                        <template v-slot:title>
                            Доходы по
                        </template>
                    </charts-income-with-select>
                </div>
                <div class="profile__content-item">
                    <charts-income>
                        <template v-slot:title>
                            Доходы
                        </template>
                    </charts-income>
                </div>
            </template>
            <div v-else>
                <preloader></preloader>
            </div>
        </div>

        <live-tape @addIncome="addIncome()"></live-tape>
    </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapeIncome.vue";
import ChartsIncome from "../components/ChartIncome.vue";
import ChartsIncomeWithSelect from "../components/ChartIncomeWithSelect.vue";
import BarIncome from "../components/BarIncome.vue";
import Preloader from "../components/Preloader.vue";
import {ref} from "vue";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const refresh = ref(true);
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}

const addIncome = () => {
    refresh.value = false
    setTimeout(() => {
        refresh.value = true;
    }, 400);
}

</script>

