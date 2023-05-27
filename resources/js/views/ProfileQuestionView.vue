<template>

    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header-question">
            <h1 class="title title--2">Часто задаваемые вопросы?</h1>

        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__question">
            <div class="profile__question-subheader">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur assumenda commodi dicta eaque
                    error
                    fugit id incidunt iure laborum modi natus nobis, numquam officia praesentium quam, quod sit, unde
                    voluptas.</p>
            </div>
            <div class="accordions__wrap">
                <accordion>
                    <template v-slot:title>
                        Общий график
                    </template>
                    <template v-slot:content>
                        Общий график
                    </template>
                </accordion>
                <accordion>
                    <template v-slot:title>
                        Общий график
                    </template>
                    <template v-slot:content>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aperiam, at autem ex
                        explicabo
                        fugit hic ipsam quisquam recusandae sint, temporibus unde? Dolores libero minus, nostrum officia
                        pariatur suscipit voluptas.
                    </template>
                </accordion>
                <accordion>
                    <template v-slot:title>
                        Общий график
                    </template>
                    <template v-slot:content>
                        Общий график
                    </template>
                </accordion>
            </div>
        </div>
    </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import Accordion from "../components/Accordion.vue";
import {ref} from "vue";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const openMenu = () => {
    menu.value = !menu.value
    localStorage.setItem("is_expanded", menu.value)
    console.log(menu.value)
}
</script>
