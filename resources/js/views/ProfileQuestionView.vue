<template>

    <div class="profile" :class="{ 'profile-active': menu}">
        <h1 class="title title--2">Часто задаваемые вопросы?</h1>
        здесть будет аккордион с вопросами
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
    </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import {ref} from "vue";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}
</script>
