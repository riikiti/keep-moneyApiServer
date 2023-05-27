<template>
    <div class="accordion" @click="openAccordion()" :class="{ 'accordion__active': open }">
        <div class="accordion__title">
            <h2 class="title title--3">
                <slot name="title">

                </slot>
            </h2>
            <div class="accordion__title-close">
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="accordion__content">
            <p class="title title--4">
                <slot name="content">

                </slot>
            </p>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";

const open = ref(false);


const openAccordion = () => {
    open.value = !open.value;
}

</script>


