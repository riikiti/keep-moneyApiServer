<template>
    <div class="profile__livetape">
        <div class="profile__livetape-button">
            <button class="button" @click="modalCreate()">Создать запись</button>
            <div v-if="modalForCreate">
                <Modal :status="modalForCreate" @modalClose="modalCreate()">
                    <template v-slot:modalContent>
                        <form class="form" @submit.prevent="modalOpen()">
                            <h2 class="title title--2">Создание записи</h2>
                            <div class="form__block">
                                <label class="title title--3">Название</label>
                                <input type="text" v-model="createData.title" required/>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Список покупок</label>
                                <ul class="form__block-lists">
                                    <li v-for="item in items" :key="item.id">
                                        <p>Название:</p> <input type="text" v-model="item.name">
                                        <p>Цена:</p><input type="text" v-model="item.price" @blur='totalPriceSum()'>
                                        <p>р.</p>
                                        <p>Кол-во:</p> <input type="text" v-model="item.count" @blur='totalPriceSum()'>
                                        <p>шт.</p>
                                        <div class="form__block-lists__delete" @click="removeItem(item.id)">
                                            <img src="../assets/img/svg/exit.svg" alt="exit">
                                        </div>
                                    </li>
                                </ul>
                                <div class="form__block-lists__add" @click="addItem()"> + добавить новую запись</div>
                                <div class="form__block-price">
                                    <label class="title title--3">Итоговая цена: </label>
                                    <p>{{ totalPrice }} р.</p>
                                </div>
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

                            <div class="form__block">
                                <label class="title title--3">Адресс магазина</label>
                                <input type="text" v-model="createData.address" required/>
                            </div>
                            <button class="form__btn" @click="posthData(createData)">
                                Создать
                            </button>
                        </form>
                    </template>
                </Modal>
            </div>
        </div>
        <div class="profile__content-livetape__header">
            <h2 class="title title--2">Последние действия</h2>
        </div>
        <div v-if="data == null">
            <Preloader></Preloader>
        </div>
        <ul v-else>
            <li v-for="(item, index) in data" :key="item.id" class="item">
                <div v-if="modal && modalIndex === index">
                    <Modal :status="modal" :item="item" @modalClose="modalOpen()">
                        <template v-slot:modalContent>
                            <form class="form" @submit.prevent="modalOpen()">
                                <h2 class="title title--2">Изаменение записи "{{ item.checks.title }}"</h2>
                                <div class="form__block">
                                    <label class="title title--3">Название</label>
                                    <input type="text" v-model="item.checks.title" required/>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Список покупок</label>
                                    <ul class="form__block-lists">
                                        {{ getItemsUpdate(item.checks.id) }}
                                        <li v-for="el in getItemsNew" :key="item.id">
                                            <p>Название:</p> <input type="text" v-model="el.name">
                                            <p>Цена:</p><input type="text" v-model="el.price"
                                                               @blur='totalPriceSumUpdate()'>
                                            <p>р.</p>
                                            <p>Кол-во:</p> <input type="text" v-model="el.count"
                                                                  @blur='totalPriceSumUpdate()'>
                                            <p>шт.</p>
                                            <div class="form__block-lists__delete" @click="removeItemUpdate(el.id)">
                                                <img src="../assets/img/svg/exit.svg" alt="exit">
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="form__block-lists__add" @click="addItemUpdate()"> + добавить новую запись
                                    </div>
                                    <div class="form__block-price">
                                        <label class="title title--3">Итоговая цена: </label>
                                        <p v-if="totalPriceUpdate===0">{{ item.checks.total_price }} р.</p>
                                        <p v-else>{{ totalPriceUpdate }} р.</p>
                                    </div>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Категория</label>
                                    <categories-selector :option="categories"
                                                         @getSelect="getSelect"
                                                         :id="item.category.id"
                                    ></categories-selector>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Дата</label>
                                    <VueDatePicker
                                        v-model="item.checks.date"
                                        locale="ru"
                                        vertical
                                        :startDate="new Date()"
                                        format=" dd/MM/yyyy HH:mm"
                                        required
                                    />
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Адресс магазина</label>
                                    <input type="text" v-model="item.shop.id" required/>
                                </div>
                                <button class="form__btn" @click="updateData(item.id, item)">
                                    Изменить
                                </button>
                            </form>
                        </template>
                    </Modal>
                </div>
                <div class="item__content">
                    <h3 class="title title--4">{{ item.checks.title }}</h3>
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
    </div>
</template>

<script setup>
import Modal from "../components/Modal.vue";
import Preloader from "../components/Preloader.vue";
import CategoriesSelector from "../components/CategoriesSelector.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import {computed, onMounted, ref} from "vue";
import axios from "axios";


const data = ref(null);
const modal = ref(false);
const modalIndex = ref(null);
const modalForCreate = ref(false);
const createData = ref([]);
const categories = ref(null);
const id = localStorage.getItem('id');
const selectCategories = ref({});
const items = ref([]);
const item = ref('');
const totalPrice = ref(0)
const totalPriceUpdate = ref(0)
const checkId = ref(null);
const getItems = ref([]);
const getItemsNew = ref([]);
let count = 1


const addItem = () => {
    items.value.push({name: '', price: 0, count: 1, id: count});
    count++;
}

const addItemUpdate = () => {
    getItemsNew.value.push({name: '', price: 0, count: 1, id: count});
    count++;
}


const getItemsUpdate = (id) => {
    getItems.value.forEach((el) => {
        console.log(el)
        if (el.id === id) {
            console.log(el.items)
            getItemsNew.value = el.items;
        }
    })
}

const totalPriceSum = () => {
    totalPrice.value = 0
    items.value.forEach((el) => {
        console.log(el.price)
        totalPrice.value += Number(el.price) * Number(el.count);
    })
}


const totalPriceSumUpdate = () => {
    totalPriceUpdate.value = 0
    getItemsNew.value.forEach((el) => {
        console.log(el.price)
        totalPriceUpdate.value += Number(el.price) * Number(el.count);
    })
}


const removeItem = (index) => {
    items.value.forEach((el, i) => {
        if (el.id === index) {
            items.value.splice(i, 1);
        }
    })
    totalPriceSum()
}


const removeItemUpdate = (index) => {
    getItemsNew.value.forEach((el, i) => {
        console.log(el.id)
        if (el.id === index) {
            getItemsNew.value.splice(i, 1);
        }
    })
    totalPriceSumUpdate()
}

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
const fetchData = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/expenses/' + id)
        .then((response) => {
            data.value = response.data.data;
            data.value.forEach((el) => {
                getItems.value.push(el.checks)
                //console.log(getItems.value)
            })
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
    console.log(createData.title, totalPrice, createData.date)
    axios
        .post("http://127.0.0.1:8000/api/v1/check", {
            title: createData.title,
            total_price: totalPrice.value,
            date: createData.date,
        })
        .then((response) => {
            // console.log(response.data);
            checkId.value = response.data.id;
            console.log(checkId.value)

            console.log(items.value);
            items.value.forEach((el) => {
                console.log(el.name, el.price, el.count, checkId.value);
                axios
                    .post("http://127.0.0.1:8000/api/v1/item", {
                        name: el.name,
                        price: el.price,
                        count: el.count,
                        check_id: checkId.value
                    })
                    .then((response) => {
                        console.log(response.data);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            })
            axios
                .post("http://127.0.0.1:8000/api/v1/expenses", {
                    user_id: id,
                    check_id: checkId.value,
                    shops_id: 1,
                    categories_id: selectCategories.id
                })
                .then((response) => {
                    console.log(response.data);
                    modalCreate()

                })
                .catch((error) => {
                    console.log(error);
                });
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
        .get('http://127.0.0.1:8000/api/v1/categories')
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
