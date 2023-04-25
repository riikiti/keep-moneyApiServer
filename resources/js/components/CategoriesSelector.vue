<template>
    <span>{{ data }}</span>
    <ul>
        <li v-for="category in option" :key="category.id" :value="category.id"
            @click="$emit('getSelect',category);select(category)"> {{ category.name }}
        </li>
    </ul>
</template>

<script setup>
import {onMounted, ref} from "vue";

const data = ref(null);

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


