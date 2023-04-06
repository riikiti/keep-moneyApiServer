<template>
  <div v-if="!data">loading...</div>
  <vue-echarts v-else :option="option"  ref="chart" />
</template>

<script setup>
import { VueEcharts } from "vue3-echarts";
import { onMounted, ref } from "vue";
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
      data: [
      ],
    },
  ],
});


const fetchData = async () => {
  axios
    .get("http://localhost:3000/items")
    .then((response) => {
      data.value = response.data;
      data.value.forEach((el) => {
       option.value.series[0].data.push({value:el.price,name:el.name})
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