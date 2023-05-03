import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router'
import Home from '../views/HomeView.vue'
import Profile from '../views/ProfileView.vue'
import Expenses from '../views/ProfileExpensesView.vue'
import Income from '../views/ProfileIncomeView.vue'
import Setting from '../views/ProfileSettingView.vue'
import Question from '../views/ProfileQuestionView.vue'
import Budget from '../views/ProfileBudgetView.vue'

const routes = [

    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile
    },
    {
        path: '/profile/expenses',
        name: 'expenses',
        component: Expenses
    },
    {
        path: '/profile/income',
        name: 'income',
        component: Income
    },
    {
        path: '/profile/setting',
        name: 'setting',
        component: Setting
    },
    {
        path: '/profile/question',
        name: 'question',
        component: Question
    },
    {
        path: '/profile/budget',
        name: 'budget',
        component: Budget
    },


]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token')

    if (!token) {
        if (to.name === 'profile' || to.name === 'expenses' || to.name === 'income' ||  to.name === 'setting' || to.name === 'question' || to.name === 'budget') {
            return next({name: 'home'})
        }
    } else {
        if (to.name === 'home') {
            return next({name: 'profile'})
        }
    }
    next()
})

export default router
