<template>
    <div class="bar">
        <div class="bar-select">
            <h2 class="title title--3">
                <slot name="title"></slot>
            </h2>
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
        <vue-echarts v-else :option="option" ref="bar"/>

    </div>
</template>

<script setup>
import {VueEcharts} from "vue3-echarts";
import {onMounted, ref} from "vue";
import Preloader from "../components/Preloader.vue";
import axios from "axios";
import CategoriesSelector from "../components/CategoriesSelector.vue";

const data = ref(null);
const id = localStorage.getItem('id');
const all = ref(0)
let bar = ref(null);
const newData = ref([])
let monthAgo = new Date();
let weekAgo = new Date();
let yearAgo = new Date();
const periodDate=ref(['Пон', 'Вт', 'Сре', 'Чет', 'Пят', 'Суб', 'Воск']);

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
    xAxis: {
        type: 'category',
        data: periodDate.value
    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            data: [120, 200, 150, 80, 70, 110, 130],
            type: 'bar'
        }
    ]
});

const fetchData = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/expenses/' + id,{ params: {
                start: finishDate.value,
            }})
        .then((response) => {
            // console.log(response.data.data)
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                console.log(333333333, item.checks.title)
                if (res[item.date]) {
                    res[item.date] += item.checks.total_price;
                } else {
                    res[item.date] = item.checks.total_price;
                }
                all.value += item.checks.total_price;
            });

            const keys = Object.keys(res);
            //console.log(keys)
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                newData.value.push({value: res[key], name: key})
            });
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                newData.value.push({value: res[key], name: key})
            });
            bar.value.setOption({
                    xAxis: {
                        type: 'category',
                        data: periodDate.value
                    },
                    tooltip: {
                        trigger: "item",
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: newData.value,
                            type: 'bar'
                        }
                    ]
                }
            )
        })
        .catch((error) => {
            console.log(error);
        });
};

const getPeriod = (item) => {
    switch (item.id) {
        case 1:
            finishDate.value = weekAgo;
            periodDate.value=['Пон', 'Вт', 'Сре', 'Чет', 'Пят', 'Суб', 'Воск'];
            break;
        case 2:
            finishDate.value = monthAgo;
            let currentDate= new Date()+1;
            let ma=currentDate.getMonth()+1

            periodDate.value=['Пон', 'Вт', 'Сре', 'Чет', 'Пят', 'Суб', 'Воск'];
            break;
        case 3:
            finishDate.value = yearAgo;
            periodDate.value=['Янв', 'Фев', 'Март', 'Апр', 'Май', 'Июнь', 'Июль','Авг', 'Сен', 'Окт', 'Нояб', 'Дек'];
            break;
    }
    console.log(44444444, finishDate.value)
    newData.value = [];
    axios
        .get('http://127.0.0.1:8000/api/v1/expenses/' + id, {
            params: {
                start: finishDate.value,
            }
        })
        .then((response) => {
            // console.log(response.data.data)
            all.value = 0;
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                console.log(333333333, item.checks.title)
                if (res[item.date]) {
                    res[item.date] += item.checks.total_price;
                } else {
                    res[item.date] = item.checks.total_price;
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
            bar.value.setOption({
                    xAxis: {
                        type: 'category',
                        data: periodDate.value
                    },
                    tooltip: {
                        trigger: "item",
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: newData.value,
                            type: 'bar'
                        }
                    ]
                }
            ).catch((error) => {
                    console.log(error);
                });
        })
}


onMounted(fetchData)
</script>

<style>
</style>
