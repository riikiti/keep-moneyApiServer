<template>
    <div v-if="!data"><preloader></preloader></div>
    <vue-echarts v-else :option="option" ref="chart"/>
</template>

<script setup>
import {VueEcharts} from "vue3-echarts";
import Preloader from "../components/Preloader.vue";
import {onMounted, ref} from "vue";
import axios from "axios";

const data = ref(null);

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

const id = localStorage.getItem('id');

const fetchData = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/expenses/' + id)
        .then((response) => {
            // console.log(response.data.data)
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                if (res[item.category.name]) {
                    res[item.category.name] += item.checks.total_price;
                } else {
                    res[item.category.name] = item.checks.total_price;
                }
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
