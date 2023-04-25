<template>


    <aside class="profile__aside">
        <div>
            <div class="profile__aside-logo">
                <img src="../assets/img/keep-moneyLogo.png" alt="logo">
            </div>
            <div class="profile__aside-menu">
                <button @click="$emit('openMenu')"><img src="../assets/img/svg/arrow.svg" alt=""><img src="../assets/img/svg/arrow.svg" alt=""></button>
            </div>
            <ul>
                <li>
                    <router-link class="title title--4"
                                 :to="{ name: 'profile' }"
                    ><img src="../assets/img/svg/home.svg" alt="home">
                        <span>Главная</span>
                    </router-link
                    >
                </li>
                <li>
                    <router-link class="title title--4"
                                 :to="{ name: 'expenses' }"
                    >
                        <img src="../assets/img/svg/money2.svg" alt="money2">
                        <span>Расходы</span>
                    </router-link
                    >
                </li>
                <li>
                    <router-link class="title title--4"
                                 :to="{ name: 'income' }"

                    ><img src="../assets/img/svg/money1.svg" alt="money1">
                        <span>Доходы</span>
                    </router-link
                    >
                </li>
                <li>
                    <router-link class="title title--4"
                                 :to="{ name: 'budget' }"
                    ><img src="../assets/img/svg/wallet.svg" alt="wallet"> <span> Бюджет</span>
                    </router-link
                    >
                </li>
                <li>
                    <router-link class="title title--4"
                                 :to="{ name: 'question' }"
                    ><img src="../assets/img/svg/question.svg" alt="question">

                        <span>
                        Остались вопросы?</span>
                    </router-link
                    >
                </li>
            </ul>
        </div>
        <div>
            <a @click.prevent="logout()" class="title title--4"> <img src="../assets/img/svg/logout.svg" alt="logout"> Выход</a>
        </div>
    </aside>
</template>

<script setup>
import router from '../router/index'


const logout = () => {
    axios.post('/logout').then(res => {
        localStorage.removeItem('x_xsrf_token')
        localStorage.removeItem('id')
        router.push({name: 'home'});
    })
}


</script>

