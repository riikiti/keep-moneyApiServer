<template>
    <div v-if="!data"><preloader></preloader></div>
    <vue-echarts v-else :option="option" ref="bar"/>
</template>

<script setup>
import {VueEcharts} from "vue3-echarts";
import {onMounted, ref} from "vue";
import Preloader from "../components/Preloader.vue";
import axios from "axios";

const data = ref(null);

const option = ref({
    xAxis: {
        type: 'category',
        data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
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

const id = localStorage.getItem('id');

const fetchData = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/income/' + id)
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
