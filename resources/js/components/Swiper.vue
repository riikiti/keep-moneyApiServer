<template>
  <swiper :slides-per-view="1.1"  :modules="modules" :pagination="true" :grab-cursor="true" class="swiper">
    <swiper-slide
      ><div class="credit-card visa selectable">
        <div class="credit-card-last4"><span>4242</span></div>
        <div class="credit-card-total">На счете: 123</div>
        <div class="credit-card-expiry">08/25</div>
        <div class="credit-card-logo">
          <img src="../assets/img/DebitCards/mir.png" alt="mir" />
        </div>
      </div>
    </swiper-slide>
    <swiper-slide
      ><div class="credit-card visa selectable">
        <div class="credit-card-last4"><span>4242</span></div>
        <div class="credit-card-total">На счете: 123</div>
        <div class="credit-card-expiry">08/25</div>
        <div class="credit-card-logo">
          <img src="../assets/img/DebitCards/MasterCard.png" alt="mir" />
        </div>
      </div>
    </swiper-slide>
    <swiper-slide
      ><div class="credit-card visa selectable">
        <div class="credit-card-last4"><span>4242</span></div>
        <div class="credit-card-total">На счете: 123</div>
        <div class="credit-card-expiry">08/25</div>
        <div class="credit-card-logo">
          <img src="../assets/img/DebitCards/Visa.png" alt="mir" />
        </div>
      </div>
    </swiper-slide>
  </swiper>
</template>

<script setup >
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Pagination, Scrollbar, A11y } from "swiper";

import "swiper/css";
import 'swiper/css/pagination';

const modules = [Pagination, Navigation, Scrollbar, A11y];
</script>
