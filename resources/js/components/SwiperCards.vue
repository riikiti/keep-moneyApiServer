<template>
    <swiper :slides-per-view="1" :modules="modules" :pagination="true" :grab-cursor="true" class="swiper" v-if="data">
        <swiper-slide v-for="item in data" :key="item.id">
            <div class="bank-card__wrap">
                <div class="bank-card__content" :style="{ color: item.bank.text_color , background: item.bank.color }">
                    <img :src="cardBank(item.bank.name)" :alt="item.bank.name" class="bank-card__bank">
                    <div class="bank-card__numbers"><span>**** **** **** {{ item.numbers }}</span></div>
                    <div class="bank-card__date">
                        <span> м/г: {{ Math.floor(item.last_date / 100) + "/" + (item.last_date % 100) }}</span>
                    </div>
                    <div class="bank-card__info">
                        <span> на счету: {{ item.budget }} р. </span>
                        <img :src="cardType(item.type)" :alt="item.type" class="bank-card__type">
                    </div>
                </div>
            </div>
        </swiper-slide>
    </swiper>
    <div v-else>loading...</div>
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
const type = ref(null);
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


const cardBank = (item) => {
    switch (item) {
        case 'sber':
            return 'http://127.0.0.1:5173/resources/js/assets/img/DebitCards/Sber.png'
        case 'vtb':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/Vtb.png'
        case 'alfa':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/Alfabank.png'
        case 'tinkoff':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/Tinkofа.png'
    }
}

const cardType = (item) => {
    switch (item) {
        case 'mir':
            return 'http://127.0.0.1:5173/resources/js/assets/img/DebitCards/Mir.png'
        case 'visa':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/Visa.png'
        case 'mc':
            return 'http://127.0.0.1:5173/resources/js//assets/img/DebitCards/MC.png'
    }
}

onMounted(fetchData)

</script>
