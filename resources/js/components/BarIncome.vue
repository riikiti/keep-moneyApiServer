<template>
    <div class="bar">
        <div class="bar-select">
            <h2 class="title title--3">
                <slot name="title"></slot>
            </h2>
            <ul class="bar-select__navbar">
                <li v-for="period in periods" :key="period.id" @click="getPeriod(period)">{{ period.name }}</li>
                <categories-selector :option="period"
                                     @getSelect="getAllPeriod"
                >
                    <template v-slot:title>
                        период
                    </template>
                </categories-selector>
            </ul>
        </div>
        <div v-if="period.length===0" class="bar__empty">
            <h3 class="title title--3">
                Доходов пока нет
            </h3>
            <p>добавьте доходы для отображения графика доходов.</p>
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
let today = new Date();
const periodDate = ref(['Пон', 'Вт', 'Сре', 'Чет', 'Пят', 'Суб', 'Воск']);
const firstEnter = ref(null)

const periods = [{name: "неделя", id: 1},
    {name: "текущий месяц", id: 2},
    {name: "год", id: 3},]
const period = ref([])


const finishDate = ref(null);
const startDate = ref(null);

firstEnter.id = 1;
console.log(weekAgo.getDate() - 7, weekAgo.getMonth() + 1)

yearAgo.setFullYear(yearAgo.getFullYear() - 1);
weekAgo.setDate(weekAgo.getDate() - 7);
monthAgo.setMonth(monthAgo.getMonth() - 1);
monthAgo = monthAgo.getFullYear().toString() + "-" + (monthAgo.getMonth() + 2).toString() + "-" + 1;
weekAgo = weekAgo.getFullYear().toString() + "-" + (weekAgo.getMonth() + 1).toString() + "-" + weekAgo.getDate().toString();
yearAgo = yearAgo.getFullYear().toString() + "-" + (yearAgo.getMonth() + 1).toString() + "-" + yearAgo.getDate().toString();
today = today.getFullYear().toString() + "-" + (today.getMonth() + 1).toString() + "-" + today.getDate().toString();
console.log(weekAgo, monthAgo, yearAgo)
let lastDayCurrYear = new Date(new Date().getFullYear(), 11, 31)
let date = new Date();
let lastDayDate = new Date(date.getFullYear(), date.getMonth() + 1, 0);
const dates = ref(null);


const option = ref({
    xAxis: {
        type: 'category',
        data: periodDate.value
    },
    yAxis: {
        type: 'value'
    },
    toolbox: {
        show: true,
        feature: {

            magicType: {show: true, type: ['line', 'bar']},
            saveAsImage: {show: true}
        }
    },
    series: [
        {
            data: [],
            type: 'bar',
            itemStyle: {
                color: '#00a900'
            },
        }
    ]
});


function getDaysInMonth(year, month) {
    const date = new Date(year, month, 1);
    const days = [];
    while (date.getMonth() === month) {
        days.push(new Date(date).getDate());
        date.setDate(date.getDate() + 1);
    }
    return days;
}


function getAllMonthsInYear(year) {
    const currentDate = new Date();
    const lastYearDate = new Date(currentDate.getFullYear() - 1, currentDate.getMonth(), currentDate.getDate());

    const months = [];

    for (let d = lastYearDate; d <= currentDate; d.setMonth(d.getMonth() + 1)) {
        const month = d.getMonth() + 1;
        const year = d.getFullYear();
        const monthYear = `${year}-${month.toString().padStart(2, '0')}`;
        months.push(monthYear);
    }
    return months;
}


function getDates(startDate, endDate) {
    const dates = [];
    let currentDate = new Date(startDate);

    while (currentDate <= endDate) {
        currentDate.setDate(currentDate.getDate() + 1);
        dates.push(currentDate.toISOString().slice(0, 10));
        // console.log("current date =",currentDate)
    }
    // console.log("dates",dates)
    return dates;
}


const getPeriod = (item) => {
    newData.value = [];
    switch (item.id) {
        case 1:
            finishDate.value = weekAgo;
            dates.value = getDates(weekAgo, new Date());
            const perDate = ref([]);
            dates.value.forEach((el) => {
                perDate.value.push(el.slice(5, 10));
            })
            console.log(perDate.value)
            periodDate.value = perDate.value
            startDate.vaue = null;
            break;
        case 2:
            finishDate.value = monthAgo;
            periodDate.value = getDaysInMonth(new Date().getFullYear(), new Date().getMonth());
            startDate.vaue = lastDayDate;
            break;
        case 3:
            finishDate.value = yearAgo;
            periodDate.value = getAllMonthsInYear(new Date().getFullYear());
            console.log(periodDate.value)
            startDate.vaue = lastDayCurrYear;
            break;
    }


    axios
        .get('https://keepmoney.site/api/v1/income/' + id, {
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
            if (item.id !== 3) {
                data.value.forEach(item => {
                    console.log(333333333, item.title)
                    if (res[item.date.slice(0, 10)]) {
                        res[item.date.slice(0, 10)] += item.price;
                    } else {
                        res[item.date.slice(0, 10)] = item.price;
                    }
                });
            } else {
                data.value.forEach(item => {
                    if (res[item.date.slice(0, 7)]) {
                        res[item.date.slice(0, 7)] += item.price;
                    } else {
                        res[item.date.slice(0, 7)] = item.price;
                    }
                });
            }


            console.log("res=", res)
            const keys = Object.keys(res);
            //console.log(keys)
            console.log(data.value, newData.value)
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                newData.value.push({value: res[key], name: key})
            })

            const result = [];
            let count = 0;
            newData.value.sort((a, b) => new Date(a.name) - new Date(b.name));
            newData.value.push({value: 0, name: "0"})
            console.log(newData.value)
            console.log(periodDate.value)

            switch (item.id) {
                case 1:
                    periodDate.value.forEach((data) => {
                        console.log(data, newData.value[count].name.slice(5, 10))
                        if (newData.value[count].name === 0) {
                            return false
                        }
                        if (data === newData.value[count].name.slice(5, 10)) {
                            result.push({value: newData.value[count].value, name: newData.value[count].name})
                            count++;
                        } else {
                            result.push({value: null, name: null})
                        }
                    })
                    break;
                case 2:
                    periodDate.value.forEach((data) => {
                        //console.log(Number(data), newData.value[count].name.slice(8, 10))
                        if (newData.value[count].name === "0") {
                            return false
                        }
                        if (Number(data) === Number(newData.value[count].name.slice(8, 10))) {
                            result.push({value: newData.value[count].value, name: newData.value[count].name})
                            count++;
                        } else {
                            result.push({value: null, name: null})
                        }
                    })
                    break;
                case 3:
                    periodDate.value.forEach((data) => {
                        console.log(data, newData.value[count].name.slice(0, 7))
                        if (newData.value[count].name === "0") {
                            return false
                        }
                        if (data === newData.value[count].name.slice(0, 7)) {
                            result.push({value: newData.value[count].value, name: newData.value[count].name})
                            count++;
                        } else {
                            result.push({value: null, name: null})
                        }
                    })
                    break;
            }

            console.log("result=", result)
            setTimeout(() => {
                bar.value.setOption({
                    xAxis: {
                        type: 'category',
                        data: periodDate.value
                    },
                    toolbox: {
                        show: true,
                        feature: {

                            magicType: {show: true, type: ['line', 'bar']},
                            saveAsImage: {show: true}
                        }
                    },
                    tooltip: {
                        trigger: "item",
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: result,
                            type: 'bar',
                            itemStyle: {
                                color: '#00a900'
                            },
                        }
                    ]
                })
            }, 400);
        })
        .catch((error) => {
            console.log(error);
        });
}
getPeriod(firstEnter)

const fetchCategories = async () => {
    axios
        .get('https://keepmoney.site/api/v1/income')
        .then((response) => {
            period.value = response.data.data;
            let uniqueMonths = [];
            let id = 1;
            period.value.forEach((el) => {
                let month = el.date.slice(0, 7);
                if (!uniqueMonths.some((m) => m.name === month)) {
                    uniqueMonths.push({id: id, name: month});
                    id++;
                }
            });
            period.value = uniqueMonths;
            console.log(period.value)

        })
        .catch((error) => {
            console.log(error);
        });
};

fetchCategories()


const getAllPeriod = (item) => {
    newData.value = [];
    let dateStart = item.name + "-01";
    const date = new Date(dateStart);
    const lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
    const lastDayStr = lastDay.toString().padStart(2, "0");
    const lastDayOfMonth = dateStart.slice(0, 8) + lastDayStr;
    console.log(dateStart, "-", lastDayOfMonth); // "2023-05-31"
    const datesArray = [];
    for (let d = date; d <= new Date(lastDayOfMonth); d.setDate(d.getDate() + 1)) {
        datesArray.push(new Date(d).toISOString().slice(8, 10));
    }
    finishDate.value = monthAgo;
    periodDate.value = datesArray;
    axios
        .get('https://keepmoney.site/api/v1/income/' + id, {
            params: {
                start: dateStart,
                finish: lastDayOfMonth
            }
        })
        .then((response) => {
            // console.log(response.data.data)
            all.value = 0;
            data.value = response.data.data;
            const res = {};
            data.value.forEach(item => {

                if (res[item.date.slice(0, 10)]) {
                    res[item.date.slice(0, 10)] += item.price;
                } else {
                    res[item.date.slice(0, 10)] = item.price;
                }
                all.value += item.price;
            });

            console.log("res=", res)
            const keys = Object.keys(res);
            //console.log(keys)
            console.log(data.value, newData.value)
            keys.forEach((key, index) => {
                console.log(`${key}: ${res[key]}`);
                newData.value.push({value: res[key], name: key})
            })

            const result = [];
            let count = 0;
            newData.value.sort((a, b) => new Date(a.name) - new Date(b.name));
            newData.value.push({value: 0, name: 0})
            console.log(newData.value)
            periodDate.value.forEach((data) => {
                //console.log(Number(data), newData.value[count].name.slice(8, 10))
                if (newData.value[count].name === 0) {
                    return false
                }
                if (Number(data) === Number(newData.value[count].name.slice(8, 10))) {
                    result.push({value: newData.value[count].value, name: newData.value[count].name})
                    count++;
                } else {
                    result.push({value: null, name: null})
                }
            })
            console.log(result)
            setTimeout(() => {
                bar.value.setOption({
                    xAxis: {
                        type: 'category',
                        data: periodDate.value
                    },
                    tooltip: {
                        trigger: "item",
                    },
                    toolbox: {
                        show: true,
                        feature: {

                            magicType: {show: true, type: ['line', 'bar']},
                            saveAsImage: {show: true}
                        }
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            data: result,
                            type: 'bar',
                            itemStyle: {
                                color: '#00a900'
                            },
                        }
                    ]
                })
            }, 400);
        })
        .catch((error) => {
            console.log(error);
        });
}

</script>

<style>
</style>
