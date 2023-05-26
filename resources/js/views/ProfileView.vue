<template>
    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header">
            <h1 class="title title--2">Главная</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium asperiores beatae blanditiis
                doloribus error esse eveniet facere, magni quos totam?</p>
        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__content">
            <div class="profile__content-item">
                <charts-expenses>
                    <template v-slot:title>
                        Расходы
                    </template>
                </charts-expenses>
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
        </div>
        <live-tape></live-tape>
    </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapePlan.vue";
import ChartsExpenses from "../components/ChartExpenses.vue";
import BarPlanCategory from "../components/BarPlanCategory.vue";
import BarExpensesIncome from "../components/BarEpensesIncome.vue";
import {ref} from "vue";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}


</script>
