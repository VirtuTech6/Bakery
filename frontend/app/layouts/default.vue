<template>
    <div v-if="loading" class="loader-container">
        <img src="/assets/LogoNoir.png" class="loader-logo" alt="Logo" />
    </div>
    <div v-else>
        <AppHeader />
        <slot />
        <AppFooter />
    </div>
</template>

<script setup>
import AppHeader from '~/components/AppHeader.vue';
import AppFooter from '~/components/AppFooter.vue';
import { ref, onMounted } from 'vue';

const loading = ref(true);

onMounted(() => {
    setTimeout(() => {
        loading.value = false;
    }, 800); // Durée du loader avant affichage du contenu
});
</script>

<style scoped>
.loader-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #ffffff;
    z-index: 9999;
}

.loader-logo {
    width: 100px;
    height: 100px;
    animation: pulse 1.5s infinite ease-in-out;
}

@keyframes pulse {

    0%,
    100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.2);
    }
}
</style>