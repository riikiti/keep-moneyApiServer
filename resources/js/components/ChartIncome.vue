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
        <h4 class="title title--4">Всего: {{ all }} р.</h4>
    </div>
</template>

<script setup>
import {VueEcharts} from "vue3-echarts";
import {onMounted, ref} from "vue";
import Preloader from "../components/Preloader.vue";
import axios from "axios";
import CategoriesSelector from "../components/CategoriesSelector.vue";

const data = ref(null);
const all = ref(0)

let chart = ref(null);
const newData = ref([])
let monthAgo = new Date();
let weekAgo = new Date();
let yearAgo = new Date();
const id = localStorage.getItem('id');
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


const getPeriod = (item) => {
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
    newData.value = [];
    axios
        .get('https://keepmoney.site/api/v1/income/' + id, {
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
                if (res[item.category.name]) {
                    res[item.category.name] += item.price;
                } else {
                    res[item.category.name] = item.price;
                }
                all.value += item.price;
            });

            const keys = Object.keys(res);
            //console.log(keys)
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                newData.value.push({value: res[key], name: key})
            });
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
    axios
        .get('https://keepmoney.site/api/v1/income/' + id)
        .then((response) => {
            // console.log(response.data.data)
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                if (res[item.category.name]) {
                    res[item.category.name] += item.price;
                } else {
                    res[item.category.name] = item.price;
                }
                all.value += item.price;
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

onMounted(fetchData)
</script>

<style>
</style>
