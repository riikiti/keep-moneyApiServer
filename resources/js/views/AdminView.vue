<template>
    <div class="profile" :class="{ 'profile-active': menu}">
        <div class="profile__header-question">
            <button class="profile__mobile-btn" @click="openMenu()"><img src="../assets/img/svg/arrowBlack.svg"
                                                                         alt=""><img
                src="../assets/img/svg/arrowBlack.svg" alt=""></button>
            <h1 class="title title--2">Admin panel</h1></div>
        <ProfileAside @openMenu="openMenu()"></ProfileAside>
        <div class="profile__question">
            <ul class="profile__question__navbar">
                <li @click="getUsers()"><span>Пользователи</span></li>
                <li @click="getCategories()"><span>Категории - Расходы</span></li>
                <li @click="getCategoriesIncome()"><span>Категории - Доходы</span></li>
            </ul>
            <template v-if="refresh">
                <template v-if="users">
                    <ul class="profile__question-table">
                        <li class="item" v-for="item in data" :key="item.id">
                            <div class="item__content"><h3 class="title title--4"> {{ item.name }} - {{ item.email }} -
                                <span v-if="!item.admin">Пользователь</span><span v-else>Админ</span></h3>
                                <div class="item-action">
                                    <button @click="deleteUser(item.id,item)"><img src="../assets/img/svg/trash.svg"
                                                                                   alt="delete"/></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="profile__livetape-pagination" v-if="links && links.last_page>1">
                        <div class="profile__livetape-pagination__wrap-item" v-if="current_page!==1"
                             @click="fetchCategories(Number(current_page-1))"><img
                            src="../assets/img/svg/arrowBlack.svg" alt="arrow"></div>
                        <div class="profile__livetape-pagination__wrap" v-for="link in links.links" :key="link.label">
                            <div class="profile__livetape-pagination__wrap-item"
                                 v-if="Number(link.label)  && current_page -link.label <2 && current_page -link.label >-2"
                                 @click="fetchCategories(Number(link.label))" :class="link.active?'active':''">
                                {{ link.label }}
                            </div>
                        </div>
                        <div
                            class="profile__livetape-pagination__wrap-item  profile__livetape-pagination__wrap-item__next"
                            v-if="current_page!== links.last_page" @click="fetchCategories(Number(current_page+1))"><img
                            src="../assets/img/svg/arrowBlack.svg" alt="arrow"></div>
                    </div>
                </template>
                <template v-if="categories">
                    <form class="form"><h2 class="title title--2">Создание категории</h2>
                        <div class="form__block"><label class="title title--3">Название</label> <input type="text"
                                                                                                       v-model="titleForCategories"/>
                        </div>
                        <button class="form__btn" @click.prevent="postCategories()"> Создать</button>
                    </form>
                    <ul class="profile__question-table">
                        <li class="item" v-for="item in data" :key="item.id">
                            <div class="item__content"><h3 class="title title--4">{{ item.name }}</h3>
                                <div class="item-action">
                                    <button @click="deleteCategories(item.id)"><img src="../assets/img/svg/trash.svg"
                                                                                    alt="delete"/></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="profile__livetape-pagination" v-if="links && links.last_page>1">
                        <div class="profile__livetape-pagination__wrap-item" v-if="current_page!==1"
                             @click="fetchCategories(Number(current_page-1))"><img
                            src="../assets/img/svg/arrowBlack.svg" alt="arrow"></div>
                        <div class="profile__livetape-pagination__wrap" v-for="link in links.links" :key="link.label">
                            <div class="profile__livetape-pagination__wrap-item"
                                 v-if="Number(link.label)  && current_page -link.label <2 && current_page -link.label >-2"
                                 @click="fetchCategories(Number(link.label))" :class="link.active?'active':''">
                                {{ link.label }}
                            </div>
                        </div>
                        <div
                            class="profile__livetape-pagination__wrap-item  profile__livetape-pagination__wrap-item__next"
                            v-if="current_page!== links.last_page" @click="fetchCategories(Number(current_page+1))"><img
                            src="../assets/img/svg/arrowBlack.svg" alt="arrow"></div>
                    </div>
                </template>
                <template v-if="categoriesIncome">
                    <form class="form"><h2 class="title title--2">Создание категории доходов</h2>
                        <div class="form__block"><label class="title title--3">Название</label> <input type="text"
                                                                                                       v-model="titleForCategoriesIncome"/>
                        </div>
                        <button class="form__btn" @click.prevent="postCategoriesIncome()"> Создать</button>
                    </form>
                    <ul class="profile__question-table">
                        <li class="item" v-for="item in data" :key="item.id">
                            <div class="item__content"><h3 class="title title--4">{{ item.name }}</h3>
                                <div class="item-action">
                                    <button @click="deleteIncomeCategories(item.id)"><img
                                        src="../assets/img/svg/trash.svg" alt="delete"/></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="profile__livetape-pagination" v-if="links && links.last_page>1">
                        <div class="profile__livetape-pagination__wrap-item" v-if="current_page!==1"
                             @click="fetchCategories(Number(current_page-1))"><img
                            src="../assets/img/svg/arrowBlack.svg" alt="arrow"></div>
                        <div class="profile__livetape-pagination__wrap" v-for="link in links.links" :key="link.label">
                            <div class="profile__livetape-pagination__wrap-item"
                                 v-if="Number(link.label)  && current_page -link.label <2 && current_page -link.label >-2"
                                 @click="fetchCategories(Number(link.label))" :class="link.active?'active':''">
                                {{ link.label }}
                            </div>
                        </div>
                        <div
                            class="profile__livetape-pagination__wrap-item  profile__livetape-pagination__wrap-item__next"
                            v-if="current_page!== links.last_page" @click="fetchCategories(Number(current_page+1))"><img
                            src="../assets/img/svg/arrowBlack.svg" alt="arrow"></div>
                    </div>
                </template>
            </template>
            <div v-else>
                <preloader></preloader>
            </div>
        </div>
    </div>
</template>
<script setup> import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTapePlan.vue";
import ChartsExpensesIncome from "../components/ChartExpensesIncome.vue";
import BarPlanCategory from "../components/BarPlanCategory.vue";
import Preloader from "../components/Preloader.vue";
import BarExpensesIncome from "../components/BarEpensesIncome.vue";
import {ref} from "vue";
import axios from "axios";

const menu = ref(ref(localStorage.getItem("is_expanded") === "true"));
const refresh = ref(true);
const links = ref(null);
const current_page = ref(null);
const users = ref(true);
const categories = ref(false);
const categoriesIncome = ref(false);
const titleForCategories = ref('')
const titleForCategoriesIncome = ref('')
const data = ref(null);
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
const getUsers = () => {
    users.value = true;
    categories.value = false;
    categoriesIncome.value = false;
    fetchCategories()
    addPlan()
}
const getCategories = () => {
    users.value = false;
    categories.value = true;
    categoriesIncome.value = false;
    fetchCategories()
    addPlan()
}
const getCategoriesIncome = () => {
    users.value = false;
    categories.value = false;
    categoriesIncome.value = true;
    fetchCategories()
    addPlan()
}
const fetchCategories = async (page) => {
    if (!page) {
        page = 1;
    }
    if (users.value) {
        axios.get('https://keepmoney.site/api/v1/users', {
            params: {
                page: page,
                paginate: true,
                per_page: 8
            }
        }).then((response) => {
            data.value = response.data.data;
            console.log(data.value)
            links.value = response.data.meta
            current_page.value = response.data.meta.current_page;
        }).catch((error) => {
            console.log(error);
        });
    }
    if (categories.value) {
        axios.get('https://keepmoney.site/api/v1/categories', {
            params: {
                page: page,
                paginate: true,
                per_page: 8
            }
        }).then((response) => {
            data.value = response.data.data;
            console.log(data.value)
            links.value = response.data.meta
            current_page.value = response.data.meta.current_page;
        }).catch((error) => {
            console.log(error);
        });
    }
    if (categoriesIncome.value) {
        axios.get('https://keepmoney.site/api/v1/income-categories', {
            params: {
                page: page,
                paginate: true,
                per_page: 8
            }
        }).then((response) => {
            data.value = response.data.data;
            links.value = response.data.meta
            current_page.value = response.data.meta.current_page;
            console.log(data.value)
        }).catch((error) => {
            console.log(error);
        });
    }
};
fetchCategories()
const deleteUser = async (id, item) => {
    axios.delete(`https://keepmoney.site/api/v1/users/${id}`).then((response) => {
        console.log(response.data);
        fetchCategories()
        addPlan()
    }).catch((error) => {
        console.log(error);
    });
};
const deleteCategories = async (id) => {
    console.log(id)
    axios.delete(`https://keepmoney.site/api/v1/categories/${id}`).then((response) => {
        console.log(response.data);
        fetchCategories()
        addPlan()
    }).catch((error) => {
        console.log(error);
    });
};
const deleteIncomeCategories = async (id) => {
    console.log(id)
    axios.delete(`https://keepmoney.site/api/v1/income-categories/${id}`).then((response) => {
        console.log(response.data);
        fetchCategories()
        addPlan()
    }).catch((error) => {
        console.log(error);
    });
};
const postCategories = () => {
    axios.post("https://keepmoney.site/api/v1/categories", {name: titleForCategories.value,}).then((response) => {
        console.log(response.data);
        addPlan()
        fetchCategories()
        titleForCategories.value = ""
    }).catch((error) => {
        console.log(error);
    });
}
const postCategoriesIncome = () => {
    axios.post("https://keepmoney.site/api/v1/income-categories", {name: titleForCategoriesIncome.value,}).then((response) => {
        console.log(response.data);
        addPlan()
        fetchCategories()
        titleForCategoriesIncome.value = ""
    }).catch((error) => {
        console.log(error);
    });
} </script>
