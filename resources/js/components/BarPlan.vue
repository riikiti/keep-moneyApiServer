<template>
    <div class="bar">
        <div class="bar-select">
            <h2 class="title title--3">
                <slot name="title"></slot>
            </h2>
        </div>
        <div v-if="!data">
            <preloader></preloader>
        </div>
        <vue-echarts v-else :option="option" ref="bar"/>

        <div v-if="data.length===0" class="bar__empty">
            <h3 class="title title--3">
                Графика планов пока нет
            </h3>
            <p>добавьте план для отображения графика.</p>
        </div>


    </div>
</template>

<script setup>
import {VueEcharts} from "vue3-echarts";
import {onMounted, ref} from "vue";
import Preloader from "../components/Preloader.vue";
import axios from "axios";

const data = ref(null);
const bar = ref()
const status = ref(false);
let periodsTitle = [];
let periodValue = [];

const option = ref({
    tooltip: {
        trigger: 'axis',
        axisPointer: {
            type: 'shadow'
        }
    },
    grid: {
        top: 30,
        bottom: 30
    },
    xAxis: {
        type: 'value',
        position: 'top',
        splitLine: {
            lineStyle: {
                type: 'dashed'
            }
        }
    },
    yAxis: {
        type: 'category',
        axisLine: {show: false},
        axisLabel: {show: false},
        axisTick: {show: false},
        splitLine: {show: false},
        data: [
            'ten',
            'nine',
            'eight',
            'seven',
            'six',
            'five',
            'four',
            'three',
            'two',
            'one'
        ]
    },
    series: [
        {
            name: 'Значение:',
            type: 'bar',
            stack: 'Total',
            label: {
                show: true,
                formatter: '{b}'
            },
            data: [
                -0.07,
                -0.09,
                0.2,
                0.44,
                -0.23,
                0.08,
                -0.17,
                0.47,
                -0.36,
                0.18
            ]
        }
    ]
});

const id = localStorage.getItem('id');


const fetchData = async () => {

    axios
        .get('https://keepmoney.site/api/v1/plan-budget/' + id)
        .then((response) => {
            status.value=true;
            // console.log(response.data.data)
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {
                console.log(item)
                if (item.budget_on_start > item.budgets.budget) {
                    res[item.budgets.bank.name + " " + item.budgets.numbers + " Цель:" + item.value] = -item.budgets.budget / (item.budget_on_start);
                } else {
                    res[item.budgets.bank.name + " " + item.budgets.numbers + " Цель:" + item.value] = item.budgets.budget / item.value;
                }
            });

            const keys = Object.keys(res);
            //console.log(keys)
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                periodsTitle.push(key)
                periodValue.push((res[key]).toFixed(2));
            });

            setTimeout(() => {
                bar.value.setOption({
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            type: 'shadow'
                        }
                    },
                    grid: {
                        top: 30,
                        bottom: 30
                    },
                    xAxis: {
                        type: 'value',
                        position: 'top',
                        splitLine: {
                            lineStyle: {
                                type: 'dashed'
                            }
                        }
                    },
                    yAxis: {
                        type: 'category',
                        axisLine: {show: false},
                        axisLabel: {show: false},
                        axisTick: {show: false},
                        splitLine: {show: false},
                        data: periodsTitle
                    },
                    series: [
                        {
                            name: 'Значение:',
                            type: 'bar',
                            stack: 'Total',
                            label: {
                                show: true,
                                formatter: '{b}'
                            },
                            data: periodValue
                        }
                    ]
                }, 2000);
                periodsTitle = [];
                periodValue = [];
            })
        })
        .catch((error) => {
            console.log(error);
            status.value=false;
        });
};

onMounted(fetchData)
</script>

<style>
</style>
