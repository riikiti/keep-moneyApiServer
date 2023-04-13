<template>
  <aside class="profile__aside">
      <div>
    <ul>
      <li>
        <router-link
          :to="{ name: 'profile' }"
          >Главная</router-link
        >
      </li>
      <li>
        <router-link
          :to="{ name: 'expenses' }"
          >Расходы</router-link
        >
      </li>
      <li>
        <router-link
          :to="{ name: 'income' }"
          >Доходы</router-link
        >
      </li>
      <li>
        <router-link
          :to="{ name: 'budget' }"
          >Бюджет</router-link
        >
      </li>
      <li>
        <router-link
          :to="{ name: 'planning' }"
          >Планирование расходов</router-link
        >
      </li>
      <li>
        <router-link
          :to="{ name: 'setting' }"
          >Настройки</router-link
        >
      </li>
      <li>
        <router-link
          :to="{ name: 'question' }"
          >Остались вопросы?</router-link
        >
      </li>
    </ul>
      </div>
      <div>
          <a @click.prevent="logout()">Выход</a>
      </div>
  </aside>
</template>

<script setup>
import { ref, defineProps, computed } from "vue";
import router from '../router/index'

const logout = ()=>{
    axios.post('/logout').then(res=>{
        localStorage.removeItem('x_xsrf_token')
        router.push({ name: 'home' });
    })
}
</script>

