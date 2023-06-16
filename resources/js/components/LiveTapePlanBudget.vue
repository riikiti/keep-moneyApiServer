<template>
    <div class="profile__livetape">
        <div class="profile__livetape-button">
            <button class="button" @click="modalCreate()">Создать Плана</button>
            <teleport to=".modals" v-if="modalForCreate">
                <Modal :status="modalForCreate" @modalClose="modalCreate()">
                    <template v-if="!formSubmitted" v-slot:modalContent>
                        <div v-if="categories.length>0">
                            <form class="form" @submit.prevent="modalOpen()">
                                <h2 class="title title--2">Создание плана</h2>
                                <div class="form__block">
                                    <label class="title title--3">Комментарий</label>
                                    <input type="text" v-model="createData.title"/>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Планируемое значение по карте</label>
                                    <input type="number" v-model="createData.price" required/>
                                    <span v-show="v$.price.$error">укажите количество денег</span>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Выбор карты</label>
                                    <categories-selector :option="categories"
                                                         @getSelect="getSelect"
                                    >
                                        <template v-slot:title>
                                            Выберите карту
                                        </template>
                                    </categories-selector>
                                    <span v-show="v1$.id.$error">не выбрана карта</span>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">На какой период</label>
                                    <VueDatePicker
                                        v-model="createData.date"
                                        locale="ru"
                                        vertical
                                        range
                                        :startDate="new Date()"
                                        format=" dd/MM/yyyy HH:mm"
                                        required
                                    />
                                    <span v-show="v$.date.$error">не выбрана дата</span>
                                </div>
                                <button class="form__btn" @click="posthData(createData)">
                                    Создать
                                </button>
                            </form>
                        </div>
                        <div v-else>
                            <div class="form__submitted">
                                <div class="form__submitted-logo">
                                    <img src="../assets/img/svg/x.png" alt="error">
                                </div>
                                <h2 class="title title--2">Карты отсутсвуют</h2>
                                <p>для создания плана, создайте карту</p>
                                <button class="form__btn" @click="modalCreate()">
                                    Закрыть
                                </button>
                            </div>
                        </div>
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
            <h2 class="title title--2">Планирование бюджета</h2>
        </div>
        <div class="profile__livetape">
            <div class="profile__livetape-content">
                <div v-if="data == null">
                    <Preloader></Preloader>
                </div>
                <ul v-else>
                    <li v-for="(item, index) in data" :key="item.id" class="item">
                        <teleport to=".modals" v-if="modal && modalIndex === index">
                            <Modal :status="modal" :item="item" @modalClose="modalOpen()">
                                <template v-if="!formSubmittedUpdated" v-slot:modalContent>
                                    <form class="form" @submit.prevent="modalOpen()">
                                        <h2 class="title title--2">Изаменение записи "{{ item.budgets.numbers }} -
                                            {{ item.budgets.bank.name }}"</h2>
                                        <div class="form__block">
                                            <label class="title title--3">Комментарий</label>
                                            <input type="text" v-model="item.title"/>
                                        </div>
                                        <div class="form__block">
                                            <label class="title title--3">Изаменение цели</label>
                                            <input type="number" v-model="item.value"/>
                                        </div>
                                        <div class="form__block">
                                            <label class="title title--3">Изаменение категории</label>
                                            <categories-selector :option="categories"
                                                                 @getSelect="getSelect"
                                                                 :id="item.budgets.id"
                                            >
                                                <template v-slot:title>
                                                    Выберите карту
                                                </template>
                                            </categories-selector>
                                        </div>
                                        <div class="form__block">
                                            <p>Оставить старые даты: {{ item.period_start }} - {{
                                                    item.period_finish
                                                }}</p>
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


                                        <button class="form__btn" @click.prevent="updateData(item);">
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
                            <h3 class="title title--4">{{ item.budgets.bank.name }} - {{ item.budgets.numbers }} </h3>

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
                    <div v-if="links.total===0" class="profile__livetape-content__nothing">
                        <h3 class="title title--3">
                            Планов пока нет
                        </h3>
                    </div>
                </ul>
                <div class="profile__livetape-pagination" v-if="links && links.last_page>1">
                    <div class="profile__livetape-pagination__wrap-item" v-if="current_page!==1"
                         @click="fetchData(Number(current_page-1))"><img src="../assets/img/svg/arrowBlack.svg"
                                                                         alt="arrow">
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
    </div>
</template>

<script setup>
import Modal from "../components/Modal.vue";
import Preloader from "../components/Preloader.vue";
import CategoriesSelector from "../components/BudgetSelector.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import {computed, onMounted, ref} from "vue";
import axios from "axios";
import {minLength, required} from "@vuelidate/validators";
import {useVuelidate} from "@vuelidate/core";


const data = ref(null);
const links = ref(null);
const current_page = ref(null);
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
const formSubmitted = ref(false);
const formSubmittedUpdated = ref(false);

const emit = defineEmits("addPlan");

const rules = computed(() => {
    return {
        price: {required, minLength: minLength(2)},
        date: {required}
    };
});

const rules1 = computed(() => {
    return {
        id: {required}
    };
});


const v$ = useVuelidate(rules, createData.value);
const v1$ = useVuelidate(rules1, selectBudget.value);

const getSelect = (item) => {
    console.log(item.id)
    selectBudget.value.id = item.id
    selectBudget.budget = item.budget
}



const modalOpen = (index) => {
    modalIndex.value = index;
    modal.value = !modal.value;
    console.log(modal.value);
    formSubmitted.value = false;
    formSubmittedUpdated.value = false;
    selectBudget.value.id = null;
};

const modalCreate = () => {
    modalForCreate.value = !modalForCreate.value;
    console.log(modalForCreate.value);
    formSubmitted.value = false;
    formSubmittedUpdated.value = false;
    selectBudget.value.id = null;
};

const fetchData = async (page) => {
    if (!page) {
        page = 1;
    }
    axios
        .get('https://keepmoney.site/api/v1/plan-budget/' + id, {params: {page: page, paginate: true, per_page: 5}})
        .then((response) => {
            data.value = response.data.data;
            data.value.reverse();
            links.value = response.data.meta
            current_page.value = response.data.meta.current_page;
            console.log(links.value)
            console.log(data.value)
        })
        .catch((error) => {
            console.log(error);
        });
};
const posthData = async (create) => {

    const result = await v$.value.$validate();
    const result1 = await v1$.value.$validate();
    if (result && result1) {

        console.log(create.date)
        try {
            create.dateStart = create.date[0].toISOString().substring(0, 19).replace("T", " ");
            create.dateFinish = create.date[1].toISOString().substring(0, 19).replace("T", " ");
            console.log(create.dateStart)
            console.log(create.dateFinish)
        } catch {
        }
        console.log(selectBudget)
        if (!create.title) {
            create.title = selectBudget.budget.toString() + " " + create.dateStart.slice(0, 11) + " - " + create.dateFinish.slice(0, 11);
        }


        axios
            .post("https://keepmoney.site/api/v1/plan-budget", {
                title: create.title,
                value: create.price,
                budget_id: selectBudget.value.id,
                period_start: create.dateStart,
                period_finish: create.dateFinish,
                budget_on_start: selectBudget.budget,
                user_id: id
            })
            .then((response) => {
                console.log(response.data);
                formSubmitted.value = true;
                createData.value = [];
                //modalCreate();
               emit('addPlan')
                fetchData();
            })
            .catch((error) => {
                console.log(error);
            });
    }
};

const deleteData = async (id) => {
    axios
        .delete(`https://keepmoney.site/api/v1/plan-budget/${id}`)
        .then((response) => {
            console.log(response.data);
            fetchData();
            emit('addPlan')
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
            if (!selectBudget.value.id) {
                selectBudget.value.id = item.budgets.id;
            }
            if (!item.title) {
                item.title = item.budgets.bank.name + " " + afterDate.dateStart.slice(0, 11) + " - " + afterDate.dateFinish.slice(0, 11);
            }
            axios
                .put("https://keepmoney.site/api/v1/plan-budget/" + item.id, {
                    title: item.title,
                    value: item.value,
                    budget_id: selectBudget.value.id,
                    period_start: afterDate.dateStart,
                    period_finish: afterDate.dateFinish,
                    user_id: id,
                    budget_on_start: item.budget_on_start,
                })
                .then((response) => {
                    console.log(response.data);
                    formSubmittedUpdated.value = true;
                    fetchData();
                    emit('addPlan')
                })
                .catch((error) => {
                    console.log(error);
                });

        } else {
            console.log(222, afterDate)
            afterDate.dateStart = item.period_start;
            afterDate.dateFinish = item.period_finish;
            console.log(222, afterDate)
            if (!item.title) {
                item.title = item.budgets.bank.name + " " + afterDate.dateStart.slice(0, 11) + " - " + afterDate.dateFinish.slice(0, 11);
            }

            if (!selectBudget.value.id) {
                selectBudget.value.id = item.budgets.id;
            }
            console.log(afterDate.value)
            console.log(111111111111, selectBudget)
            axios
                .put("https://keepmoney.site/api/v1/plan-budget/" + item.id, {
                    title: item.title,
                    value: item.value,
                    budget_id: selectBudget.value.id,
                    period_start: afterDate.dateStart,
                    period_finish: afterDate.dateFinish,
                    user_id: id,
                    budget_on_start: item.budget_on_start,
                })
                .then((response) => {
                    console.log(response.data);
                    formSubmittedUpdated.value = true;
                    emit('addPlan')
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
        .get('https://keepmoney.site/api/v1/budget/' + id)
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
