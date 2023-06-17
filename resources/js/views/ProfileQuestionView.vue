<template>

    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header-question">
            <button class="profile__mobile-btn" @click="openMenu()"><img src="../assets/img/svg/arrowBlack.svg" alt=""><img
                src="../assets/img/svg/arrowBlack.svg" alt=""></button>
            <h1 class="title title--2">Часто задаваемые вопросы?</h1>

        </div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__question">
            <div class="profile__question-subheader">
                <p>Здесь собраны самые популярные вопросы которые, возникают у пользователей сервиса.</p>
            </div>
            <div class="accordions__wrap">
                <accordion>
                    <template v-slot:title>
                       Почему не получается добавить расходы?
                    </template>
                    <template v-slot:content>
                        Скорее всего у вас не создана карта, с которой происходит взаимодействие при создание новой записи в разделе "расходы". Если созданая карта не отображается в разделе "Бюджет" попробуйте обновить страницу.
                    </template>
                </accordion>
                <accordion>
                    <template v-slot:title>
                        Почему не получилось создать план по категории?
                    </template>
                    <template v-slot:content>
                        Проверьте существуют ли расходы за этот периуд в данной категории, если нет, то они и не отобразятся в разделе "Планы по категории"
                    </template>
                </accordion>
                <accordion>
                    <template v-slot:title>
                        Почему при создание расходов, кнопка "создать" не активна?
                    </template>
                    <template v-slot:content>
                        Кнопка создания становится доступной после добавления хотябы одного товара в "Список покупок"
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
