import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router'
import Home from '../views/HomeView.vue'
import Profile from '../views/ProfileView.vue'
import Expenses from '../views/ProfileExpensesView.vue'
import Income from '../views/ProfileIncomeView.vue'
import Setting from '../views/ProfileSettingView.vue'
import Question from '../views/ProfileQuestionView.vue'
import Budget from '../views/ProfileBudgetView.vue'
import Admin from '../views/AdminView.vue'

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
    {
        path: '/profile/admin',
        name: 'admin',
        component: Admin
    },



]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('x_xsrf_token')
    const admin = localStorage.getItem('admin')

    if (!token) {
        if (to.name === 'profile' || to.name === 'expenses' || to.name === 'income' ||  to.name === 'setting' || to.name === 'question' || to.name === 'budget') {
            return next({name: 'home'})
        }
        if (!admin) {
            if (to.name === 'admin') {
                return next({name: 'home'})
            }
        }
    } else {
        if (to.name === 'home') {
            return next({name: 'profile'})
        }
        if (!admin) {
            if (to.name === 'admin') {
                return next({name: 'profile'})
            }
        }
    }
    next()


    if (!admin) {
        if (to.name === 'admin') {
            return next({name: 'home'})
        }
    } else {
        if (to.name === 'admin') {
            return next({name: 'profile'})
        }
    }
    next()
})

export default router
