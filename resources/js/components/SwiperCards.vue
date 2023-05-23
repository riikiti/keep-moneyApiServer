<template>

    <button class="button" @click="modalCreate()">Создать карту</button>
    <teleport to=".modals" v-if="modalForCreate">
        <Modal :status="modalForCreate" @modalClose="modalCreate()">
            <template v-if="!formSubmitted" v-slot:modalContent>
                <form class="form" @submit.prevent="modalOpen()">
                    <h2 class="title title--2">Создание карты</h2>
                    <div class="form__block">
                        <label class="title title--3">Банк</label>
                        <bank-selector :option="banks"
                                       @getSelect="getSelect"
                        ></bank-selector>
                    </div>

                    <div class="form__block">
                        <label class="title title--3">Тип карты</label>
                        <div class="form__block-radio">
                            <div class="form__block-radio__wrap">
                                <input type="radio" value="mir" v-model="createData.type">
                                <label>Mir</label>
                            </div>
                            <div class="form__block-radio__wrap">
                                <input type="radio" value="visa" v-model="createData.type">
                                <label>Visa</label>
                            </div>
                            <div class="form__block-radio__wrap">
                                <input type="radio" value="mc" v-model="createData.type">
                                <label>MasterCard</label>
                            </div>
                        </div>
                    </div>
                    <div class="form__block">
                        <label class="title title--3">Последние 4 цифры</label>
                        <input type="number" v-model="createData.numbers" required/>
                    </div>
                    <div class="form__block">
                        <label class="title title--3">Дата окончания карты</label>
                        <input type="text" v-model="createData.last_date" required/>
                    </div>
                    <div class="form__block">
                        <label class="title title--3">Количсетво денег на карте</label>
                        <input type="number" v-model="createData.budget" required/>
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
                    <h2 class="title title--2">Карта успешно создана</h2>
                    <button class="form__btn" @click="modalCreate()">
                        Закрыть
                    </button>
                </div>
            </template>
        </Modal>
    </teleport>
    <swiper :slides-per-view="1" :modules="modules" :pagination="true" :grab-cursor="true" class="swiper" v-if="data">
        <swiper-slide v-if="data.length===0">
            <div class="bank-card__wrap">
                <div class="bank-card__empty">
                    <h3 class="title title--3">
                        Карт не добавлено
                    </h3>
                    <p>добавьте карту для взаимодействия с ней.</p>
                </div>
            </div>
        </swiper-slide>
        <swiper-slide v-for="(item, index) in data" :key="item.id">
            <div class="bank-card__wrap">
                <div class="bank-card__content" :style="{ color: item.bank.text_color , background: item.bank.color }">
                    <img :src="cardBank(item.bank.name)" :alt="item.bank.name" class="bank-card__bank">
                    <div class="bank-card__action">
                        <button @click="modalOpenPlus(item)">+</button>
                        <button @click="modalOpenMinus(item)">-</button>
                        <img src="../assets/img/svg/pen.svg" alt="pen" @click="modalUpdate(index)">
                        <img src="../assets/img/svg/trashWhite.png" alt="trash" @click="deleteData(item.id)">
                    </div>
                    <div class="bank-card__numbers"><span>**** **** **** {{ item.numbers }}</span></div>
                    <div class="bank-card__date">
                        <span> м/г: {{ Math.floor(item.last_date / 100) + "/" + (item.last_date % 100) }}</span>
                    </div>
                    <div class="bank-card__info">
                        <span> на счету: {{ item.budget }} р. </span>
                        <img :src="cardType(item.type)" :alt="item.type" class="bank-card__type">
                    </div>
                </div>
            </div>

            <teleport to=".modals" v-if="modalPlus">
                <Modal :status="modalPlus" :item="modalItem" @modalClose="modalOpenPlus()">
                    <template v-slot:modalContent>
                        <form class="form" @submit.prevent="modalOpenPlus()">
                            <h2 class="title title--2">Добавить на счет</h2>
                            <div class="form__block">
                                <label class="title title--3">Значение</label>
                                <input type="number" v-model="plus" min="0" required/>
                            </div>
                            {{modalItem}}
                            <button class="form__btn" @click="increase(modalItem)">
                                Добавить
                            </button>
                        </form>
                    </template>
                </Modal>
            </teleport>
            <teleport to=".modals" v-if="modalMinus">
                <Modal :status="modalMinus" :item="modalItem" @modalClose="modalOpenMinus()">
                    <template v-slot:modalContent>
                        <form class="form" @submit.prevent="modalOpenMinus()">
                            <h2 class="title title--2">Вычесть из счета</h2>
                            <div class="form__block">
                                <label class="title title--3">Значение</label>
                                <input type="number" v-model="minus" min="0" required/>
                            </div>
                            <button class="form__btn" @click="reduse(modalItem)">
                                Убрать
                            </button>
                        </form>
                    </template>
                </Modal>
            </teleport>
            <teleport to=".modals" v-if="modalForUpdate && modalItem === index">
                <Modal :status="modalForUpdate" :item="modalItem" @modalClose="modalUpdate()">
                    <template v-if="!formSubmittedUpdated" v-slot:modalContent>
                        <form class="form">
                            <h2 class="title title--2">Создание карты</h2>
                            <div class="form__block">
                                <label class="title title--3">Банк</label>
                                <bank-selector :option="banks"
                                               @getSelect="getSelect"
                                               :id="item.bank.id"
                                ></bank-selector>
                            </div>

                            <div class="form__block">
                                <label class="title title--3">Тип карты</label>
                                <div class="form__block-radio">
                                    <div class="form__block-radio__wrap">
                                        <input type="radio" value="mir" v-model="item.type">
                                        <label>Mir</label>
                                    </div>
                                    <div class="form__block-radio__wrap">
                                        <input type="radio" value="visa" v-model="item.type">
                                        <label>Visa</label>
                                    </div>
                                    <div class="form__block-radio__wrap">
                                        <input type="radio" value="mc" v-model="item.type">
                                        <label>MasterCard</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Последние 4 цифры</label>
                                <input type="number" v-model="item.numbers" required/>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Дата окончания карты</label>
                                <input type="number" v-model="item.last_date" required/>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Количсетво денег на карте</label>
                                <input type="number" v-model="item.budget" required/>
                            </div>
                            <button class="form__btn" @click="updateData(item)">
                                Обновить
                            </button>
                        </form>
                    </template>
                    <template v-else v-slot:modalContent>
                        <div class="form__submitted">
                            <div class="form__submitted-logo">
                                <img src="../assets/img/svg/complete.webp" alt="confirm">
                            </div>
                            <h2 class="title title--2">Карта успешно изменена</h2>
                            <button class="form__btn" @click="modalUpdate()">
                                Закрыть
                            </button>
                        </div>
                    </template>
                </Modal>
            </teleport>
        </swiper-slide>
    </swiper>
    <div v-else>loading...</div>


</template>

<script setup>
import {Swiper, SwiperSlide} from "swiper/vue";
import {Navigation, Pagination, Scrollbar, A11y} from "swiper";
import "swiper/css";
import 'swiper/css/pagination';
import axios from "axios";
import {onMounted, ref} from "vue";
import Modal from "../components/Modal.vue";
import BankSelector from "../components/CategoriesSelector.vue";


const modules = [Pagination, Navigation, Scrollbar, A11y];
const modalPlus = ref(false);
const modalMinus = ref(false);
const modalForUpdate = ref(false);
const modalForCreate = ref(false);
const modalItem = ref(null);
const data = ref(null);
const type = ref(null);
let id = localStorage.getItem('id');
const dataForUpdate = ref({});
const createData = ref([]);
const selectCategories = ref({});
const banks = ref(null)
const minus=ref(0);
const plus=ref(0)
const formSubmitted = ref(false);
const formSubmittedUpdated = ref(false);


const getSelect = (item) => {
    console.log(item.id)
    selectCategories.id = item.id
    selectCategories.name = item.name
}


const increase=(item)=>{
    console.log(plus)
    axios
        .put("http://127.0.0.1:8000/api/v1/increase-budget/" + item.id, {
            update_budget: plus.value,
        })
        .then((response) => {
            console.log(response);
            plus.value=0;
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
}

const reduse = (item)=>{
    axios
        .put("http://127.0.0.1:8000/api/v1/reduse-budget/" + item.id, {
            update_budget: minus.value,
        })
        .then((response) => {
            console.log(response.data);
            minus.value=0
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
}

const fetchData = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/budget/' + id)
        .then((response) => {
            // console.log(response.data.data)
            data.value = response.data.data;
            console.log(data.value)
        })
        .catch((error) => {
            console.log(error);
        });
};


const posthData = async (createData) => {
    let id = localStorage.getItem('id');
    axios
        .post("http://127.0.0.1:8000/api/v1/budget", {
            type: createData.type,
            budget: createData.budget,
            bank_id: selectCategories.id,
            numbers: createData.numbers,
            last_date: Number(createData.last_date),
            user_id: id
        })
        .then((response) => {
            console.log(response.data);
            fetchData();
            formSubmitted.value = true;
            //modalCreate();

        })
        .catch((error) => {
            console.log(error);
            fetchData()
        });
};


const cardBank = (item) => {
    switch (item) {
        case 'sber':
            return 'http://127.0.0.1:5173/resources/js/assets/img/DebitCards/Sber.png'
        case 'vtb':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/Vtb.png'
        case 'alfa':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/Alfabank.png'
        case 'tinkoff':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/Tinkofа.png'
    }
}

const cardType = (item) => {
    switch (item) {
        case 'mir':
            return 'http://127.0.0.1:5173/resources/js/assets/img/DebitCards/Mir.png'
        case 'visa':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/Visa.png'
        case 'mc':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/MC.png'
    }
}


const modalCreate = () => {
    modalForCreate.value = !modalForCreate.value;
    formSubmitted.value = false;
    console.log(modalForCreate.value);
    fetchData()
};


const modalOpenPlus = (index) => {
    modalItem.value = index;
    modalPlus.value = !modalPlus.value;
    console.log(modalPlus.value);
};

const modalOpenMinus = (index) => {
    modalItem.value = index;
    modalMinus.value = !modalMinus.value;
    console.log(modalMinus.value);
};

const modalUpdate = (index) => {
    modalItem.value = index;
    modalForUpdate.value = !modalForUpdate.value;
    formSubmittedUpdated.value = false;
    console.log(modalForUpdate.value);
};


const updateData = async (item) => {
    //console.log(1111111111, item);
    dataForUpdate.bank_id = item.bank.id
    dataForUpdate.type = item.type;
    dataForUpdate.numbers = item.numbers;
    dataForUpdate.budget = item.budget;
    dataForUpdate.last_date = item.last_date;
    formSubmittedUpdated.value = true;
    console.log(2222, dataForUpdate.value.plus);
    if (!selectCategories.id) {
        selectCategories.id = item.bank.id
    }
    axios
        .put("http://127.0.0.1:8000/api/v1/budget/" + item.id, {
            bank_id: selectCategories.id,
            type: dataForUpdate.type,
            numbers: dataForUpdate.numbers,
            budget: parseFloat(dataForUpdate.budget),
            last_date: dataForUpdate.last_date,
            user_id: id

        })
        .then((response) => {
            console.log(response.data);
            formSubmittedUpdated.value = true;
            fetchData();
            //modalItem.value=null;
        })
        .catch((error) => {
            console.log(error);
        });
};

const deleteData = async (id) => {
    axios
        .delete(`http://127.0.0.1:8000/api/v1/budget/${id}`)
        .then((response) => {
            console.log(response.data);
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
};

const fetchCategories = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/bank')
        .then((response) => {
            console.log(response.data)
            banks.value = response.data.data;
            console.log(banks.value)
        })
        .catch((error) => {
            console.log(error);
        });
};

fetchCategories()


onMounted(fetchData)

</script>
