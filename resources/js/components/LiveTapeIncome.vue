<template>
    <div class="profile__livetape">
        <div class="profile__livetape-button">
            <button class="button" @click="modalCreate()">Создать запись</button>
            <teleport to=".modals" v-if="modalForCreate">
                <Modal :status="modalForCreate" @modalClose="modalCreate()">
                    <template v-slot:modalContent>
                        <form class="form" @submit.prevent="modalOpen()">
                            <h2 class="title title--2">Создание записи</h2>
                            <div class="form__block">
                                <label class="title title--3">Название</label>
                                <input type="text" v-model="createData.title" required/>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Цена</label>
                                <input type="number" v-model="createData.price" required/>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Категория</label>
                                <categories-selector :option="categories"
                                                     @getSelect="getSelect"
                                ></categories-selector>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Дата</label>
                                <VueDatePicker
                                    v-model="createData.date"
                                    locale="ru"
                                    vertical
                                    :startDate="new Date()"
                                    format=" dd/MM/yyyy HH:mm"
                                    required
                                />
                            </div>
                            <button class="form__btn" @click="posthData(createData)">
                                Создать
                            </button>
                        </form>
                    </template>
                </Modal>
            </teleport>
        </div>
        <div class="profile__content-livetape__header">
            <h2 class="title title--2">Прибыль</h2>
        </div>
        <div class="profile__livetape-content">
            <div v-if="data == null">
                <Preloader></Preloader>
            </div>
            <ul v-else>
                <li v-for="(item, index) in data" :key="item.id" class="item">
                    <teleport to=".modals" v-if="modal && modalIndex === index">
                        <Modal :status="modal" :item="item" @modalClose="modalOpen()">
                            <template v-slot:modalContent>
                                <form class="form" @submit.prevent="modalOpen()">
                                    <h2 class="title title--2">Изаменение записи "{{ item.title }}"</h2>
                                    <div class="form__block">
                                        <label class="title title--3">Изаменение названия</label>
                                        <input type="text" v-model="item.title"/>
                                    </div>
                                    <div class="form__block">
                                        <label class="title title--3">Изаменение цены</label>
                                        <input type="number" v-model="item.price"/>
                                    </div>
                                    <div class="form__block">
                                        <label class="title title--3">Изаменение категории</label>
                                        <categories-selector :option="categories"
                                                             @getSelect="getSelect"
                                                             :id="item.category.id"
                                        ></categories-selector>
                                    </div>
                                    <div class="form__block">
                                        <label class="title title--3">Изаменение даты</label>
                                        <VueDatePicker
                                            v-model="item.date"
                                            locale="ru"
                                            vertical
                                            :startDate="new Date()"
                                            format="dd/MM/yyyy HH:mm"
                                        />
                                    </div>
                                    <button class="form__btn" @click="updateData(item.id, item)">
                                        Изменить
                                    </button>
                                </form>
                            </template>
                        </Modal>
                    </teleport>
                    <div class="item__content">
                        <h3 class="title title--4">{{ item.title }}</h3>
                        <div class="item-action">
                            <button @click="modalOpen(index)" :data-item="item.id">
                                <img src="../assets/img/svg/pen.svg" alt="update"/>
                            </button>
                            <button @click="deleteData(item.id)">
                                <img src="../assets/img/svg/trash.svg" alt="delete"/>
                            </button>
                        </div>
                    </div>
                </li>
            </ul>
            <div class="profile__livetape-pagination" v-if="links && links.last_page>1">
                <div class="profile__livetape-pagination__wrap-item" v-if="current_page!==1"
                     @click="fetchData(Number(current_page-1))"><img src="../assets/img/svg/arrowBlack.svg" alt="arrow">
                </div>
                <div class="profile__livetape-pagination__wrap" v-for="link in links.links" :key="link.label">
                    <div class="profile__livetape-pagination__wrap-item"
                         v-if="Number(link.label)  && current_page -link.label <2 && current_page -link.label >-2"
                         @click="fetchData(Number(link.label))" :class="link.active?'active':''">{{ link.label }}
                    </div>
                </div>
                <div class="profile__livetape-pagination__wrap-item  profile__livetape-pagination__wrap-item__next"
                     v-if="current_page!== links.last_page"
                     @click="fetchData(Number(current_page+1))">
                    <img src="../assets/img/svg/arrowBlack.svg" alt="arrow">
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Modal from "../components/Modal.vue";
import Preloader from "../components/Preloader.vue";
import CategoriesSelector from "../components/CategoriesSelector.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import {onMounted, ref} from "vue";
import axios from "axios";


const data = ref(null);
const links = ref(null);
const current_page = ref(null);
const modal = ref(false);
const modalIndex = ref(null);
const modalForCreate = ref(false);
const createData = ref([]);
const categories = ref(null);
const id = localStorage.getItem('id');
const selectCategories = ref({});

const getSelect = (item) => {
    console.log(item.id)
    selectCategories.id = item.id
    selectCategories.name = item.name
}

const modalOpen = (index) => {
    modalIndex.value = index;
    modal.value = !modal.value;
    console.log(modal.value);
};

const modalCreate = () => {
    modalForCreate.value = !modalForCreate.value;
    console.log(modalForCreate.value);
};

const fetchData = async (page) => {
    if (!page) {
        page = 1;
    }
    axios
        .get('http://127.0.0.1:8000/api/v1/income/' + id, {params: {page: page, per_page: 1}})
        .then((response) => {
            data.value = response.data.data;
            links.value = response.data.meta
            current_page.value = response.data.meta.current_page;
            console.log(links.value)
            console.log(data.value)
        })
        .catch((error) => {
            console.log(error);
        });
};
const posthData = async (createData) => {
    try {
        createData.date = createData.date.toISOString().substring(0, 19).replace("T", " ");
        console.log(createData)
    } catch {
    }
    axios
        .post("http://127.0.0.1:8000/api/v1/income", {
            title: createData.title,
            price: createData.price,
            categories_id: selectCategories.id,
            date: createData.date,
            user_id: id
        })
        .then((response) => {
            console.log(response.data);
            modalCreate();
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
};

const deleteData = async (id) => {
    axios
        .delete(`http://127.0.0.1:8000/api/v1/income/${id}`)
        .then((response) => {
            console.log(response.data);
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
};

const updateData = async (item_id, item) => {
    try {
        item.date = item.date.toISOString().substring(0, 19).replace("T", " ");
        console.log(item.date)
    } catch {
    }

    axios
        .put("http://127.0.0.1:8000/api/v1/income/" + item_id, {
            title: item.title,
            price: item.price,
            categories_id: selectCategories.id,
            date: item.date,
            user_id: id,
        })
        .then((response) => {
            console.log(response.data);
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
};

fetchData();

const fetchCategories = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/income-categories')
        .then((response) => {
            categories.value = response.data.data;
            console.log(categories.value)
        })
        .catch((error) => {
            console.log(error);
        });
};

fetchCategories()
onMounted(fetchData, posthData, deleteData, updateData, fetchCategories);
</script>
