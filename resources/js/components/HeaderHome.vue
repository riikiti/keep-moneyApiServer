<template>
    <div class="header">
        <teleport to=".modals">
            <modal :status="modal" @modalClose="modalOpen()" v-if="!reg">
                <template v-slot:modalContent>
                    <form class="form">
                        <h2 class="title title--2">Авторизация</h2>
                        <div class="form__block">
                            <label class="title title--3">Почта</label>
                            <input type="email" required v-model="AuthEmail" placeholder="Введите почту"/>
                        </div>
                        <div class="form__block">
                            <label class="title title--3">Пароль</label>
                            <input type="password" required v-model="AuthPass" placeholder="Введите пароль"/>
                            <span v-show="error">не правильно набрана почта или пароль</span>
                        </div>
                        <button class="form__btn" @click.prevent="login()">Авторизоваться</button>
                        <p class="form__tree">
                            Нет аккаунта? <a @click="registration()">Зарегистрируйтесь!</a>
                        </p>
                    </form>
                </template>
            </modal
            >
            <modal :status="modal" @modalClose="modalOpen()" v-else>
                <template v-slot:modalContent>
                    <form class="form">
                        <h2 class="title title--2">Регистрация</h2>
                        <div class="form__block">
                            <label class="title title--3">Логин</label>
                            <input
                                type="text"
                                placeholder="Введите логин"
                                v-model="formDate.login"
                            />
                            <span v-show="v$.login.$error">Слишком маленький логин</span>
                        </div>
                        <div class="form__block">
                            <label class="title title--3">Почта</label>
                            <input
                                type="mail"
                                placeholder="Введите вашу почту"
                                v-model="formDate.email"
                            />
                            <span v-show="v$.email.$error">Не правильно введена почта</span>
                        </div>
                        <div class="form__block">
                            <label class="title title--3">Пароль</label>
                            <input
                                type="password"
                                placeholder="Введите пароль"
                                v-model="formDate.password"
                            />
                            <span v-show="v$.password.$error">Пароль слишком короткий</span>
                        </div>
                        <div class="form__block">
                            <label class="title title--3">Подтвердите пароль</label>
                            <input
                                type="password"
                                placeholder="Введите пароль"
                                v-model="formDate.confirmpass"
                            />
                            <span v-show="v$.confirmpass.$error">Пароли не совпадают</span>
                        </div>
                        <button type="submit" class="form__btn" @click.prevent="submitForm()">
                            Зарегистрироваться
                        </button>
                        <p class="form__tree">
                            Есть аккаунт? <a @click="registration()">Авторизируйтесь!</a>
                        </p>
                    </form>
                </template>
            </modal
            >
        </teleport>
        <div class="header__content">
            <img src="../assets/img/keep-moneyLogoBlack.png" alt="logo">
            <button @click="modalOpen()" class="button">Авторизация</button>
        </div>
    </div>
</template>

<script setup>
import {ref, reactive, computed} from "vue";
import {useVuelidate} from "@vuelidate/core";
import {required, email, minLength, sameAs} from "@vuelidate/validators";
import Modal from "../components/Modal.vue";
import axios from "axios";
import router from '../router/index'

const reg = ref(false);
const error=ref(false);

const registration = () => {
    reg.value = !reg.value;
};


let modal = ref(false);
const modalOpen = () => {
    modal.value = !modal.value;
};


//validation
const formDate = reactive({
    login: "",
    email: "",
    password: "",
    confirmpass: "",
});

const rules = computed(() => {
    return {
        login: {required, minLength: minLength(2)},
        email: {required, email},
        password: {required, minLength: minLength(8)},
        confirmpass: {required, sameAs: sameAs(formDate.password)},
    };
});

const v$ = useVuelidate(rules, formDate);

const submitForm = async () => {
    const result = await v$.value.$validate();
    if (result) {
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/register', {
                name: formDate.login.toString(),
                email: formDate.email.toString(),
                password: formDate.password.toString(),
                password_confirmation: formDate.confirmpass.toString()
            }).then(response => {
                console.log(response);
                localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);
                router.push({name: 'profile'});

                axios.get('https://keepmoney.site/api/v1/users/' + JSON.parse(response.config.data).email).then(response => {
                    console.log("id =",response.data.id);
                    localStorage.setItem('id', response.data.id);
                })

            })
        })
    }
};


//sanctum

const AuthEmail = ref('');
const AuthPass = ref('');

const login = () => {
    axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/login', {
            email: AuthEmail.value.toString(),
            password: AuthPass.value.toString()
        }).then(response => {
            //console.log(response.config.headers['X-XSRF-TOKEN']);

            console.log(JSON.parse(response.config.data).email);
            axios.get('https://keepmoney.site/api/v1/users/' + JSON.parse(response.config.data).email).then(response => {
                console.log("id=",response.data.id);
                localStorage.setItem('id', response.data.id);
            })
            localStorage.setItem('x_xsrf_token', response.config.headers['X-XSRF-TOKEN']);
            router.push({name: 'profile'});
        }).catch(err => {
            console.log(err.response)
            error.value=true
        })
    });

}


</script>
