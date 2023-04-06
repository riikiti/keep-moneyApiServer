import {createRouter, createWebHashHistory, createWebHistory} from 'vue-router'
import Home from '../views/HomeView.vue'
import Profile from '../views/ProfileView.vue'
import Expenses from '../views/ProfileExpensesView.vue'
import Income from '../views/ProfileIncomeView.vue'
import Planning from '../views/ProfilePlanningView.vue'
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
        path: '/profile/planning',
        name: 'planning',
        component: Planning
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

export default router
