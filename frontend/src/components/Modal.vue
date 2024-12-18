<template>
    <div class="p-3 mb-2 bg-primary text-white">
        <span>{{copySuccess}}</span>
    </div>
</template>

<script setup>
    import { defineProps } from 'vue'

    const props = defineProps ({
        copySuccess: {
            type: String,
            required: true
        }
    });
    
</script>

<style lang="scss">
    .p-3.mb-2.bg-primary.text-white {
        display: block !important;
        padding: 1rem;
        border-radius: 5px;
        text-align: center;
        position: fixed;
        top: 50% !important;
        left: 50% !important;
        width: 12% !important;
        height: 6% !important;
        transform: translateX(-50%);   
        z-index: 50;
    }
</style>