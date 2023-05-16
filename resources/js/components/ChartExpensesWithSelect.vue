<template>

    <div class="charts ">
        <div class="charts-select">
            <h2 class="title title--3">
                <slot name="title"></slot>
            </h2>
            <categories-selector :option="categories"
                                 @getSelect="getSelect"
            ></categories-selector>
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

console.log(chart)

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


const getSelect = (item) => {
    console.log(item.id)
    selectCategories.id = item.id
    selectCategories.name = item.name
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

                data: [{
                    name:123,value:123
                }],
            },
        ],
    })
}

const fetchData = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/expenses/' + id)
        .then((response) => {
            // console.log(response.data.data)
            all.value = 0;
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                if (res[item.category.name]) {
                    res[item.category.name] += item.checks.total_price;
                } else {
                    res[item.category.name] = item.checks.total_price;
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
        .get('http://127.0.0.1:8000/api/v1/categories')
        .then((response) => {
            categories.value = response.data.data;
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
