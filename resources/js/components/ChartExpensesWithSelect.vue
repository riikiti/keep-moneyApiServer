<template>

    <div class="charts ">
        <div class="charts-select">
            <h2 class="title title--3">
                <slot name="title"></slot>
            </h2>
            <categories-selector :option="categories"
                                 @getSelect="getSelect"
            >
                <template v-slot:title>
                    категория
                </template>
            </categories-selector>
            <categories-selector :option="period"
                                 @getSelect="getPeriod"
                                 :id="1"
            >
                <template v-slot:title>
                    периуд
                </template>
            </categories-selector>
        </div>
        <div v-if="!data">
            <preloader></preloader>
        </div>

        <vue-echarts v-else :option="option" ref="chart" class="ChartExpensesWithSelect"/>
        <h4 class="title title--4">Всего: {{ all }} р.
        </h4>
    </div>
</template>

<script setup>
import {VueEcharts} from "vue3-echarts";
import Preloader from "../components/Preloader.vue";
import {onMounted, ref} from "vue";
import axios from "axios";
import CategoriesSelector from "../components/CategoriesSelector.vue";

const data = ref(null);
const all = ref(0)
const categories = ref();
const selectCategories = ref({});
const id = localStorage.getItem('id');
let chart = ref(null);
const newData = ref([])
let monthAgo = new Date();
let weekAgo = new Date();
let yearAgo = new Date();

const period = [{name: "неделя", id: 1},
    {name: "месяц", id: 2},
    {name: "год", id: 3},]


const finishDate = ref(null);
const startDate = ref(null);
console.log(weekAgo.getDate() - 7,weekAgo.getMonth()+1)

yearAgo.setFullYear(yearAgo.getFullYear() - 1);
weekAgo.setDate(weekAgo.getDate() - 7);
monthAgo.setMonth(monthAgo.getMonth() - 1);
monthAgo = monthAgo.getFullYear().toString() + "-" + (monthAgo.getMonth()+1).toString() + "-" + monthAgo.getDate().toString();
weekAgo = weekAgo.getFullYear().toString() + "-" + (weekAgo.getMonth()+1).toString() + "-" + weekAgo.getDate().toString();
yearAgo = yearAgo.getFullYear().toString() + "-" + (yearAgo.getMonth()+1).toString() + "-" + yearAgo.getDate().toString();
console.log(weekAgo, monthAgo, yearAgo)
let lastDayCurrYear = new Date( new Date().getFullYear(), 11, 31 )
let date = new Date();
let lastDayDate = new Date(date.getFullYear(), date.getMonth() + 1, 0);
const option = ref({
    tooltip: {
        trigger: "item",
    },
    series: [
        {
            name: "Значение:",
            type: "pie",
            radius: ["40%", "70%"],
            avoidLabelOverlap: false,
            label: {
                show: false,
                position: "center",
            },
            emphasis: {
                label: {
                    show: true,
                    fontSize: 40,
                    fontWeight: "bold",
                },
            },
            labelLine: {
                show: false,
            },

            data: [],
        },
    ],
});


const getPeriod = (item) => {
    switch (item.id) {
        case 1:
            finishDate.value = weekAgo;
            startDate.vaue= null;
            break;
        case 2:
            finishDate.value = monthAgo;
            startDate.vaue=lastDayDate;
            break;
        case 3:
            finishDate.value = yearAgo;
            startDate.vaue=lastDayCurrYear;
            break;
    }
    console.log(44444444,finishDate.value)
    let category=ref(null);
    if (selectCategories.id) {
        category.value = null;
    } else {
        category.value = selectCategories.id
    }
    newData.value = [];
    axios
        .get('https://keepmoney.site/api/v1/expenses/' + id, {
            params: {
                category: selectCategories.id,
                start:finishDate.value,
                finish: startDate.vaue
            }
        })
        .then((response) => {
            // console.log(response.data.data)
            all.value = 0;
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                console.log(333333333, item.checks.title)
                if (res[item.checks.title]) {
                    res[item.checks.title] += item.checks.total_price;
                } else {
                    res[item.checks.title] = item.checks.total_price;
                }
                all.value += item.checks.total_price;
            });

            const keys = Object.keys(res);
            //console.log(keys)
            console.log(data.value, newData.value)
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                newData.value.push({value: res[key], name: key})

            });
            chart.value.setOption({
                tooltip: {
                    trigger: "item",
                },
                series: [
                    {
                        name: "Значение:",
                        type: "pie",
                        radius: ["40%", "70%"],
                        avoidLabelOverlap: false,
                        label: {
                            show: false,
                            position: "center",
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: 40,
                                fontWeight: "bold",
                            },
                        },
                        labelLine: {
                            show: false,
                        },

                        data: newData.value,
                    },
                ],
            })
        })
        .catch((error) => {
            console.log(error);
        });

}


const getSelect = (item) => {
    console.log(item.id)
    selectCategories.id = item.id
    selectCategories.name = item.name
    const finish=ref(null);
    if (!finishDate.value) {
        finish.value = null
    }else {
        finish.value=finishDate.value;
    }

    newData.value = [];
    axios
        .get('https://keepmoney.site/api/v1/expenses/' + id, {
            params: {
                category: selectCategories.id,
                start:finish.value,
                finish: startDate.vaue
            }
        })
        .then((response) => {
            // console.log(response.data.data)
            all.value = 0;
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                console.log(333333333, item.checks.title)
                if (res[item.checks.title]) {
                    res[item.checks.title] += item.checks.total_price;
                } else {
                    res[item.checks.title] = item.checks.total_price;
                }
                all.value += item.checks.total_price;
            });

            const keys = Object.keys(res);
            //console.log(keys)
            console.log(data.value, newData.value)
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                newData.value.push({value: res[key], name: key})

            });
            chart.value.setOption({
                tooltip: {
                    trigger: "item",
                },

                series: [
                    {
                        name: "Значение:",
                        type: "pie",
                        radius: ["40%", "70%"],
                        avoidLabelOverlap: false,
                        label: {
                            show: false,
                            position: "center",
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: 40,
                                fontWeight: "bold",
                            },
                        },
                        labelLine: {
                            show: false,
                        },

                        data: newData.value,
                    },
                ],
            })
        })
        .catch((error) => {
            console.log(error);
        });


}

const fetchData = async () => {
    finishDate.value = weekAgo;
    startDate.vaue = null;
    axios
        .get('https://keepmoney.site/api/v1/expenses/' + id, {
            params: {
                start: finishDate.value,
                finish: startDate.vaue
            }
        })
        .then((response) => {
            // console.log(response.data.data)
            all.value = 0;
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                if (res[item.checks.title]) {
                    res[item.checks.title] += item.checks.total_price;
                } else {
                    res[item.checks.title] = item.checks.total_price;
                }
                all.value += item.checks.total_price;
            });

            const keys = Object.keys(res);
            //console.log(keys)
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                option.value.series[0].data.push({value: res[key], name: key})
            });
        })
        .catch((error) => {
            console.log(error);
        });
};


const fetchCategories = async () => {
    axios
        .get('https://keepmoney.site/api/v1/categories')
        .then((response) => {
            categories.value = response.data.data;
            categories.value.push({id:0,name:'все'});
            console.log(categories.value);
            fetchData();
        })
        .catch((error) => {
            console.log(error);
        });
};


fetchCategories()


onMounted(fetchData, fetchCategories)
</script>

<style>
</style>
