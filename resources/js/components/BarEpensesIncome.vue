<template>
    <div class="bar">
        <div class="bar-select">
            <h2 class="title title--3">
                <slot name="title"></slot>
            </h2>
            <ul class="bar-select__navbar">
                <li v-for="period in periods" :key="period.id" @click="getPeriodExpenses(period)">{{ period.name }}</li>
            </ul>
        </div>
        <div v-if="period.length===0" class="bar__empty">
            <h3 class="title title--3">
                Записей пока нет
            </h3>
            <p>добавьте расходы или доходы для отображения графика.</p>
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
    {name: "этот месяц", id: 2},
    {name: "год", id: 3},]
const period = ref([])
const resultsIncome=ref(null);
const resultsExpenses=ref(null);


const finishDate = ref(null);


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
const dates = ref(null);


const option = ref( {
    tooltip: {
        trigger: 'axis'
    },

    toolbox: {
        show: true,
        feature: {
            dataView: { show: true, readOnly: false },
            magicType: { show: true, type: ['line', 'bar'] },
            saveAsImage: { show: true }
        }
    },
    calculable: true,
    xAxis: [
        {
            type: 'category',
            // prettier-ignore
            data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        }
    ],
    yAxis: [
        {
            type: 'value'
        }
    ],
    series: [
        {
            name: 'Доходы',
            type: 'bar',
            itemStyle: {
                color: '#00a900'
            },

        },
        {
            name: 'Расходы',
            type: 'bar',
            itemStyle: {
                color: '#a90000'
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


const getPeriodExpenses = (item) => {
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
            break;
        case 2:
            finishDate.value = monthAgo;
            periodDate.value = getDaysInMonth(new Date().getFullYear(), new Date().getMonth());
            break;
        case 3:
            finishDate.value = yearAgo;
            periodDate.value = getAllMonthsInYear(new Date().getFullYear());
            console.log(periodDate.value)
            break;
    }
    axios
        .get('https://keepmoney.site/api/v1/expenses/' + id, {
            params: {
                start: finishDate.value,
            }
        })
        .then((response) => {
            // console.log(response.data.data)
            all.value = 0;
            data.value = response.data.data;
            console.log(response.data)
            const res = {};
            if (item.id !== 3) {
                data.value.forEach(item => {
                    console.log(333333333, item.checks.title)
                    if (res[item.date.slice(0, 10)]) {
                        res[item.date.slice(0, 10)] += item.checks.total_price;
                    } else {
                        res[item.date.slice(0, 10)] = item.checks.total_price;
                    }
                    all.value += item.checks.total_price;
                });
            } else {
                data.value.forEach(item => {
                    console.log(333333333, item.checks.title)
                    if (res[item.date.slice(0, 7)]) {
                        res[item.date.slice(0, 7)] += item.checks.total_price;
                    } else {
                        res[item.date.slice(0, 7)] = item.checks.total_price;
                    }
                    all.value += item.checks.total_price;
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
            resultsExpenses.value=result;
            getPeriodIncome(item);
        })
        .catch((error) => {
            console.log(error);
        });
}



const getPeriodIncome = (item) => {
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
            break;
        case 2:
            finishDate.value = monthAgo;
            periodDate.value = getDaysInMonth(new Date().getFullYear(), new Date().getMonth());
            break;
        case 3:
            finishDate.value = yearAgo;
            periodDate.value = getAllMonthsInYear(new Date().getFullYear());
            console.log(periodDate.value)
            break;
    }
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
            if (item.id !== 3) {
                data.value.forEach(item => {
                    console.log(333333333, item.title)
                    if (res[item.date.slice(0, 10)]) {
                        res[item.date.slice(0, 10)] += item.price;
                    } else {
                        res[item.date.slice(0, 10)] = item.price;
                    }
                });
            }else{
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
            resultsIncome.value=result;
            pushToBar();
        })
        .catch((error) => {
            console.log(error);
        });
}
getPeriodExpenses(firstEnter)
const fetchCategories = async () => {
    axios
        .get('https://keepmoney.site/api/v1/expenses')
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


const pushToBar=()=>{
    setTimeout(() => {
    bar.value.setOption({
        tooltip: {
            trigger: 'axis'
        },
        toolbox: {
            show: true,
            feature: {
                dataView: { show: true, readOnly: false },
                magicType: { show: true, type: ['line', 'bar'] },
                saveAsImage: { show: true }
            }
        },
        calculable: true,
        xAxis: [
            {
                type: 'category',
                // prettier-ignore
                data: periodDate.value
            }
        ],
        yAxis: [
            {
                type: 'value'
            }
        ],
        series: [
            {
                name: 'Доходы',
                type: 'bar',
                data: resultsIncome.value,
                itemStyle: {
                    color: '#00a900'
                },

            },
            {
                name: 'Расходы',
                type: 'bar',
                data: resultsExpenses.value,
                itemStyle: {
                    color: '#a90000'
                },
            }
        ]
    })
}, 400);
}


</script>

<style>
</style>
