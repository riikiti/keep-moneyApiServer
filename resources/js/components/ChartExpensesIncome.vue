<template>
    <div class="charts">
        <div class="charts-select">
            <h2 class="title title--3">
                <slot name="title"></slot>
            </h2>
            <categories-selector :option="period"
                                 @getSelect="getPeriod"
                                 :id="3"
            >
                <template v-slot:title>
                    периуд
                </template>
            </categories-selector>
        </div>
        <div v-if="!data">
            <preloader></preloader>
        </div>
        <vue-echarts v-else :option="option" ref="chart"/>
    </div>
</template>

<script setup>
import {VueEcharts} from "vue3-echarts";
import Preloader from "../components/Preloader.vue";
import {onMounted, ref} from "vue";
import axios from "axios";
import CategoriesSelector from "../components/CategoriesSelector.vue";

let chart = ref(null);
const data = ref(null);
const all = ref(0)
const id = localStorage.getItem('id');
const newDataExpenses = ref()
const newDataIncome = ref();
let monthAgo = new Date();
let weekAgo = new Date();
let yearAgo = new Date();
let allData = [];
const firstEnter = ref(null)
firstEnter.id = 1;
const period = [{name: "неделя", id: 1},
    {name: "месяц", id: 2},
    {name: "год", id: 3},]


const finishDate = ref(null);

console.log(weekAgo.getDate() - 7, weekAgo.getMonth() + 1)

yearAgo.setFullYear(yearAgo.getFullYear() - 1);
weekAgo.setDate(weekAgo.getDate() - 7);
monthAgo.setMonth(monthAgo.getMonth() - 1);
monthAgo = monthAgo.getFullYear().toString() + "-" + (monthAgo.getMonth() + 1).toString() + "-" + monthAgo.getDate().toString();
weekAgo = weekAgo.getFullYear().toString() + "-" + (weekAgo.getMonth() + 1).toString() + "-" + weekAgo.getDate().toString();
yearAgo = yearAgo.getFullYear().toString() + "-" + (yearAgo.getMonth() + 1).toString() + "-" + yearAgo.getDate().toString();
console.log(weekAgo, monthAgo, yearAgo)


const option = ref({
    tooltip: {
        trigger: "item",
    },
    legend: {
        top: "5%",
        left: "center",
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


const getPeriodExpenses = (item) => {
    switch (item.id) {
        case 1:
            finishDate.value = weekAgo;
            break;
        case 2:
            finishDate.value = monthAgo;
            break;
        case 3:
            finishDate.value = yearAgo;
            break;
    }
    console.log(44444444, finishDate.value)
    all.value = 0;
    axios
        .get('http://127.0.0.1:8000/api/v1/expenses/' + id, {
            params: {
                start: finishDate.value,
            }
        })
        .then((response) => {
            // console.log(response.data.data)
            data.value = response.data.data;
            const res = [];
            data.value.forEach(item => {
                if (res['expenses']) {
                    res['expenses'] += item.checks.total_price;
                } else {
                    res['expenses'] = item.checks.total_price;
                }
            });
            newDataExpenses.name = 'Расходы';
            newDataExpenses.value = res['expenses'];
        })
        .catch((error) => {
            console.log(error);
        });

}


const getPeriodIncome = (item) => {
    switch (item.id) {
        case 1:
            finishDate.value = weekAgo;
            break;
        case 2:
            finishDate.value = monthAgo;
            break;
        case 3:
            finishDate.value = yearAgo;
            break;
    }
    console.log(44444444, finishDate.value)
    axios
        .get('http://127.0.0.1:8000/api/v1/income/' + id, {
            params: {
                start: finishDate.value,
            }
        })
        .then((response) => {
            // console.log(response.data.data)
            all.value = 0;
            data.value = response.data.data;
            const res = [];
            data.value.forEach(item => {
                if (res['income']) {
                    res['income'] += item.price;
                } else {
                    res['income'] = item.price;
                }
            });

            newDataIncome.name = 'Доходы';
            newDataIncome.value = res['income'];
        })
        .catch((error) => {
            console.log(error);
        });

}


const pushData = (item) => {
    chart.value.setOption({
        tooltip: {
            trigger: "item",
        },
        legend: {
            top: "5%",
            left: "center",
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

                data: item
            },
        ],
    })
}

const getPeriod = (item) => {
    allData = [];
    getPeriodExpenses(item)
    getPeriodIncome(item);
    setTimeout(()=>{
        console.log(newDataIncome.value)
        allData = [{name: newDataIncome.name, value: newDataIncome.value}, {
            name: newDataExpenses.name,
            value: newDataExpenses.value
        }];
        console.log(allData)
        pushData(allData)
    }, 300);
}

getPeriod(firstEnter.id)


</script>

<style>
</style>
