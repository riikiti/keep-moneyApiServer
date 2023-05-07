<template>
    <div class="profile__livetape">
        <div class="profile__livetape-button">
            <button class="button" @click="modalCreate()">Создать Плана</button>
            <teleport to=".modals" v-if="modalForCreate">
                <Modal :status="modalForCreate" @modalClose="modalCreate()">
                    <template v-slot:modalContent>
                        <form class="form" @submit.prevent="modalOpen()">
                            <h2 class="title title--2">Создание плана</h2>

                            <div class="form__block">
                                <label class="title title--3">Планируемое значение по карте</label>
                                <input type="number" v-model="createData.price" required/>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">Выбор карты</label>
                                <categories-selector :option="categories"
                                                     @getSelect="getSelect"
                                ></categories-selector>
                            </div>
                            <div class="form__block">
                                <label class="title title--3">На какой периуд</label>
                                <VueDatePicker
                                    v-model="createData.date"
                                    locale="ru"
                                    vertical
                                    range
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
            <h2 class="title title--2">Планирование бюджета</h2>
        </div>
        <div v-if="data == null">
            <Preloader></Preloader>
        </div>
        <ul v-else>
            <li v-for="(item, index) in data" :key="item.id" class="item">
                <teleport to=".modals" v-if="modal && modalIndex === index">
                    <Modal :status="modal" :item="item" @modalClose="modalOpen()">
                        <template v-slot:modalContent>
                            <form class="form" @submit.prevent="modalOpen()">
                                <h2 class="title title--2">Изаменение записи "{{ item.budgets.numbers }} -
                                    {{ item.budgets.bank.name }}"</h2>
                                <div class="form__block">
                                    <label class="title title--3">Изаменение цели</label>
                                    <input type="number" v-model="item.value"/>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Изаменение категории</label>
                                    <categories-selector :option="categories"
                                                         @getSelect="getSelect"
                                                         :id="item.budgets.id"
                                    ></categories-selector>
                                </div>
                                <div class="form__block">
                                    <p>Оставить старые даты: {{ item.period_start }} - {{ item.period_finish }}</p>
                                    <p>или выбрать новые даты:</p>
                                    <VueDatePicker
                                        v-model="updateDate"
                                        locale="ru"
                                        vertical
                                        range
                                        :startDate="new Date()"
                                        format="dd/MM/yyyy HH:mm"
                                    />
                                </div>


                                <button class="form__btn" @click="updateData(item)">
                                    Изменить
                                </button>
                            </form>
                        </template>
                    </Modal>
                </teleport>
                {{ getPercent(item) }}
                <div class="item__content">
                    <h3 class="title title--4">{{ item.budgets.bank.name }} - {{ item.budgets.numbers }} <span
                        class="item__persent" :class="getPercentColor() ? 'item__persent-minus' : 'item__persent-plus'">{{
                            percent
                        }} %</span></h3>

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
import CategoriesSelector from "../components/BudgetSelector.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import {onMounted, ref} from "vue";
import axios from "axios";


const data = ref(null);
const modal = ref(false);
const modalIndex = ref(null);
const modalForCreate = ref(false);
const createData = ref([]);
const categories = ref(null);
const id = localStorage.getItem('id');
const selectBudget = ref({});
const percent = ref(null)
const updateDate = ref(null);
const afterDate = ref(null);


const getSelect = (item) => {
    console.log(item.id)
    selectBudget.id = item.id
    selectBudget.budget = item.budget
}

const getPercent = (item) => {
    percent.value = 0
    if (Number(item.budgets.budget) < Number(item.budget_on_start)) {
        percent.value = ((Number(item.budgets.budget) / Number(item.budget_on_start)) * -100).toFixed(2)
    } else {
        percent.value = ((Number(item.budgets.budget) / Number(item.value)) * 100).toFixed(2)
    }
    if (Number(item.budgets.budget) === Number(item.budget_on_start)) {
        percent.value = 0
    }
}


const getPercentColor = () => {
    return percent.value < 0;
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
        .get('http://127.0.0.1:8000/api/v1/plan-budget/' + id)
        .then((response) => {
            data.value = response.data.data;
            console.log(data.value)
        })
        .catch((error) => {
            console.log(error);
        });
};
const posthData = async (createData) => {
    console.log(createData.date)
    try {
        createData.dateStart = createData.date[0].toISOString().substring(0, 19).replace("T", " ");
        createData.dateFinish = createData.date[1].toISOString().substring(0, 19).replace("T", " ");
        console.log(createData.dateStart)
        console.log(createData.dateFinish)
    } catch {
    }
    axios
        .post("http://127.0.0.1:8000/api/v1/plan-budget", {
            value: createData.price,
            budget_id: selectBudget.id,
            period_start: createData.dateStart,
            period_finish: createData.dateFinish,
            budget_on_start: selectBudget.budget,
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
        .delete(`http://127.0.0.1:8000/api/v1/plan-budget/${id}`)
        .then((response) => {
            console.log(response.data);
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
};

const updateData = async (item) => {
    console.log(updateDate)

    try {
        if (updateDate.value !== null) {
            afterDate.dateStart = updateDate.value[0].toISOString().substring(0, 19).replace("T", " ");
            afterDate.dateFinish = updateDate.value[1].toISOString().substring(0, 19).replace("T", " ");
            console.log(111, afterDate)
            if (!selectBudget.id) {
                selectBudget.id = item.budgets.id;
            }
            axios
                .put("http://127.0.0.1:8000/api/v1/plan-budget/" + item.id, {
                    value: item.value,
                    budget_id: selectBudget.id,
                    period_start: afterDate.dateStart,
                    period_finish: afterDate.dateFinish,
                    user_id: id,
                    budget_on_start: item.budget_on_start,
                })
                .then((response) => {
                    console.log(response.data);
                    fetchData();
                })
                .catch((error) => {
                    console.log(error);
                });

        } else {
            console.log(222, afterDate)
            afterDate.dateStart = item.period_start;
            afterDate.dateFinish = item.period_finish;
            console.log(222, afterDate)


            if (!selectBudget.id) {
                selectBudget.id = item.budgets.id;
            }
            console.log(afterDate.value)
            console.log(111111111111, selectBudget)
            axios
                .put("http://127.0.0.1:8000/api/v1/plan-budget/" + item.id, {
                    value: item.value,
                    budget_id: selectBudget.id,
                    period_start: afterDate.dateStart,
                    period_finish: afterDate.dateFinish,
                    user_id: id,
                    budget_on_start: item.budget_on_start,
                })
                .then((response) => {
                    console.log(response.data);
                    fetchData();
                })
                .catch((error) => {
                    console.log(error);
                });
        }


    } catch (err) {
        console.log(err)
    }


};

fetchData();

const fetchCategories = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/budget/' + id)
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
