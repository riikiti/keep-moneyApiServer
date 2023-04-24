<template>
<span>{{data}}</span>
    <ul>
        <li v-for="category in option" :key="category.id"  :value="category.id" @click="$emit('getSelect',category);select(category)" > {{ category.name }}</li>
    </ul>
</template>

<script setup>
import {ref} from "vue";
const data = ref(null);

const props = defineProps({
    option: {
        type: Object,
        default: false,
    },
});

const select=(item)=>{
    data.value = item.name;
}
</script>


