<template>
    <div class="profile__livetape">
        <div class="profile__livetape-button">
            <button class="button" @click="modalCreate()">Создать запись</button>
            <teleport to=".modals" v-if="modalForCreate">
                <Modal :status="modalForCreate" @modalClose="modalCreate()">
                    <template v-if="!formSubmitted" v-slot:modalContent>
                        <div v-if="categoriesBudget.length>0">
                            <form class="form" @submit.prevent="modalOpen()">
                                <h2 class="title title--2">Создание записи</h2>
                                <div class="form__block">
                                    <label class="title title--3">Название</label>
                                    <input type="text" v-model="createData.title"/>
                                    <span class="form__block-info">если поле пустое, будет записано  "Категория дата"</span>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Список покупок</label>
                                    <ul class="form__block-lists">
                                        <li v-for="item in items" :key="item.id">
                                            <p>Название:</p> <input type="text" v-model="item.name">
                                            <p>Цена:</p><input type="number" placeholder="1000" min="0" v-model="item.price"
                                                               @blur='totalPriceSum()'>
                                            <p>р.</p>
                                            <p>Кол-во:</p> <input type="number" placeholder="1" min="1" v-model="item.count"
                                                                  @blur='totalPriceSum()'>
                                            <p>шт.</p>
                                            <div class="form__block-lists__delete" @click="removeItem(item.id)">
                                                <img src="../assets/img/svg/exit.svg" alt="exit">
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="form__block-lists__add" @click="addItem()"> + добавить новую запись
                                    </div>
                                    <div class="form__block-price">
                                        <label class="title title--3">Итоговая цена: </label>
                                        <p>{{ totalPrice }} р.</p>
                                    </div>
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
                                    <span v-show="v1$.id.$error">не выбрана категория</span>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Карта</label>
                                    <budget-selector :option="categoriesBudget"
                                                     @getSelect="getSelectBudget"
                                    ></budget-selector>
                                    <span v-show="v1$.id.$error">не выбрана карта</span>
                                </div>
                                <div class="form__block">
                                    <label class="title title--3">Дата</label>
                                    <VueDatePicker
                                        v-model="createData.date"
                                        timezone="UTC"
                                        locale="ru"
                                        vertical
                                        :startDate="new Date()"
                                        format=" dd/MM/yyyy HH:mm"
                                        required
                                    />
                                    <span v-show="v$.date.$error">не выбрана дата</span>
                                </div>
                                <button class="form__btn" @click="posthData(createData);"
                                        :disabled="isButtonDisabled">
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
                                <p>для создания расходов, создайте карту</p>
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
            <h2 class="title title--2">Траты</h2>
        </div>


        <div class="profile__livetape-content">
            <div v-if="data == null">
                <Preloader></Preloader>
            </div>
            <ul v-else>
                <li v-for="(item, index) in data" :key="item.id" class="item">

                    <teleport to=".modals" v-if="modal && modalIndex === index">
                        <Modal :status="modal" :item="item" @modalClose="modalOpen()">
                            <template v-if="!formSubmittedUpdated" v-slot:modalContent>
                                {{ getItemsUpdate(item.checks.id) }}
                                {{ totalPriceSumUpdate() }}
                                {{ memberOldValue(totalPriceUpdate, item.budget.id,item) }}
                                <form class="form" @submit.prevent="modalOpen()">
                                    <h2 class="title title--2">Изаменение записи "{{ item.checks.title }}"</h2>
                                    <div class="form__block">
                                        <label class="title title--3">Название</label>
                                        <input type="text" v-model="item.checks.title" required/>
                                        <span class="form__block-info">если поле пустое, будет записано  "Категория дата"</span>
                                    </div>
                                    <div class="form__block">
                                        <label class="title title--3">Список покупок</label>
                                        <ul class="form__block-lists">

                                            <li v-for="el in getItemsNew" :key="item.id">
                                                <p>Название:</p> <input type="text" v-model="el.name">
                                                <p>Цена:</p><input type="number" placeholder="1000" min="0" v-model="el.price"
                                                                   @blur='totalPriceSumUpdateItem()'>
                                                <p>р.</p>
                                                <p>Кол-во:</p> <input type="number" placeholder="1" min="1" v-model="el.count"
                                                                      @blur='totalPriceSumUpdateItem()'>
                                                <p>шт.</p>
                                                <div class="form__block-lists__delete"
                                                     @click="removeItemUpdate(el.id);deleteItem(el.id)">
                                                    <img src="../assets/img/svg/exit.svg" alt="exit">
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="form__block-lists__add" @click="addItemUpdate()"> + добавить новую
                                            запись
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
                                        <label class="title title--3">Дата</label>
                                        <VueDatePicker
                                            v-model="item.date"
                                            locale="ru"
                                            vertical
                                            :startDate="new Date()"
                                            format=" dd/MM/yyyy HH:mm"
                                            required
                                        />
                                    </div>
                                    <button class="form__btn"
                                            @click.prevent="updateData(item.id, item); ">
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
                        <h3 class="title title--4">{{ item.checks.title }}</h3>
                        <div class="item-action">
                            <button @click="modalOpen(index)" :data-item="item.id">
                                <img src="../assets/img/svg/pen.svg" alt="update"/>
                            </button>
                            <button @click="deleteData(item.id,item)">
                                <img src="../assets/img/svg/trash.svg" alt="delete"/>
                            </button>
                        </div>
                    </div>
                </li>
                <div v-if="links.total===0" class="profile__livetape-content__nothing">
                    <h3 class="title title--3">
                        Затрат пока нет
                    </h3>
                </div>
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
import {computed, onMounted, ref} from "vue";
import axios from "axios";
import BudgetSelector from "../components/BudgetSelector.vue";
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
const updateBudget = ref(null);
const categoriesBudget = ref(null);
const id = localStorage.getItem('id');
const selectCategories = ref({});
const selectBudget = ref({});
const items = ref([]);
const item = ref('');
const totalPrice = ref(0)
const totalPriceUpdate = ref(0)
const checkId = ref(null);
const getItems = ref([]);
const getItemsNew = ref([]);
const formSubmitted = ref(false);
const formSubmittedUpdated = ref(false);
const closeCircle = ref(true);
let count = 1

let oldPrice = [];
let oldId = [];


const emit = defineEmits("addExpenses");

const rules = computed(() => {
    return {
        date: {required}
    };
});

const rules1 = computed(() => {
    return {
        id: {required}
    };
});


const isButtonDisabled = computed(() => {
    return items.value.length === 0
})

const v$ = useVuelidate(rules, createData.value);
const v1$ = useVuelidate(rules1, selectCategories.value);
const v2$ = useVuelidate(rules1, selectBudget.value);

const memberOldValue = (price, id,item) => {
    if (closeCircle.value) {
        console.log(price, id)
        oldPrice.push(Number(item.checks.total_price));
        oldId.push(Number(id));
    }
    closeCircle.value = false
}


const addItem = () => {
    items.value.push({name: '', price: 0, count: 1, id: count});
    count++;
}

const addItemUpdate = () => {
    getItemsNew.value.push({name: '', price: 0, count: 1, id: count, newItem: true});
    count++;
}


const deleteItem = (id) => {
    axios
        .delete(`https://keepmoney.site/api/v1/item/${id}`)
        .then((response) => {
            console.log(response.data);

        })
        .catch((error) => {
            console.log(error);
        });
}


const getItemsUpdate = (id) => {
    if (closeCircle.value) {
        getItems.value.forEach((el) => {
            console.log(el)
            if (el.id === id) {
                console.log(el.items)
                getItemsNew.value = el.items;
            }
        })
        closeCircle.value = false
    }
}

const totalPriceSum = () => {
    totalPrice.value = 0
    items.value.forEach((el) => {
        console.log(el.price)
        totalPrice.value += Number(el.price) * Number(el.count);
    })
}


const totalPriceSumUpdate = () => {
    if (closeCircle.value) {
        totalPriceUpdate.value = 0
        getItemsNew.value.forEach((el) => {
            console.log(el.price)
            totalPriceUpdate.value += Number(el.price) * Number(el.count);
        })
        closeCircle.value = false
    }
}

const totalPriceSumUpdateItem = () => {

    totalPriceUpdate.value = 0
    getItemsNew.value.forEach((el) => {
        console.log(el.price)
        totalPriceUpdate.value += Number(el.price) * Number(el.count);
    })
    closeCircle.value = false
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
    selectCategories.value.id = item.id
    selectCategories.name = item.name
    console.log(selectCategories.id)
}

const getSelectBudget = (item) => {
    console.log(item.id)
    selectBudget.value.id = item.id
    selectBudget.budget = item.budget
    console.log(selectBudget.id)
}

const modalOpen = (index) => {
    modalIndex.value = index;
    modal.value = !modal.value;
    console.log(modal.value);
    formSubmitted.value = false;
    formSubmittedUpdated.value = false;
    selectCategories.id = null;
    selectBudget.id = null;
    closeCircle.value = true
};
const modalCreate = () => {
    selectCategories.id = null;
    selectBudget.id = null;
    modalForCreate.value = !modalForCreate.value;
    console.log(modalForCreate.value);
    formSubmitted.value = false;
    closeCircle.value = true
};
const fetchData = async (page) => {
    if (!page) {
        page = 1;
    }
    axios
        .get('https://keepmoney.site/api/v1/expenses/' + id, {params: {page: page, paginate: true, per_page: 5}})
        .then((response) => {
            data.value = response.data.data;
           // data.value.reverse();
            links.value = response.data.meta
            current_page.value = response.data.meta.current_page;
            console.log(links.value)
            data.value.forEach((el) => {
                getItems.value.push(el.checks)
                //console.log(getItems.value)
            })
        })
        .catch((error) => {
            console.log(error);
        });
};
const posthData = async (create) => {

    const result = await v$.value.$validate();
    const result1 = await v1$.value.$validate();
    const result2 = await v2$.value.$validate();
    if (result && result1 && result2) {
        console.log("log1", selectCategories.value.id, selectBudget.value.id)
        try {
            create.date = create.date.toISOString().substring(0, 19).replace("T", " ");
            console.log(create)
        } catch {
        }
        if (!create.title) {
            create.title = selectCategories.name.toString() + " " + create.date.slice(0, 11);
        }
        totalPriceSum()
        console.log(create.title, totalPrice, create.date)
        axios
            .post("https://keepmoney.site/api/v1/check", {
                title: create.title,
                total_price: totalPrice.value,

            })
            .then((response) => {
                // console.log(response.data);
                checkId.value = response.data.id;
                console.log(checkId.value)
                formSubmitted.value = true;
                console.log(items.value);
                items.value.forEach((el) => {
                    console.log(el.name, el.price, el.count, checkId.value);
                    axios
                        .post("https://keepmoney.site/api/v1/item", {
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

                console.log('log', id, checkId.value, selectCategories.value.id, selectBudget.value.id, create.date)
                axios
                    .post("https://keepmoney.site/api/v1/expenses", {
                        user_id: id,
                        check_id: checkId.value,
                        categories_id: selectCategories.value.id,
                        budget_id: selectBudget.value.id,
                        date: create.date,
                    })
                    .then((response) => {
                        console.log(response.data);
                        formSubmitted.value = true;
                        emit('addExpenses')
                        //modalCreate()
                        fetchData()
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            })
            .catch((error) => {
                console.log(error);
            });

        //update budget
        categoriesBudget.value.forEach((el) => {
            if (el.id === selectBudget.value.id) {
                updateBudget.value = el;
            }
        })
        console.log(totalPrice.value)
        updateBudget.value.budget -= Number(totalPrice.value);
        console.log(updateBudget.value, updateBudget.value.budget)
        axios
            .put("https://keepmoney.site/api/v1/budget/" + selectBudget.value.id, {
                bank_id: updateBudget.value.bank.id,
                type: updateBudget.value.type,
                numbers: updateBudget.value.numbers,
                budget: parseFloat(updateBudget.value.budget),
                last_date: updateBudget.value.last_date,
                user_id: id

            })
            .then((response) => {
                console.log(333333, response.data);
                formSubmitted.value = true;
                createData.value = [];
                items.value = [];
                totalPrice.value = 0;
            })
            .catch((error) => {
                console.log(error);
            });


    }
};
const deleteData = async (id, item) => {
    axios
        .delete(`https://keepmoney.site/api/v1/expenses/${id}`)
        .then((response) => {
            console.log(response.data);
            fetchData();
            emit('addExpenses')
        })
        .catch((error) => {
            console.log(error);
        });

    axios
        .delete(`https://keepmoney.site/api/v1/check/${item.checks.id}`)
        .then((response) => {
            console.log(response.data);
        })
        .catch((error) => {
            console.log(error);
        });


    try {
        item.value.checks.items.forEach((el) => {
            axios
                .delete(`https://keepmoney.site/api/v1/item/${el.id}`)
                .then((response) => {
                    console.log(response.data);

                })
                .catch((error) => {
                    console.log(error);
                });
        })
    } catch (err) {
        console.log(err)
    }


};
const updateData = async (item_id, item) => {
    try {
        item.date = item.date.toISOString().substring(0, 19).replace("T", " ");
        console.log(item.date)
    } catch {
    }
    console.log(item);
    console.log(66666666, selectCategories.id, selectCategories.value.id)
    if (selectCategories.value.id === null) {
        selectCategories.value.id = item.category.id
        console.log(66666666, selectCategories.id, selectCategories.value.id)
    }


    closeCircle.value = true
    totalPriceSumUpdate()

    categories.value.forEach((el) => {
        if (el.id === selectCategories.id || !selectCategories.value.id) {
            selectCategories.name = el.name;
        }
    })

    if (!item.checks.title) {
        item.checks.title = selectCategories.name + " " + item.date.slice(0, 11);
    }


    if (!selectBudget.value.id) {
        selectBudget.value.id = item.budget.id
        if (selectCategories.value.id === null) {
            selectCategories.value.id = item.category.id
            console.log(66666666, selectCategories.id, selectCategories.value.id)
        }
        axios
            .put("https://keepmoney.site/api/v1/check/" + item.checks.id, {
                title: item.checks.title,
                total_price: totalPriceUpdate.value,

            })
            .then((response) => {
                console.log(response.data);
                //checkId.value = response.data.id;
//todo что делать если один из item был удален?(вызывать  deleteData() в самом списке items, поменявь в делетеДата на удаление item)
// todo сделать totalPriceUpdate чтобы небыл равен 0
                getItemsNew.value.forEach((el) => {
                    console.log(el);

                    if (el.newItem === true) {
                        console.log(11111111111111, el, checkId.value)
                        axios
                            .post("https://keepmoney.site/api/v1/item", {
                                name: el.name,
                                price: Number(el.price),
                                count: Number(el.count),
                                check_id: Number(item.checks.id)
                            })
                            .then((response) => {
                                console.log(response.data);
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    } else {

                        axios
                            .put("https://keepmoney.site/api/v1/item/" + el.id, {
                                name: el.name,
                                price: Number(el.price),
                                count: Number(el.count),
                                check_id: Number(el.check_id)
                            })
                            .then((response) => {
                                console.log(response.data);

                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                })
                oldPrice[0]=item.checks.total_price
                console.log("item price", item.checks.total_price, "old price", oldPrice)
                console.log(77777777777, selectCategories.value.id, selectBudget.value.id)

                axios
                    .put("https://keepmoney.site/api/v1/expenses/" + item.id, {
                        user_id: id,
                        check_id: item.checks.id,
                        categories_id: selectCategories.value.id,
                        budget_id: selectBudget.value.id,
                        date: item.date,
                    })
                    .then((response) => {
                        console.log(response.data);
                        formSubmittedUpdated.value = true;
                        emit('addExpenses')
                        fetchData()
                    })
                    .catch((error) => {
                        console.log(error);
                    });

                axios
                    .put("https://keepmoney.site/api/v1/increase-budget/" + selectBudget.value.id, {
                        update_budget: oldPrice[0],
                    })
                    .then((response) => {
                        console.log(response.data);
                        oldPrice = [];
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                axios
                    .put("https://keepmoney.site/api/v1/reduse-budget/" + selectBudget.value.id, {
                        update_budget: totalPriceUpdate.value,
                    })
                    .then((response) => {
                        console.log(response.data);
                        oldPrice = [];
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            })
            .catch((error) => {
                console.log(error);
            });


    } else {
        if (selectCategories.value.id === null) {
            selectCategories.value.id = item.category.id
            console.log(666666665, selectCategories.id, selectCategories.value.id)
        }
        if (!selectCategories.value.id) {
            selectCategories.value.id = item.category.id
            console.log(666666667, selectCategories.id, selectCategories.value.id)
        }
        axios
            .put("https://keepmoney.site/api/v1/check/" + item.checks.id, {
                title: item.checks.title,
                total_price: totalPriceUpdate.value,

            })
            .then((response) => {
                console.log(response.data);
                //checkId.value = response.data.id;
//todo что делать если один из item был удален?(вызывать  deleteData() в самом списке items, поменявь в делетеДата на удаление item)
// todo сделать totalPriceUpdate чтобы небыл равен 0
                getItemsNew.value.forEach((el) => {
                    console.log(el);

                    if (el.newItem === true) {
                        console.log(11111111111111, el, checkId.value)
                        axios
                            .post("https://keepmoney.site/api/v1/item", {
                                name: el.name,
                                price: Number(el.price),
                                count: Number(el.count),
                                check_id: Number(item.checks.id)
                            })
                            .then((response) => {
                                console.log(response.data);
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    } else {

                        axios
                            .put("https://keepmoney.site/api/v1/item/" + el.id, {
                                name: el.name,
                                price: Number(el.price),
                                count: Number(el.count),
                                check_id: Number(el.check_id)
                            })
                            .then((response) => {
                                console.log(response.data);

                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    }
                })
                console.log(666666666666, selectCategories.value.id, selectCategories.id, selectBudget.value.id)
                console.log(888888, oldId[0])
                oldId[0] = item.budget.id;
                oldPrice[0]=item.checks.total_price
                console.log(888888, oldId[0])
                console.log("item price", item.checks.total_price, "old price", oldPrice[0])

                axios
                    .put("https://keepmoney.site/api/v1/expenses/" + item.id, {
                        user_id: id,
                        check_id: item.checks.id,
                        categories_id: selectCategories.value.id,
                        budget_id: selectBudget.value.id,
                        date: item.date,
                    })
                    .then((response) => {
                        console.log(response.data);
                        formSubmittedUpdated.value = true;
                        emit('addExpenses')
                        fetchData()
                    })
                    .catch((error) => {
                        console.log(error);
                    });

                axios
                    .put("https://keepmoney.site/api/v1/increase-budget/ " + oldId[0], {
                        update_budget: oldPrice[0],
                    })
                    .then((response) => {
                        console.log(response.data);
                        oldPrice = [];
                        oldId = [];
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                axios
                    .put("https://keepmoney.site/api/v1/reduse-budget/" + selectBudget.value.id, {
                        update_budget: totalPriceUpdate.value,
                    })
                    .then((response) => {
                        console.log(response.data);
                        oldPrice = [];
                        oldId = [];
                    })
                    .catch((error) => {
                        console.log(error);
                    });


            })
            .catch((error) => {
                console.log(error);
            });

    }


};


fetchData();
const fetchCategories = async () => {
    axios
        .get('https://keepmoney.site/api/v1/categories', {params: {page: 1, paginate: true, per_page: 25}})
        .then((response) => {
            categories.value = response.data.data;
            console.log(categories.value)
        })
        .catch((error) => {
            console.log(error);
        });
};

fetchCategories()


const fetchCategoriesBudget = async () => {
    axios
        .get('https://keepmoney.site/api/v1/budget/' + id)
        .then((response) => {
            categoriesBudget.value = response.data.data;
            console.log(categoriesBudget.value)
        })
        .catch((error) => {
            console.log(error);
        });
};

fetchCategoriesBudget()

onMounted(fetchData, posthData, deleteData, updateData, fetchCategories, fetchCategoriesBudget);
</script>


