<template>
    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header">
            <button class="profile__mobile-btn" @click="openMenu()"><img src="../assets/img/svg/arrowBlack.svg" alt=""><img
                src="../assets/img/svg/arrowBlack.svg" alt=""></button>
            <h1 class="title title--2">Главная</h1>
        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__content">
            <template v-if="refresh">
                <div class="profile__content-item">
                    <charts-expenses-income>
                        <template v-slot:title>
                            Общий график
                        </template>
                    </charts-expenses-income>
                </div>
                <div class="profile__content-item">
                    <bar-plan-category>
                        <template v-slot:title>
                            Планы по категориям
                        </template>
                    </bar-plan-category>
                </div>
                <div class="profile__content-item__two-case">

                    <bar-expenses-income>
                        <template v-slot:title>
                            График
                        </template>
                    </bar-expenses-income>
                </div>
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
import LiveTape from "../components/LiveTapePlan.vue";
import ChartsExpensesIncome from "../components/ChartExpensesIncome.vue";
import BarPlanCategory from "../components/BarPlanCategory.vue";
import Preloader from "../components/Preloader.vue";
import BarExpensesIncome from "../components/BarEpensesIncome.vue";
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
