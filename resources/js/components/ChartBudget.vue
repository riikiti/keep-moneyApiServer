<template>
    <div class="charts">

        <div class="charts-select">
            <h2 class="title title--3">
                <slot name="title"></slot>
            </h2>
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
import Preloader from "../components/Preloader.vue";
import {onMounted, ref} from "vue";
import axios from "axios";

const data = ref(null);
const all = ref(0)

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
            labelLine: {
                show: false,
            },
            data: [],
        },
    ],
});

const id = localStorage.getItem('id');

const fetchData = async () => {
    axios
        .get('https://keepmoney.site/api/v1/budget/' + id)
        .then((response) => {
            // console.log(response.data.data)
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                if (res[item.numbers]) {
                    res["Карта: " + item.bank.name +"-"+ item.numbers] += item.budget;
                } else {
                    res["Карта: " + item.bank.name +"-"+ item.numbers] = item.budget;
                }
                all.value += item.budget;
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
