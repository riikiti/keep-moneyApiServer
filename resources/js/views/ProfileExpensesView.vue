<template>

    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header">
            <h1 class="title title--2">Расходы</h1>
        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__content">
            <template  v-if="refresh">
            <div class="profile__content-item__two-case">
                <bar-expenses>
                    <template v-slot:title>
                        Расходы
                    </template>
                </bar-expenses>
            </div>
            <div class="profile__content-item">
                <charts-expenses-with-select>
                    <template v-slot:title>
                        Расходы по :
                    </template>
                </charts-expenses-with-select>
            </div>
            <div class="profile__content-item">
                <charts-expenses>
                    <template v-slot:title>
                        Расходы
                    </template>
                </charts-expenses>
            </div>
            </template>
            <div v-else>
                <preloader></preloader>
            </div>
        </div>

        <live-tape @addExpenses="addExpenses()"></live-tape>
    </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapeExpenses.vue";
import ChartsExpensesWithSelect from "../components/ChartExpensesWithSelect.vue";
import ChartsExpenses from "../components/ChartExpenses.vue";
import Preloader from "../components/Preloader.vue";
import BarExpenses from "../components/BarEpenses.vue";
import {ref} from "vue";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const refresh = ref(true);
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}

const addExpenses = () => {
    refresh.value = false
    setTimeout(() => {
        refresh.value = true;
    }, 400);
}
</script>


