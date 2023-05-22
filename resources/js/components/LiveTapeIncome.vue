<template>
    <div class="profile__livetape">
        <div class="profile__livetape-button">
            <button class="button" @click="modalCreate()">Создать запись</button>
            <teleport to=".modals" v-if="modalForCreate">
                <Modal :status="modalForCreate" @modalClose="modalCreate()">
                    <template v-if="!formSubmitted" v-slot:modalContent>
                        <form class="form" @submit.prevent="modalOpen()">
                            <h2 class="title title--2">Создание записи</h2>
                            <div class="form__block">
                                <label class="title title--3">Название</label>
                                <input type="text" v-model="createData.title"/>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Цена</label>
                                <input type="number" v-model="createData.price" required/>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Категория</label>
                                <categories-selector :option="categories"
                                                     @getSelect="getSelect"
                                >
                                    <template v-slot:title>
                                        Выберите категорию
                                    </template>
                                </categories-selector>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Категория</label>
                                <budget-selector :option="categoriesBudget"
                                                 @getSelect="getSelectBudget"
                                ></budget-selector>
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
                    <template v-else v-slot:modalContent>
                        <div class="form__submitted">
                            <div class="form__submitted-logo">
                                <img src="../assets/img/svg/complete.webp" alt="confirm">
                            </div>
                            <h2 class="title title--2">Запись успешно создана</h2>
                            <button class="form__btn" @click="modalCreate()">
                                Закрыть
                            </button>
                        </div>
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
                    {{ memberOldValue(item.price, item.budget.id) }}
                    <teleport to=".modals" v-if="modal && modalIndex === index">
                        <Modal :status="modal" :item="item" @modalClose="modalOpen()">
                            <template v-if="!formSubmittedUpdated" v-slot:modalContent>
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
                                        >
                                            <template v-slot:title>
                                                Выберите категорию
                                            </template>
                                        </categories-selector>
                                    </div>
                                    <div class="form__block">
                                        <label class="title title--3">Категория</label>
                                        <budget-selector :option="categoriesBudget"
                                                         @getSelect="getSelectBudget"
                                                         :id="item.budget.id"
                                        ></budget-selector>
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
                                    <button class="form__btn" @click.prevent="updateData(item.id, item)">
                                        Изменить
                                    </button>
                                </form>
                            </template>
                            <template v-else v-slot:modalContent>
                                <div class="form__submitted">
                                    <div class="form__submitted-logo">
                                        <img src="../assets/img/svg/complete.webp" alt="confirm">
                                    </div>
                                    <h2 class="title title--2">Запись успешно изменена</h2>
                                    <button class="form__btn" @click="modalOpen()">
                                        Закрыть
                                    </button>
                                </div>
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
import BudgetSelector from "../components/BudgetSelector.vue";
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
const categoriesBudget = ref(null);
const id = localStorage.getItem('id');
const selectCategories = ref({});
const selectBudget = ref({});
const formSubmitted = ref(false);
const formSubmittedUpdated = ref(false);
let oldPrice = [];
let oldId = 0;


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


const getSelectBudget = (item) => {
    console.log(item.id)
    selectBudget.id = item.id
    selectBudget.budget = item.budget
    console.log(selectBudget.id)
}

const memberOldValue = (price, id) => {
    oldPrice.push(Number(price));
    oldId = Number(id);
}

const fetchData = async (page) => {
    if (!page) {
        page = 1;
    }
    axios
        .get('http://127.0.0.1:8000/api/v1/income/' + id, {params: {page: page, paginate: true, per_page: 5}})
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
    if (!createData.title) {
        createData.title = selectCategories.name.toString() + " " + createData.date.slice(0, 11);
    }
    console.log(selectBudget.id)

    axios
        .post("http://127.0.0.1:8000/api/v1/income", {
            title: createData.title,
            price: createData.price,
            categories_id: selectCategories.id,
            date: createData.date,
            user_id: id,
            budget_id: selectBudget.id
        })
        .then((response) => {
            console.log(response.data);
            formSubmitted.value = true;
            //modalCreate();
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
    axios
        .put("http://127.0.0.1:8000/api/v1/increase-budget/" + selectBudget.id, {
            update_budget: createData.price,
        })
        .then((response) => {
            console.log(response);
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
    if (!selectCategories.id) {
        selectCategories.id = item.category.id
        selectCategories.name = item.category.name
    }

    if (item.title === "") {
        item.title = selectCategories.name + " " + item.date.slice(0, 11);
    }
    console.log("item price", item.price, "old price", oldPrice)
    if (!selectBudget.id) {
        selectBudget.id = item.budget.id
        selectBudget.name = item.budget.name
        console.log(selectCategories.id, item.category.id)
        axios
            .put("http://127.0.0.1:8000/api/v1/income/" + item.id, {
                title: item.title,
                price: item.price,
                categories_id: selectCategories.id,
                date: item.date,
                user_id: id,
                budget_id: selectBudget.id
            })
            .then((response) => {
                console.log(response.data);
                formSubmittedUpdated.value = true;
                fetchData();
            })
            .catch((error) => {
                console.log(error);
            });

        axios
            .put("http://127.0.0.1:8000/api/v1/reduse-budget/" + selectBudget.id, {
                update_budget: oldPrice[0],
            })
            .then((response) => {
                console.log(response.data);
            })
            .catch((error) => {
                console.log(error);
            });
        axios
            .put("http://127.0.0.1:8000/api/v1/increase-budget/" + selectBudget.id, {
                update_budget: item.price,
            })
            .then((response) => {
                console.log(response.data);
            })
            .catch((error) => {
                console.log(error);
            });


    } else {
        console.log(selectCategories.id, item.category.id)
        axios
            .put("http://127.0.0.1:8000/api/v1/income/" + item.id, {
                title: item.title,
                price: item.price,
                categories_id: selectCategories.id,
                date: item.date,
                user_id: id,
                budget_id: selectBudget.id
            })
            .then((response) => {
                console.log(response.data);
                formSubmittedUpdated.value = true;
                fetchData();
            })
            .catch((error) => {
                console.log(error);
            });

        axios
            .put("http://127.0.0.1:8000/api/v1/reduse-budget/" + oldId, {
                update_budget: oldPrice[0],
            })
            .then((response) => {
                console.log(response);
            })
            .catch((error) => {
                console.log(error);
            });
        axios
            .put("http://127.0.0.1:8000/api/v1/increase-budget/" + selectBudget.id, {
                update_budget: item.price,
            })
            .then((response) => {
                console.log(response);
            })
            .catch((error) => {
                console.log(error);
            });
    }


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

const fetchCategoriesBudget = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/budget/' + id)
        .then((response) => {
            categoriesBudget.value = response.data.data;
            console.log(categoriesBudget.value)
        })
        .catch((error) => {
            console.log(error);
        });
};

fetchCategoriesBudget()


fetchCategories()
onMounted(fetchData, posthData, deleteData, updateData, fetchCategories);
</script>
