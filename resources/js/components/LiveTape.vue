<template>
  <div class="profile__livetape">
    <div class="profile__livetape-button">
      <button class="button" @click="modalCreate()">Создать запись</button>
      <div v-if="modalForCreate">
        <Modal :status="modalForCreate" @modalClose="modalCreate()">
          <template v-slot:modalContent>
            <form class="form" @submit.prevent="modalOpen()">
              <h2 class="title title--2">Создание записи</h2>
              <div class="form__block">
                <label class="title title--3">Название</label>
                <input type="text" v-model="createData.name" required />
              </div>
              <div class="form__block">
                <label class="title title--3">Цена</label>
                <input type="text" v-model="createData.price" required />
              </div>
              <div class="form__block">
                <label class="title title--3">Магазин</label>
                <input type="text" v-model="createData.id_mag" required />
              </div>
              <div class="form__block">
                <label class="title title--3">Дата</label>
                <VueDatePicker
                  v-model="createData.date"
                  locale="ru"
                  vertical
                  :startDate="new Date()"
                  format=" dd/MM/yyyy HH:mm"
                  required
                />
              </div>
              <button class="form__btn" @click="posthData(createData)">
                Изменить
              </button>
            </form>
          </template>
        </Modal>
      </div>
    </div>
    <div class="profile__content-livetape__header">
      <h2 class="title title--2">Последние действия (live)</h2>
    </div>
    <div v-if="data == null">loading...</div>
    <ul v-else>
      <li v-for="(item, index) in data" :key="item.id" class="item">
        <div v-if="modal && modalIndex === index">
          <Modal :status="modal" :item="item" @modalClose="modalOpen()">
            <template v-slot:modalContent>
              <form class="form" @submit.prevent="modalOpen()">
                <h2 class="title title--2">Изаменение записи {{ item.id }}</h2>
                <div class="form__block">
                  <label class="title title--3">Изаменение названия</label>
                  <input type="text" v-model="item.name" />
                </div>
                <div class="form__block">
                  <label class="title title--3">Изаменение цены</label>
                  <input type="text" v-model="item.price" />
                </div>
                <div class="form__block">
                  <label class="title title--3">Изаменение магазина</label>
                  <input type="text" v-model="item.id_mag" />
                </div>
                <div class="form__block">
                  <label class="title title--3">Изаменение даты</label>
                  <VueDatePicker
                    v-model="item.date"
                    locale="ru"
                    vertical
                    :startDate="new Date()"
                    format=" dd/MM/yyyy HH:mm"
                  />
                </div>
                <button class="form__btn" @click="updateData(item.id, item)">
                  Изменить
                </button>
              </form>
            </template>
          </Modal>
        </div>
        <div class="item__content">
          <h3 class="title title--3">{{ item.name }}</h3>
          <div class="item-action">
            <button @click="modalOpen(index)" :data-item="item.id">
              <img src="../assets/img/svg/pen.svg" alt="update" />
            </button>
            <button @click="deleteData(item.id)">
              <img src="../assets/img/svg/trash.svg" alt="delete" />
            </button>
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import Modal from "../components/Modal.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { onMounted, ref } from "vue";
import axios from "axios";

const data = ref(null);
const modal = ref(false);
const modalIndex = ref(null);
const modalForCreate = ref(false);
const createData = ref([]);

const modalOpen = (index) => {
  modalIndex.value = index;
  modal.value = !modal.value;
  console.log(modal.value);
};

const modalCreate = () => {
  modalForCreate.value = !modalForCreate.value;
  console.log(modalForCreate.value);
};

const fetchData = async () => {
  axios
    .get("http://localhost:3000/items")
    .then((response) => {
      data.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};
const posthData = async (createData) => {
  axios
    .post("http://localhost:3000/items", {
        name: createData.name,
        price: createData.price,
        id_mag: createData.id_mag,
        date: createData.date,
     
    })
    .then((response) => {
      console.log(response.data);
      modalCreate();
      fetchData();
    })
    .catch((error) => {
      console.log(error);
    });
};

const deleteData = async (id) => {
  axios
    .delete(`http://localhost:3000/items/${id}`)
    .then((response) => {
      console.log(response.data);
      fetchData();
    })
    .catch((error) => {
      console.log(error);
    });
};

const updateData = async (id, item) => {
  try {
    item.date = item.date.toISOString().substring(0, 19).replace("T", " ");
  } catch {}

  axios
    .put("http://localhost:3000/items/" + id, {
      name: item.name,
      price: item.price,
      id_mag: item.id_mag,
      date: item.date,
      id: item.id,
    })
    .then((response) => {
      console.log(response.data);
      fetchData();
    })
    .catch((error) => {
      console.log(error);
    });
};

fetchData();

onMounted(fetchData, posthData, deleteData, updateData);
</script>