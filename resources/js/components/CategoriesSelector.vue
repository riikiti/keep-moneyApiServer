<template>
    <div class="modal__select" :class="{ 'modal__select-active': showCategory}">
        <div v-if="data" class="modal__select-selected" @click="showCategories"
             :class="{ 'modal__select-active': showCategory}"><span> {{ data }}</span>
            <img
                src="../assets/img/svg/arrowBlack.svg" alt=""></div>
        <div v-else class="modal__select-selected" @click="showCategories"><span>Выберите категорию</span><img
            src="../assets/img/svg/arrowBlack.svg" alt=""></div>

        <div class="modal__select-list">
            <ul>
                <li v-for="category in option" :key="category.id" :value="category.id"
                    @click="$emit('getSelect',category);select(category)"> {{ category.name }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";

const data = ref(null);
const showCategory = ref(false);

const props = defineProps({
    option: {
        type: Object,
        default: false,
    },
    id: {
        type: Number,
        default: 0
    },
});

const select = (item) => {
    data.value = item.name;
    showCategories()
}


const showCategories = () => {
    showCategory.value = !showCategory.value
}

const update = () => {
    console.log(props.id)
    console.log(props.option)
    const arr = Object.values(props.option)
    arr.forEach((item) => {
        console.log(item.id === props.id)
        if (item.id === props.id) {
            console.log(item.name)
            data.value = item.name
        }
    })
}
update()
onMounted(update)


</script>


