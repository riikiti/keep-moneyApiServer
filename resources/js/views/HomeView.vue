<template>
  <div class="home">
    <HeaderHome></HeaderHome>
    <nav style="margin-top: 100px">
      <router-link :to="{name:'profile'}">profile</router-link>
    </nav>
  </div>
</template>

<script setup>

import HeaderHome from "../components/HeaderHome.vue";

</script>


