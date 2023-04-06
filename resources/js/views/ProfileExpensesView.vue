<template>

  <div class="profile">
    <div class="profile__header">
      <h1>Расходы</h1>
    </div>
    <ProfileAside></ProfileAside>
    <div class="profile__content">
      <div class="profile__content-charts"></div>
    </div>
    <live-tape></live-tape>
  </div>
</template>


<script setup>
import ProfileAside from "../components/PortfolioAside.vue";
import LiveTape from "../components/LiveTape.vue";

</script>


