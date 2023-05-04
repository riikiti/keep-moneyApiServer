<template>
    <div class="modal__select" :class="{ 'modal__select-active': showCategory}">
        <div v-if="data" class="modal__select-selected" @click="showCategories"
             :class="{ 'modal__select-active': showCategory}"><span> карта с последними цыфрами: {{data}}
              </span>
            <img
                src="../assets/img/svg/arrowBlack.svg" alt="arrow"></div>
        <div v-else class="modal__select-selected" @click="showCategories"><span>Выберите категорию</span><img
            src="../assets/img/svg/arrowBlack.svg" alt="arrow"></div>
        <div class="modal__select-list">
            <ul>
                <li v-for="budget in option" :key="budget.id" :value="budget.id"
                    @click="$emit('getSelect',budget);select(budget)">карта банка: {{ budget.bank.name}} с последними цыфрами: {{ budget.numbers }}
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
    data.value=item.numbers
    showCategories()
}


const showCategories = () => {
    showCategory.value = !showCategory.value
}

const update = () => {
    const arr = Object.values(props.option)
    arr.forEach((item) => {
        console.log(item.id === props.id)
        if (item.id === props.id) {
            console.log(item.name)
            data.numbers= item.numbers
            data.budget = item.budget
        }
    })
}
update()
onMounted(update)


</script>


