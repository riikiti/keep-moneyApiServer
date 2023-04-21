<template>
  <aside class="profile__aside">
      <div>
    <ul>
      <li>
        <router-link class="title title--4"
          :to="{ name: 'profile' }"
          >Главная</router-link
        >
      </li>
      <li>
        <router-link class="title title--4"
          :to="{ name: 'expenses' }"
          >Расходы</router-link
        >
      </li>
      <li>
        <router-link class="title title--4"
          :to="{ name: 'income' }"
          >Доходы</router-link
        >
      </li>
      <li>
        <router-link class="title title--4"
          :to="{ name: 'budget' }"
          >Бюджет</router-link
        >
      </li>
      <li>
        <router-link class="title title--4"
          :to="{ name: 'question' }"
          >Остались вопросы?</router-link
        >
      </li>
    </ul>
      </div>
      <div>
          <a @click.prevent="logout()" class="title title--4">Выход</a>
      </div>
  </aside>
</template>

<script setup>
import { ref, defineProps, computed } from "vue";
import router from '../router/index'

const logout = ()=>{
    axios.post('/logout').then(res=>{
        localStorage.removeItem('x_xsrf_token')
        localStorage.removeItem('id')
        router.push({ name: 'home' });
    })
}
</script>

