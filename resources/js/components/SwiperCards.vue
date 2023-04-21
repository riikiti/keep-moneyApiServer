<template>
    <swiper :slides-per-view="1" :modules="modules" :pagination="true" :grab-cursor="true" class="swiper">
        <swiper-slide v-for="item in data" :key="item.id">
            <div class="bank-card__wrap">
                <div class="bank-card__content" :style="{ color: item.bank.text_color , background: item.bank.color }">
                    <div class="bank-card__name">{{ item.bank.name }}</div>
                    <div class="bank-card__numbers"><span>**** **** **** {{ item.numbers }}</span></div>
                    <div class="bank-card__budget">
                        <span> на счету: {{ item.budget }} </span>
                    </div>
                    <div class="bank-card__info">
                        <span> м/г: {{ Math.floor(item.last_date / 100) + "/" + (item.last_date % 100) }}</span>
                        <span class="bank-card__type">{{ item.type }}</span>
                        <img :src="cardType(item.bank.name)" :alt="item.bank.name">
                    </div>
                </div>
            </div>
        </swiper-slide>
    </swiper>
</template>

<script setup>
import {Swiper, SwiperSlide} from "swiper/vue";
import {Navigation, Pagination, Scrollbar, A11y} from "swiper";
import "swiper/css";
import 'swiper/css/pagination';
import axios from "axios";
import {onMounted, ref} from "vue";

const modules = [Pagination, Navigation, Scrollbar, A11y];

const data = ref(null);
const id = localStorage.getItem('id');

const fetchData = async () => {
    axios
        .get('http://127.0.0.1:8000/api/v1/budget/' + id)
        .then((response) => {
            // console.log(response.data.data)
            data.value = response.data.data;
            console.log(data.value)
        })
        .catch((error) => {
            console.log(error);
        });
};


const cardType = (item) => {

    switch (item) {
        case 'sber':
            return '../assets/img/DebitCards/Sber.png'
        case 'vtb':
            return '../assets/img/DebitCards/Vtb.png'
        case 'alfa':
            return '../assets/img/DebitCards/Alfabank.png'
        case 'tinkoff':
            return '../assets/img/DebitCards/Tinkofа.png'
    }
}
onMounted(fetchData)

</script>
