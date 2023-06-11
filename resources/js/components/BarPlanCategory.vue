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
    </div>
</template>

<script setup>
import {VueEcharts} from "vue3-echarts";
import {onMounted, ref} from "vue";
import Preloader from "../components/Preloader.vue";
import axios from "axios";

const data = ref(null);
const bar = ref()
const id = localStorage.getItem('id');

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
        data: []
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
            data: []
        }
    ]
});


const fetchData = async () => {

    let periodsTitle = [];
    let periodValue = [];
    let plans = [];
    axios
        .get('http://37.140.195.93/api/v1/plan/' + id)
        .then((response) => {
            console.log(response.data.data)
            data.value = response.data.data;
            data.value.forEach((el) => {
                plans.push({
                    category: el.category.id,
                    max_price: el.max_price,
                    start: el.period_start,
                    finish: el.period_finish
                })
            })
            console.log("plans", plans)
            plans.forEach((plan) => {
                axios
                    .get('http://37.140.195.93/api/v1/expenses/' + id, {
                        params: {
                            start: plan.start,
                            finish: plan.finish,
                            category: plan.category
                        }
                    })
                    .then((response) => {
                        console.log(response.data.data)
                        data.value = response.data.data;
                        const res = {};
                        let name = "";
                        console.log(plan.max_price)
                        data.value.forEach(item => {
                            console.log(item.checks.total_price)
                            if (res[item.category.name + " - " + plan.max_price]) {
                                res[item.category.name + " - " + plan.max_price] += item.checks.total_price / plan.max_price;
                            } else {
                                res[item.category.name + " - " + plan.max_price] = item.checks.total_price / plan.max_price;
                            }
                            name = item.category.name + " - " + plan.max_price;
                        });
                        console.log("res: ", res)

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
                            }, 400);

                        })
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            })

        })
        .catch((error) => {
            console.log(error);
        });
};


onMounted(fetchData)
</script>

<style>
</style>
