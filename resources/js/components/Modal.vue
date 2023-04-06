<template>
  <div class="modal" v-if="status">
    <div class="modal__backdrop" @click.self="$emit('modalClose')"></div>
    <div class="modal__content">
      <button class="modal__close" @click="$emit('modalClose')">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          aria-hidden="true"
          fill="none"
        >
          <path
            d="M10.5 12L0 1.5L1.5 0L12 10.5L22.5 0L24 1.5L13.5 12L24 22.5L22.5 24L12 13.5L1.5 24L0 22.5L10.5 12Z"
            fill="#888888"
          ></path>
        </svg>
      </button>
      <slot name="modalContent">

      </slot>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  status: {
    type: Boolean,
    default: false,
  },
  item: {
    type: Object,
    default:null
  },

});

const emit = defineEmits("modalClose");
</script>
